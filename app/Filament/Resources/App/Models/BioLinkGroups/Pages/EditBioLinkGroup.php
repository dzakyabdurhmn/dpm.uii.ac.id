<?php

namespace App\Filament\Resources\App\Models\BioLinkGroups\Pages;

use App\Filament\Resources\App\Models\BioLinkGroups\BioLinkGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBioLinkGroup extends EditRecord
{
    protected static string $resource = BioLinkGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
