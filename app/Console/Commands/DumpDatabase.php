<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DumpDatabase extends Command
{
    protected $signature = 'dump:database {--format=sql : Export format (sql or json)} {--output= : Output file path} {--tables=* : Specific tables to dump}';
    protected $description = 'Dump all database data to SQL or JSON format';

    public function handle(): int
    {
        $format = $this->option('format');
        $outputPath = $this->option('output');
        $specificTables = $this->option('tables');

        if (!in_array($format, ['sql', 'json'])) {
            $this->error('Format must be "sql" or "json"');
            return Command::FAILURE;
        }

        // Get all tables or specific ones
        if ($specificTables) {
            $tables = $specificTables;
        } else {
            $tables = DB::select("
                SELECT tablename FROM pg_tables 
                WHERE schemaname = 'public' 
                AND tablename NOT LIKE 'pg_%' 
                AND tablename NOT LIKE 'sql_%'
            ");
            $tables = array_column($tables, 'tablename');
        }
        
        // Filter out migration table and pivot tables if needed
        $tables = array_filter($tables, function ($table) {
            return !in_array($table, ['migrations', 'personal_access_tokens', 'password_reset_tokens', 'failed_jobs', 'job_batches', 'cache', 'cache_locks', 'sessions']);
        });

        $this->info("Dumping {$format} for " . count($tables) . " tables...");

        $output = $format === 'sql' ? $this->dumpSql($tables) : $this->dumpJson($tables);

        if ($outputPath) {
            file_put_contents($outputPath, $output);
            $this->info("Dump saved to: {$outputPath}");
        } else {
            $this->line($output);
        }

        return Command::SUCCESS;
    }

    private function dumpSql(array $tables): string
    {
        $sql = "-- Database dump generated at " . now()->toDateTimeString() . "\n";
        $sql .= "-- Tables: " . implode(', ', $tables) . "\n\n";

        foreach ($tables as $table) {
            $columns = Schema::getColumnListing($table);
            
            // Skip tables with no columns
            if (empty($columns)) {
                continue;
            }

            $rows = DB::table($table)->get()->toArray();
            
            if (empty($rows)) {
                $sql .= "-- Table {$table} is empty\n\n";
                continue;
            }

            $sql .= "-- Table: {$table}\n";
            $sql .= "TRUNCATE TABLE \"{$table}\" RESTART IDENTITY CASCADE;\n\n";

            $columnList = '"' . implode('", "', $columns) . '"';
            
            foreach ($rows as $row) {
                $values = [];
                foreach ($columns as $col) {
                    $value = $row->$col ?? null;
                    if ($value === null) {
                        $values[] = 'NULL';
                    } elseif (is_bool($value)) {
                        $values[] = $value ? 'TRUE' : 'FALSE';
                    } elseif (is_numeric($value)) {
                        $values[] = $value;
                    } else {
                        // Escape single quotes
                        $escaped = str_replace("'", "''", (string) $value);
                        $values[] = "'{$escaped}'";
                    }
                }
                $sql .= "INSERT INTO \"{$table}\" ({$columnList}) VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }

        return $sql;
    }

    private function dumpJson(array $tables): string
    {
        $data = [
            'generated_at' => now()->toDateTimeString(),
            'tables' => [],
        ];

        foreach ($tables as $table) {
            $columns = Schema::getColumnListing($table);
            
            if (empty($columns)) {
                continue;
            }

            $rows = DB::table($table)->get()->toArray();
            
            $data['tables'][$table] = [
                'columns' => $columns,
                'count' => count($rows),
                'data' => array_map(function ($row) use ($columns) {
                    $result = [];
                    foreach ($columns as $col) {
                        $result[$col] = $row->$col ?? null;
                    }
                    return $result;
                }, $rows),
            ];
        }

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}