<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use App\Enums\Role as RoleName;
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
                    UserStatus::BANNED->value => 'BAN',
                    UserStatus::SUSPENDED->value => 'SUSPEND',
                    ])
                    ->default('active')
                    ->required(),
               Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'id', modifyQueryUsing: function ($query) {
                        $query->whereNotIn('name', [
                            RoleName::SUPER_ADMIN->value,
                            RoleName::MODERATOR->value,
                        ]);
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => $record->name instanceof RoleName
                            ? $record->name->value
                            : $record->name
                    )
                    ->saveRelationshipsUsing(function ($state, $record) {
                        $record->roles()->sync([$state]);
                    })
            ]);
    }
}
