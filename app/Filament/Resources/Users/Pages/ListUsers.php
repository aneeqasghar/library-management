<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\User as UserStatus;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', UserStatus::ACTIVE)),
            'banned' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', UserStatus::BANNED)),
            'suspended' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', UserStatus::SUSPENDED)),
        ];
    }
}
