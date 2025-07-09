<?php

namespace Newnet\Zone\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Newnet\Zone\Imports\ZoneImport;
use Maatwebsite\Excel\Facades\Excel;
use Newnet\Zone\Models\ZoneDistrict;
use Newnet\Zone\Models\ZoneProvince;

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
        $legacy_mode = config('cms.zone.legacy_mode');
        if ($legacy_mode) {
            $this->info('Load Legacy Mode');
            $this->loadLegacyMode();
        } else {
            $this->info('Load New Mode');
            $this->loadNewMode();
        }
    }

    protected function loadNewMode()
    {
        $dataJson = json_decode(File::get(__DIR__.'/../../../database/data.json'), true);
        foreach ($dataJson as $item) {
            $name = trim(str_replace('Thành phố', '', $item['name']));
            $checkProvince = ZoneProvince::where('name', $name)->first();
            if (!$checkProvince) {
                $this->info('Importing ' . $name);
                $province = ZoneProvince::create([
                    'name' => $name,
                    'code' => $item['code'] ?? null,
                    'status' => true,
                    'args' => [
                        'place_type' => ($item['place_type'] ?? '') == 'Thành phố Trung Ương' ? 'city' : 'province',
                    ],
                ]);

                $now = now();
                $wards_insert = [];
                foreach ($item['wards'] as $ward) {
                    $wards_insert[] = [
                        'name' => $ward['name'] ?? '',
                        'code' => $ward['ward_code'] ?? '',
                        'status' => true,
                        'province_id' => $province->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                ZoneDistrict::insert($wards_insert);
            }
        }
    }

    protected function loadLegacyMode()
    {
        // Check maatwebsite/excel
        if (!class_exists('Maatwebsite\Excel\Facades\Excel')) {
            $this->error('Please install maatwebsite/excel');
            return 1;
        }

        $filename = $this->argument('filename') ?: __DIR__.'/../../../database/db.xls';
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
