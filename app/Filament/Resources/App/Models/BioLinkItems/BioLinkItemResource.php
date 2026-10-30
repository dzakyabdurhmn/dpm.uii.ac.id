<?php

namespace App\Filament\Resources\App\Models\BioLinkItems;

use App\Filament\Resources\App\Models\BioLinkItems\Pages\CreateBioLinkItem;
use App\Filament\Resources\App\Models\BioLinkItems\Pages\EditBioLinkItem;
use App\Filament\Resources\App\Models\BioLinkItems\Pages\ListBioLinkItems;
use App\Filament\Resources\App\Models\BioLinkItems\Schemas\BioLinkItemForm;
use App\Filament\Resources\App\Models\BioLinkItems\Tables\BioLinkItemsTable;
use App\Models\BioLinkItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BioLinkItemResource extends Resource
{
    protected static ?string $model = BioLinkItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BioLinkItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BioLinkItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBioLinkItems::route('/'),
            'create' => CreateBioLinkItem::route('/create'),
            'edit' => EditBioLinkItem::route('/{record}/edit'),
        ];
    }
}
