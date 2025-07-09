<div class="row">
    <div class="col-12 col-md-9">
        @input(['name' => 'name', 'label' => __('zone::country.name')])
        @input(['name' => 'code', 'label' => __('zone::country.code')])
    </div>
    <div class="col-12 col-md-3">
        @checkbox(['name' => 'is_active', 'label' => __('zone::country.is_active'), 'default' => true])
    </div>
</div>
