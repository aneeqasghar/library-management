<?php

namespace App\Filament\Resources\Books\Pages;

use App\Models\Book;
use App\Filament\Resources\Books\BookResource;
use App\Jobs\ProcessBooks;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('Upload Batch')
            ->form([
                FileUpload::make('pdf_files')
                    ->label('Select PDFs')
                    ->multiple()
                    ->directory('library')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),
            ])
            ->action(function ($data) {
                $userId = Auth::user()->id;
                foreach ($data['pdf_files'] as $file) {
                    ProcessBooks::dispatch($file, $userId)->onQueue('books');
                }
                Notification::make()
                    ->title('Books upload queued')
                    ->success()
                    ->send();
            })
        ];
    }
}
