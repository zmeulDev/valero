<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PurgeDatabaseCache extends Command
{
    protected $signature = 'cache:prune-db';

    protected $description = 'Truncate database cache tables (cache, cache_locks) to reclaim space.';

    public function handle(): int
    {
        $tables = ['cache', 'cache_locks'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->info("Truncated table: {$table}");
            } else {
                $this->warn("Table not found (skipped): {$table}");
            }
        }

        $this->info('Database cache pruning complete.');

        return self::SUCCESS;
    }
}

