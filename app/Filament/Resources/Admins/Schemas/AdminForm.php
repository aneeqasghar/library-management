<?php

namespace App\Filament\Resources\Admins\Schemas;

use App\Enums\Role as RoleName;
use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->required(),
                Select::make('role_id')
                    ->label('Role')
                    ->required()
                    ->options(
                        Role::all()
                        ->reject(fn($role) => ($role->name->value ?? $role->name) === RoleName::MEMBER->value) // exclude Member
                        ->mapWithKeys(function ($role) {
                            return [$role->id => $role->name->value ?? $role->name]; 
                        })->toArray()
                    )
                    ->searchable(),
            ]);
    }
}
