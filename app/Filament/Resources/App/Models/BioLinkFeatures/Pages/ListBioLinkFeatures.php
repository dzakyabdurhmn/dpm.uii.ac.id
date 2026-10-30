<?php

namespace App\Filament\Resources\App\Models\BioLinkFeatures\Pages;

use App\Filament\Resources\App\Models\BioLinkFeatures\BioLinkFeatureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBioLinkFeatures extends ListRecords
{
    protected static string $resource = BioLinkFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
