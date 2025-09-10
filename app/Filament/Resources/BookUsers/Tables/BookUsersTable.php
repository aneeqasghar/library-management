<?php

namespace App\Filament\Resources\BookUsers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('User'),
                TextColumn::make('book.title')
                    ->label('Book Name')
                    ->numeric()
                    ->label('Books')
                    ->sortable(),
                TextColumn::make('borrow_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('due_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('return_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('fine')
                ->label('Fine')
                ->getStateUsing(fn($record) => $record->fine)
                ->money('PKR', true)
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
