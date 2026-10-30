<?php

namespace App\Filament\Resources\App\Models\BioLinkGroups;

use App\Filament\Resources\App\Models\BioLinkGroups\Pages\CreateBioLinkGroup;
use App\Filament\Resources\App\Models\BioLinkGroups\Pages\EditBioLinkGroup;
use App\Filament\Resources\App\Models\BioLinkGroups\Pages\ListBioLinkGroups;
use App\Filament\Resources\App\Models\BioLinkGroups\Schemas\BioLinkGroupForm;
use App\Filament\Resources\App\Models\BioLinkGroups\Tables\BioLinkGroupsTable;
use App\Models\BioLinkGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BioLinkGroupResource extends Resource
{
    protected static ?string $model = BioLinkGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BioLinkGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BioLinkGroupsTable::configure($table);
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
            'index' => ListBioLinkGroups::route('/'),
            'create' => CreateBioLinkGroup::route('/create'),
            'edit' => EditBioLinkGroup::route('/{record}/edit'),
        ];
    }
}
