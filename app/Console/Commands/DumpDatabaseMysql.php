<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DumpDatabaseMysql extends Command
{
    protected $signature = 'dump:database-mysql {--output= : Output file path} {--tables=* : Specific tables to dump}';

    protected $description = 'Dump all database data to MySQL/MariaDB compatible SQL format';

    public function handle(): int
    {
        $outputPath = $this->option('output');
        $specificTables = $this->option('tables');

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

        // Filter out system tables
        $tables = array_filter($tables, function ($table) {
            return ! in_array($table, ['migrations', 'personal_access_tokens', 'password_reset_tokens', 'failed_jobs', 'job_batches', 'cache', 'cache_locks', 'sessions']);
        });

        $this->info('Dumping MySQL-compatible SQL for '.count($tables).' tables...');

        $output = $this->dumpMysqlSql($tables);

        if ($outputPath) {
            file_put_contents($outputPath, $output);
            $this->info("Dump saved to: {$outputPath}");
        } else {
            $this->line($output);
        }

        return Command::SUCCESS;
    }

    private function dumpMysqlSql(array $tables): string
    {
        $sql = '-- Database dump generated at '.now()->toDateTimeString()."\n";
        $sql .= '-- Tables: '.implode(', ', $tables)."\n";
        $sql .= "-- MySQL/MariaDB compatible\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        foreach ($tables as $table) {
            $columns = Schema::getColumnListing($table);

            // Skip tables with no columns
            if (empty($columns)) {
                continue;
            }

            $rows = DB::table($table)->get()->toArray();

            if (empty($rows)) {
                $sql .= "-- Table `{$table}` is empty\n\n";

                continue;
            }

            $sql .= "-- Table: `{$table}`\n";
            $sql .= "TRUNCATE TABLE `{$table}`;\n\n";

            // Backtick column names
            $columnList = '`'.implode('`, `', $columns).'`';

            foreach ($rows as $row) {
                $values = [];
                foreach ($columns as $col) {
                    $value = $row->$col ?? null;
                    if ($value === null) {
                        $values[] = 'NULL';
                    } elseif (is_bool($value)) {
                        $values[] = $value ? '1' : '0';
                    } elseif (is_numeric($value)) {
                        $values[] = $value;
                    } else {
                        // Escape single quotes and backslashes for MySQL
                        $escaped = str_replace(
                            ["'", '\\', "\0", "\n", "\r", "\x1a"],
                            ["''", '\\\\', '\\0', '\\n', '\\r', '\\Z'],
                            (string) $value
                        );
                        $values[] = "'{$escaped}'";
                    }
                }
                $sql .= "INSERT INTO `{$table}` ({$columnList}) VALUES (".implode(', ', $values).");\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";

        return $sql;
    }
}
