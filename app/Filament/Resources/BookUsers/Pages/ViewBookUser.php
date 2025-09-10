<?php

namespace App\Filament\Resources\BookUsers\Pages;

use App\Filament\Resources\BookUsers\BookUserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookUser extends ViewRecord
{
    protected static string $resource = BookUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
