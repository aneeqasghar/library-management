<?php

namespace App\Filament\Resources\Books\Tables;

use App\Enums\Book;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('book_cover')
                    ->disk('public')   
                    ->square(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('author')
                    ->searchable(),
                TextColumn::make('published_year')
                    ->sortable(),
                TextColumn::make('genre')
                    ->searchable(),
                TextColumn::make('pdf_file')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (Book $state): string => match ($state) {
                        Book::AVAILABLE    => 'success',
                        Book::UNAVAILABLE    => 'danger',
                    }),
                TextColumn::make('uploaded_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        foreach ($records as $record) {
                            Storage::disk('public')->delete($record->book_cover ?? '');
                            Storage::disk('public')->delete($record->pdf_file ?? '');
                        }
                    }),
                ]),
            ]);
    }
}
