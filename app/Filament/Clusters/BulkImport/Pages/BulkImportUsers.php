<?php

namespace App\Filament\Clusters\BulkImport\Pages;

use App\Filament\Clusters\BulkImport\BulkImportCluster;
use App\Models\Role;
use App\Enums\Role as RoleName;
use App\Models\User;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class BulkImportUsers extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $cluster = BulkImportCluster::class;
    protected string $view = 'filament.pages.bulk-import-users';
    public ?array $data = [];

    public function form(Schema $schema) {
        return $schema->components([
            FileUpload::make('data.csv_file')
                ->label('Upload CSV File')
                ->disk('public')
                ->directory('imports')
                ->required()
                ->acceptedFileTypes(['text/csv'])
                ->multiple(false),
        ]);
    }

    public function import() {
        $csvFile = $this->data['csv_file'] ?? null;

        if (! $csvFile) {
            Notification::make()->title('CSV not found')->danger()->send();
            return;
        }

        // Take the first uploaded file
        /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $csvFile */
        $csvFile = reset($csvFile);

        $relativePath = $csvFile->store('imports', 'public');
        $fullPath = storage_path('app/public/' . $relativePath);

        if (! file_exists($fullPath)) {
            Notification::make()->title('File not found after storing.')->danger()->send();
            return;
        }

        if (($handle = fopen($fullPath, 'r')) !== false) {
        $headers = fgetcsv($handle, 1000, ','); // skip header row

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if(User::where('email', $row[1])->first())
                {
                    Notification::make()->title('Email: '.$row[1].' is already taken')->danger()->send();
                    continue;
                }
                $user = User::create([
                    'name'     => $row[0] ?? null,
                    'email'    => $row[1],
                    'password' => Hash::make($row[2]),
                ]);
                $roleId = Role::where('name', RoleName::VIEW_ONLY)->value('id');
                $user->roles()->attach($roleId);
                Notification::make()->title('User: '.$row[0].' imported successfully!')->success()->send();
            }
            fclose($handle);
        }
    }
}


