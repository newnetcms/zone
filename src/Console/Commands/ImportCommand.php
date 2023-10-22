<?php

namespace Newnet\Zone\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Newnet\Zone\Imports\ZoneImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:zone.import {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Module Zone Import Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename') ?: storage_path('vietnam-zone.xls');
        if (!File::exists($filename)) {
            $this->error("File {$filename} does not exist");
            return 1;
        }

        $this->info('Importing...');
        Excel::import(new ZoneImport(), $filename);

        $this->info('Completed');
        return 0;
    }
}
