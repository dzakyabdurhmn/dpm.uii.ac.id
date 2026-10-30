<?php

namespace App\Filament\Resources\App\Models\BioLinkItems\Pages;

use App\Filament\Resources\App\Models\BioLinkItems\BioLinkItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBioLinkItems extends ListRecords
{
    protected static string $resource = BioLinkItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
