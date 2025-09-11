<?php

namespace App\Filament\Resources\BookUsers;

use App\Filament\Resources\BookUsers\Pages\CreateBookUser;
use App\Filament\Resources\BookUsers\Pages\EditBookUser;
use App\Filament\Resources\BookUsers\Pages\ListBookUsers;
use App\Filament\Resources\BookUsers\Pages\ViewBookUser;
use App\Filament\Resources\BookUsers\Schemas\BookUserInfolist;
use App\Filament\Resources\BookUsers\Tables\BookUsersTable;
use App\Filament\Resources\Users\Schemas\BookUserForm;
use App\Models\BookUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookUserResource extends Resource
{
    protected static ?string $model = BookUser::class;

    protected static ?string $navigationLabel = 'Borrowed Books';

    protected static ?string $modelLabel = 'Borrowed Book';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    //protected static ?string $recordTitleAttribute = 'id';

    public static function getTitle(BookUser $record): string
    {
       return $record->book?->title;
    }

    public static function form(Schema $schema): Schema
    {
        return BookUserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookUserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookUsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookUsers::route('/'),
            'view' => ViewBookUser::route('/{record}'),
        ];
    }
}
