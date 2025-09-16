<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function afterCreate(): void
    {
        $roleId = $this->form->getState()['role_id']; // get selected role ID
        if ($roleId) {
            $this->record->roles()->attach($roleId); // attach via roleables
        }
    }
}
