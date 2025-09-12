<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Enums\User as UserStatus;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
             DeleteAction::make()
        ];
    }

    public function getHeading(): string
    {
        return 'Edit Status';
    }
}
