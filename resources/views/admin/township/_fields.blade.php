<div class="row">
    <div class="col-12 col-md-9">
        @input(['name' => 'name', 'label' => __('zone::township.name')])
        @input(['name' => 'code', 'label' => __('zone::township.code')])
        @input(['name' => 'zip_code', 'label' => __('zone::township.zip_code')])
    </div>
    <div class="col-12 col-md-3">
        @checkbox(['name' => 'status', 'label' => __('zone::township.status'), 'default' => true])
        @input(['name' => 'sort_order', 'label' => __('zone::township.sort_order')])
    </div>
</div>

<div class="d-none">
    @input(['name' => 'district_id', 'label' => __('zone::township.district_id')])
</div>
