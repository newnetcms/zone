<?php

namespace Newnet\Zone\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SeedCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:zone.seed-countries {--force : Seed even if the table already has data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Module Zone Seed Countries Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force') && DB::table('zone_countries')->exists()) {
            $this->info('Table zone_countries already has data, skipping. Use --force to seed anyway.');
            return 0;
        }

        $countries = json_decode(File::get(__DIR__.'/../../../database/countries.json'), true);

        $now = now();
        $rows = array_map(function ($country) use ($now) {
            return [
                'name' => $country['name'],
                'code' => $country['alpha2'],
                'is_active' => true,
                'alpha2' => $country['alpha2'],
                'alpha3' => $country['alpha3'],
                'numeric' => $country['numeric'],
                'phone_code' => $country['phone_code'],
                'currency' => null,
                'emoji_flag' => $country['emoji_flag'],
                'args' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $countries);

        $this->info('Seeding ' . count($rows) . ' countries...');

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('zone_countries')->insert($chunk);
        }

        $this->info('Completed');
        return 0;
    }
}
