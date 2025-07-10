<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Chế độ cấu trúc dữ liệu
    |--------------------------------------------------------------------------
    |
    | Đặt legacy_mode = true
    | Để chạy dữ liệu 3 cấp tỉnh, huyện, xã như trước 1/7/2025
    |
    */
    'legacy_mode' => env('ZONE_LEGACY_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Bật quốc gia
    |--------------------------------------------------------------------------
    |
    | Đặt enable_country = true
    | Để thêm menu country vào admin và các dropdown trong @zone
    |
    */
    'enable_country' => env('ZONE_ENABLE_COUNTRY', false),
];
