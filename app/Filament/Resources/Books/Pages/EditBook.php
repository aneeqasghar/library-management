<?php

namespace App\Filament\Resources\Books\Pages;

use App\Filament\Resources\Books\BookResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
            ->after(function () {
                Storage::disk('public')->delete($this->record->book_cover ?? '');
                Storage::disk('public')->delete($this->record->pdf_file ?? '');
            }),
        ];
    }
}
