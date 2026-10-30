<?php

namespace App\Filament\Resources\App\Models\BioLinkFeatures\Pages;

use App\Filament\Resources\App\Models\BioLinkFeatures\BioLinkFeatureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBioLinkFeature extends EditRecord
{
    protected static string $resource = BioLinkFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
