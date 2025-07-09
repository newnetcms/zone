<div class="row">
    <div class="col-12 col-md-9">
        @input(['name' => 'name', 'label' => __('zone::township.name')])
        @textarea(['name' => 'description', 'label' => __('zone::township.description')])
        @editor(['name' => 'content', 'label' => __('zone::township.content')])
        @editor(['name' => 'content_other1', 'label' => __('zone::township.content_other1')])
        @editor(['name' => 'content_other2', 'label' => __('zone::township.content_other2')])
    </div>
    <div class="col-12 col-md-3">
        @checkbox(['name' => 'is_active', 'label' => __('zone::township.is_active'), 'default' => true])
        @select2(['name' => 'province_id', 'label' => __('zone::township.province_id'), 'options' => get_new_province_options()])
        @textarea(['name' => 'old_wards', 'label' => __('zone::township.old_wards')])
        @mediafile(['name' => 'logo', 'label' => __('zone::new-province.logo')])
    </div>
</div>
