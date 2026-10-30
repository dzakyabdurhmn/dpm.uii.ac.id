<?php

namespace App\Filament\Resources\App\Models\BioLinkGroups\Pages;

use App\Filament\Resources\App\Models\BioLinkGroups\BioLinkGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBioLinkGroups extends ListRecords
{
    protected static string $resource = BioLinkGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
