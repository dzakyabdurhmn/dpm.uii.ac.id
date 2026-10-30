<?php

namespace App\Filament\Resources\App\Models\BioLinks;

use App\Filament\Resources\App\Models\BioLinks\Pages\CreateBioLink;
use App\Filament\Resources\App\Models\BioLinks\Pages\EditBioLink;
use App\Filament\Resources\App\Models\BioLinks\Pages\ListBioLinks;
use App\Filament\Resources\App\Models\BioLinks\Schemas\BioLinkForm;
use App\Filament\Resources\App\Models\BioLinks\Tables\BioLinksTable;
use App\Models\BioLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BioLinkResource extends Resource
{
    protected static ?string $model = BioLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'site_name';

    public static function form(Schema $schema): Schema
    {
        return BioLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BioLinksTable::configure($table);
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
            'index' => ListBioLinks::route('/'),
            'create' => CreateBioLink::route('/create'),
            'edit' => EditBioLink::route('/{record}/edit'),
        ];
    }
}
