<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\User as UserStatus;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('name')
                ->label('Name'),
                Placeholder::make('email')
                ->label('Email'),
                Select::make('status')
                    ->enum(UserStatus::class)
                    ->options([
                    UserStatus::ACTIVE->value => 'ACTIVE',
                    UserStatus::BANNED->value => 'BANNED',
                    ])
                    ->default('active')
                    ->required()
                    ->disabled(function ($record) {
                        return $record->roles->contains('name', 'admin');
                    }),
            ]);
    }
}
