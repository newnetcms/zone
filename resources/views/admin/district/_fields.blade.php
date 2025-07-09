<div class="row">
    <div class="col-12 col-md-9">
        @input(['name' => 'name', 'label' => __('zone::district.name')])
        @input(['name' => 'code', 'label' => __('zone::district.code')])
        @input(['name' => 'zip_code', 'label' => __('zone::district.zip_code')])
    </div>
    <div class="col-12 col-md-3">
        @checkbox(['name' => 'status', 'label' => __('zone::district.status'), 'default' => true])
        @select2(['name' => 'province_id', 'label' => __('zone::district.province_id'), 'options' => get_zone_provice_options()])
        @input(['name' => 'sort_order', 'label' => __('zone::district.sort_order')])
    </div>
</div>
