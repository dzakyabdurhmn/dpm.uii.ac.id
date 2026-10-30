<?php

namespace App\Filament\Resources\App\Models\BioLinks\Pages;

use App\Filament\Resources\App\Models\BioLinks\BioLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBioLinks extends ListRecords
{
    protected static string $resource = BioLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
