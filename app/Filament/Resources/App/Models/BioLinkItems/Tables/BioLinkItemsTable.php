<?php

namespace App\Filament\Resources\App\Models\BioLinkItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BioLinkItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('group.title')
                    ->label('Grup')
                    ->sortable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->limit(50)
                    ->url(fn ($record) => $record->url, true),
                TextColumn::make('icon_type')
                    ->label('Tipe Ikon')
                    ->badge(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                ToggleColumn::make('open_in_new_tab')
                    ->label('Tab Baru'),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
