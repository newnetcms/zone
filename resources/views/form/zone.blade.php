@php
    $province_name = $province_name ?? 'province_id';
    $district_name = $district_name ?? 'district_id';
    $township_name = $township_name ?? 'township_id';
    $address_name = $address_name ?? 'address';
    $zone_id = 'zone_' . \Illuminate\Support\Str::random();
    $show_address = $show_address ?? true;
    $show_township = $show_township ?? true;
    $show_district = $show_district ?? true;
    $allowClear = $allowClear ?? false;
@endphp

<div class="zone-grouup" id="{{ $zone_id }}">
    @select2(['name' => $province_name, 'label' => __('zone::module.province_id'), 'options' => get_zone_provice_options(), 'allowClear' => $allowClear])

    @if ($show_district)
        @select2(['name' => $district_name, 'label' => __('zone::module.district_id'), 'options' => object_get($item, $province_name) ? get_zone_district_options(object_get($item, $province_name)) : [], 'allowClear' => $allowClear])

        @if ($show_township)
            @select2(['name' => $township_name, 'label' => __('zone::module.township_id'), 'options' => object_get($item, $district_name) ? get_zone_township_options(object_get($item, $district_name)) : [], 'allowClear' => $allowClear])
        @endif
    @endif

    @if ($show_address)
        @input(['name' => $address_name, 'label' => __('zone::module.address')])
    @endif
</div>

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $('#{{ $zone_id }} #{{ $province_name }}').on('select2:select', function (e) {
                var data = e.params.data;
                const id = data.id;
                $('#{{ $zone_id }} #{{ $district_name }}').empty().trigger('change');
                $('#{{ $zone_id }} #{{ $township_name }}').empty().trigger('change');
                axios.get(`/api/zone/provinces/${id}/districts`)
                    .then(res => {
                        res.data.items.forEach(o => {
                            const newOption = new Option(o.name, o.id, false, false);
                            $('#{{ $zone_id }} #{{ $district_name }}').append(newOption).trigger('change');
                        });
                    });
            });

            $('#{{ $zone_id }} #{{ $district_name }}').on('select2:select', function (e) {
                var data = e.params.data;
                const id = data.id;
                $('#{{ $zone_id }} #{{ $township_name }}').empty().trigger('change');
                axios.get(`/api/zone/districts/${id}/townships`)
                    .then(res => {
                        res.data.items.forEach(o => {
                            const newOption = new Option(o.name, o.id, false, false);
                            $('#{{ $zone_id }} #{{ $township_name }}').append(newOption).trigger('change');
                        });
                    });
            });
        });
    </script>
@endpush
