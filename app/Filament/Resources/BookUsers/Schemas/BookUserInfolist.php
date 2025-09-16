<?php

namespace App\Filament\Resources\BookUsers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookUserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('book_id')
                    ->numeric(),
                TextEntry::make('borrow_at')
                    ->dateTime(),
                TextEntry::make('due_at')
                    ->dateTime(),
                TextEntry::make('return_at')
                    ->dateTime(),
                TextEntry::make('status'),
                TextEntry::make('fine')
                ->label('Fine')
                ->getStateUsing(fn($record) => $record->fine)
                ->money('PKR', true)
            ]);
    }
}
