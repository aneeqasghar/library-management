<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\BookUser as BookUserStatus;
use App\Enums\Book as BookStatus;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Enums\User as UserStatus;
use App\Models\Book;
use App\Models\BookUser;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;

class ViewUser extends ViewRecord
{   protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn ($record) => $record->status !== UserStatus::SUSPENDED),
            Action::make('attach')
                ->label('Attach Books')
                ->form([
                        Select::make('books')
                            ->label('Select Books')
                            ->options(function () {
                                return Book::where('status', BookStatus::AVAILABLE)
                                        ->pluck('title', 'id');
                            })
                            ->multiple()
                            ->searchable()
                            ->required(),
                        ])
                ->action(function (array $data, $record) {
                    foreach ($data['books'] as $bookId) {
                        BookUser::create([
                            'user_id'  => $record->id,
                            'book_id'  => $bookId,
                            'status'   => 'borrowed',
                            'borrow_at' => now(),
                            'due_at'   => now()->addDays(14),
                        ]);
                    }
                })
                ->successNotificationTitle('Books attached successfully'),
        ];
    }
}
