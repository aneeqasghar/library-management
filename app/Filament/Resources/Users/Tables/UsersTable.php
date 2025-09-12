<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\Role;
use App\Enums\User as UserStatus;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->searchable()
                    ->label('Role')
                    ->badge()
                    ->separator(' ')
                    ->color(fn (Role $state): string => match ($state) {
                        Role::ADMIN  => 'warning',
                        Role::MEMBER => 'gray',
                    }),
                TextColumn::make('status')
                    ->searchable()
                    ->icon(fn ($state) => match ($state) {
                        UserStatus::ACTIVE    => 'heroicon-o-check-circle',
                        UserStatus::BANNED    => 'heroicon-o-x-circle',
                        UserStatus::SUSPENDED => 'heroicon-o-exclamation-triangle',
                    })
                    ->color(fn (UserStatus $state): string => match ($state) {
                        UserStatus::ACTIVE    => 'success',
                        UserStatus::BANNED    => 'danger',
                        UserStatus::SUSPENDED => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                ->label('User Status')
                ->options([
                    UserStatus::ACTIVE->value => 'Active',
                    UserStatus::BANNED->value => 'Banned',
                    UserStatus::SUSPENDED->value => 'Suspended',
                ])
                ->multiple(false),
                TrashedFilter::make()
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn ($record) => $record->status !== UserStatus::SUSPENDED),
                DeleteAction::make()
                    ->icon(Heroicon::ArchiveBoxXMark),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
