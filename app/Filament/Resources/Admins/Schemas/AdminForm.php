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
                Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'id', modifyQueryUsing: function ($query) {
                        $query->whereNotIn('name', [
                            RoleName::MEMBER->value,
                            RoleName::VIEW_ONLY->value,
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
