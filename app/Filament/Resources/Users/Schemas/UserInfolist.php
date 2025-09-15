<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Role;
use App\Enums\User as UserStatus;
use App\Filament\Resources\BookUsers\BookUserResource;
use App\Models\Book;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
                ->components([
                    Section::make('User Details')
                        ->description('Basic information about the user')
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextEntry::make('id')
                                        ->label('ID')
                                        ->numeric()
                                        ->icon('heroicon-o-hashtag')
                                        ->color('gray'),

                                    TextEntry::make('name')
                                        ->label('Full Name')
                                        ->icon('heroicon-o-user')
                                        ->weight('bold'),

                                    TextEntry::make('email')
                                        ->label('Email Address')
                                        ->copyable()
                                        ->icon('heroicon-o-envelope')
                                        ->color('primary'),

                                    TextEntry::make('roles.name')
                                        ->label('Role(s)')
                                        ->badge()
                                        ->separator(', ')
                                        ->icon('heroicon-o-shield-check')
                                        ->color(fn (Role $state): string => match ($state) {
                                            Role::FULL_ACCESS  => 'warning',
                                            Role::MEMBER => 'gray',
                                        }),

                                    TextEntry::make('status')
                                        ->badge()
                                        ->icon(fn (UserStatus $state) => match ($state) {
                                            UserStatus::ACTIVE    => 'heroicon-o-check-circle',
                                            UserStatus::BANNED    => 'heroicon-o-x-circle',
                                            UserStatus::SUSPENDED => 'heroicon-o-exclamation-triangle',
                                        })
                                        ->color(fn (UserStatus $state): string => match ($state) {
                                            UserStatus::ACTIVE    => 'success',
                                            UserStatus::BANNED    => 'danger',
                                            UserStatus::SUSPENDED => 'warning',
                                        }),
                                ]),
                        ]),
                    Section::make('Borrowed Books')
                        ->schema([
                            RepeatableEntry::make('books')
                                ->grid(2)
                                ->label(false)
                                ->columnSpanFull()
                                ->schema([
                                    Grid::make(2)->schema([
                                        ImageEntry::make('book_cover')
                                            ->label('Cover')
                                            ->height(100)
                                            ->square()
                                            ->disk('public'),

                                        TextEntry::make('title')
                                            ->label('Title')
                                            ->weight('semibold')
                                            ->url(fn ($record) =>
                                                BookUserResource::getUrl('view', ['record' => $record]), shouldOpenInNewTab: true),
                                        TextEntry::make('pivot.status')
                                            ->badge()
                                            ->label('Borrow Status')
                                            ->color(fn (string $state) => match ($state) {
                                                'borrowed' => 'warning',
                                                'returned' => 'success',
                                                'overdue'  => 'danger',
                                                default    => 'gray',
                                            }),
                                    ]),
                                ])
                        ]),
                ])
                ;
    }
}
