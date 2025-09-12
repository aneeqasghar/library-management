<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('book_cover')
                    ->image()
                    ->directory('covers')
                    ->disk('public'),
                TextInput::make('title')
                    ->required(),
                TextInput::make('author')
                    ->required(),
                Select::make('published_year')
                ->searchable()
                ->options(
                    collect(range(0, now()->year))
                        ->reverse()
                        ->mapWithKeys(fn ($year) => [$year => (string) $year])
                ),
                TextInput::make('genre')
                    ->required(),
                FileUpload::make('pdf_file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required()
                    ->directory('library')
                    ->disk('public'),
            ]);
    }
}
