<div class="row">
    <div class="col-12 col-md-9">
        @input(['name' => 'name', 'label' => __('zone::province.name')])
        @input(['name' => 'code', 'label' => __('zone::province.code')])
        @input(['name' => 'zip_code', 'label' => __('zone::province.zip_code')])
    </div>
    <div class="col-12 col-md-3">
        @checkbox(['name' => 'status', 'label' => __('zone::province.status'), 'default' => true])
        @select2(['name' => 'country_id', 'label' => __('zone::province.country_id'), 'options' => get_zone_country_options()])
        @input(['name' => 'sort_order', 'label' => __('zone::province.sort_order')])
    </div>
</div>
