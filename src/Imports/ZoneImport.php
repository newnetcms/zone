<?php

namespace Newnet\Zone\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Newnet\Zone\Models\ZoneDistrict;
use Newnet\Zone\Models\ZoneProvince;
use Newnet\Zone\Models\ZoneTownship;

class ZoneImport implements WithHeadingRow, SkipsOnFailure, ToArray, WithChunkReading
{
    protected $districtMap = [];

    protected $provinceMap = [];

    protected $wardMap = [];

    public function __construct()
    {
        $this->createProvinceMap();
        $this->createDistrictMap();
        $this->createWardMap();
    }

    public function onFailure(Failure ...$failures)
    {

    }

    public function array(array $array)
    {
        $wardImport = [];
        foreach ($array as $item) {
            if (!empty($item['ma_tp']) && !empty($item['ma_qh']) && !empty($item['ma_px'])) {
                if (!empty($this->wardMap[$item['ma_px']])) {
                    ZoneTownship::whereCode($this->wardMap[$item['ma_px']])->update(['name' => $item['phuong_xa']]);
                } else {
                    $districtId = $this->getDistrictId($item);

                    $wardImport[] = [
                        'name' => $item['phuong_xa'],
                        'code' => $item['ma_px'],
                        'district_id' => $districtId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        try {
            DB::table('zone_townships')->insert($wardImport);
        } catch (\Exception $e) {
            \Log::error('VienamZoneImport', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    private function getProvinceId(array $item)
    {
        return $this->provinceMap[$item['ma_tp']] ?? $this->createProvince($item);
    }

    private function getDistrictId(array $item)
    {
        return $this->districtMap[$item['ma_qh']] ?? $this->createDistrict($item);
    }

    private function createProvince(array $item)
    {
        $province = ZoneProvince::create([
            'name' => trim(preg_replace('/Thành phố|Tỉnh/', '', $item['tinh_thanh_pho'])),
            'code' => $item['ma_tp'],
        ]);

        $this->provinceMap[$item['ma_tp']] = $province->id;

        return $province->id;
    }

    private function createDistrict(array $item)
    {
        $provinceId = $this->getProvinceId($item);

        $district = ZoneDistrict::create([
            'name' => $item['quan_huyen'],
            'code' => $item['ma_qh'],
            'province_id' => $provinceId,
        ]);

        $this->districtMap[$item['ma_qh']] = $district->id;

        return $district->id;
    }

    private function createProvinceMap()
    {
        $provinces = DB::table('zone_provinces')->get(['code', 'id']);

        $this->provinceMap = $provinces
            ->keyBy('code')
            ->map(function ($item) {
                return $item->id;
            })
            ->toArray();
    }

    private function createDistrictMap()
    {
        $districts = DB::table('zone_districts')->get(['code', 'id']);

        $this->districtMap = $districts
            ->keyBy('code')
            ->map(function ($item) {
                return $item->id;
            })
            ->toArray();
    }

    private function createWardMap()
    {
        $wards = DB::table('zone_townships')->get(['code', 'id']);

        $this->wardMap = $wards
            ->keyBy('code')
            ->map(function ($item) {
                return $item->id;
            })
            ->toArray();
    }
}
