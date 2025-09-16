<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Role as RoleName;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Super Admin' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', fn ($subQuery) => $subQuery->where('name', RoleName::SUPER_ADMIN))),
            'Moderator' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', fn ($subQuery) => $subQuery->where('name', RoleName::MODERATOR))),
        ];
    }
}
