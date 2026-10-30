<?php

namespace App\Filament\Resources\App\Models\BioLinkFeatures;

use App\Filament\Resources\App\Models\BioLinkFeatures\Pages\CreateBioLinkFeature;
use App\Filament\Resources\App\Models\BioLinkFeatures\Pages\EditBioLinkFeature;
use App\Filament\Resources\App\Models\BioLinkFeatures\Pages\ListBioLinkFeatures;
use App\Filament\Resources\App\Models\BioLinkFeatures\Schemas\BioLinkFeatureForm;
use App\Filament\Resources\App\Models\BioLinkFeatures\Tables\BioLinkFeaturesTable;
use App\Models\BioLinkFeature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BioLinkFeatureResource extends Resource
{
    protected static ?string $model = BioLinkFeature::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BioLinkFeatureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BioLinkFeaturesTable::configure($table);
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
            'index' => ListBioLinkFeatures::route('/'),
            'create' => CreateBioLinkFeature::route('/create'),
            'edit' => EditBioLinkFeature::route('/{record}/edit'),
        ];
    }
}
