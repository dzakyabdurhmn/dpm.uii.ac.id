<?php

namespace App\Filament\Resources\App\Models\BioLinks\Pages;

use App\Filament\Resources\App\Models\BioLinks\BioLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBioLink extends EditRecord
{
    protected static string $resource = BioLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
