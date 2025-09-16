<?php

namespace App\Filament\Resources\BookUsers\Pages;

use App\Filament\Resources\BookUsers\BookUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookUsers extends ListRecords
{
    protected static string $resource = BookUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
