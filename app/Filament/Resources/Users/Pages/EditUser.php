<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Enums\User as UserStatus;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Suspend')
            ->button()
            ->color('danger')
            ->requiresConfirmation()
            ->action(function () {
                $this->record->update([
                        'status' => UserStatus::SUSPENDED,
                    ]);
                Notification::make()
                        ->title('Saved')
                        ->success()
                        ->send();
            })
             ->successRedirectUrl(ListUsers::getUrl())
        ];
    }

    public function getHeading(): string
    {
        return 'Edit Status';
    }
}
