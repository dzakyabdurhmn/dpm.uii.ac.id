<?php

namespace App\Filament\Resources\App\Models\BioLinkItems\Pages;

use App\Filament\Resources\App\Models\BioLinkItems\BioLinkItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBioLinkItem extends EditRecord
{
    protected static string $resource = BioLinkItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
