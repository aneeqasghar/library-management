<?php

namespace App\Filament\Clusters\BulkImport;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class BulkImportCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowUpTray;
}
