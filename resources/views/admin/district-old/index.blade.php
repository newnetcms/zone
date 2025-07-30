@extends('core::admin.master')

@section('meta_title', __('zone::district-old.index.page_title'))

@section('page_title', __('zone::district-old.index.page_title'))

@section('page_subtitle', __('zone::district-old.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('zone::district-old.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        {{ __('zone::district-old.index.page_title') }}
                    </h6>
                </div>
                <div class="text-right">
                    <div class="actions">
	                    @admincan('zone.admin.district.create')
	                        <a href="{{ route('zone.admin.district.create', ['province_id' => request('province_id')]) }}" class="action-item">
	                            <i class="fa fa-plus"></i>
	                            {{ __('core::button.add') }}
	                        </a>
                        @endadmincan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="form-inline newnet-table-search">
                @input(['item' => null, 'name' => 'name', 'label' => __('zone::district-old.name'), 'value' => request('name')])
                @select2(['item' => null, 'name' => 'province_id', 'label' => __('zone::district-old.province_id'), 'value' => request('province_id'), 'options' => get_zone_provice_options()])

                <button type="submit" class="btn btn-primary mr-1">
                    {{ __('core::button.search') }}
                </button>
                <a href="{{ route('zone.admin.district.index') }}" class="btn btn-danger">
                    {{ __('core::button.cancel') }}
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap bootstrap4-styling">
                    <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th nowrap>{{ __('zone::district-old.name') }}</th>
                        <th nowrap>{{ __('zone::district-old.province') }}</th>
                        @if(config('cms.zone.legacy_mode'))
                            <th nowrap>{{ __('zone::district-old.township') }}</th>
                        @endif
                        <th nowrap>{{ __('zone::district-old.status') }}</th>
                        <th nowrap>{{ __('zone::district-old.sort_order') }}</th>
                        <th nowrap>{{ __('zone::district-old.zip_code') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $loop->index + $items->firstItem() }}</td>
                            <td nowrap>
                                <a href="{{ route('zone.admin.district.edit', $item->id) }}">
                                    {{ $item->name }}
                                </a>
                                <a href="{{ $item->url }}" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                            <td nowrap>{{ object_get($item, 'province.name') }}</td>
                            @if(config('cms.zone.legacy_mode'))
                                <td>
                                    <a href="{{ route('zone.admin.township.index', ['district_id' => $item->id]) }}">
                                        {{ __('zone::district-old.township_count', ['count' => $item->townships->count()]) }}
                                    </a>
                                </td>
                            @endif
                            <td>
                                @if($item->status)
                                    <i class="fas fa-check text-success"></i>
                                @endif
                            </td>
                            <td>{{ $item->sort_order }}</td>
                            <td>{{ $item->zip_code }}</td>
                            <td nowrap class="text-right">
                                @admincan('zone.admin.district.edit')
                                    <a href="{{ route('zone.admin.district.edit', $item->id) }}" class="btn btn-success-soft btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endadmincan

                                @admincan('zone.admin.district.destroy')
                                    <table-button-delete url-delete="{{ route('zone.admin.district.destroy', $item->id) }}"></table-button-delete>
                                @endadmincan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {!! $items->appends(Request::all())->render() !!}
        </div>
    </div>
@stop
