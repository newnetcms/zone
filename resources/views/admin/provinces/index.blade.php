@extends('core::admin.master')

@section('meta_title', __('zone::message.index.page_title'))

@section('page_title', __('zone::message.index.page_title'))

@section('page_subtitle', __('zone::message.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('zone::message.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        {{ __('zone::message.index.page_title') }}
                    </h6>
                </div>
                <div class="text-right">
                    <div class="actions">
                        <a href="{{ route('zone.admin.province.create', ['country_id' => request('country_id')]) }}" class="action-item">
                            <i class="fa fa-plus"></i>
                            {{ __('core::button.add') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="form-inline newnet-table-search">
                @input(['item' => null, 'name' => 'name', 'label' => __('zone::province.name'), 'value' => request('name')])
                @if(config('cms.zone.enable_country'))
                    @select2(['item' => null, 'name' => 'country_id', 'label' => __('zone::province.country_id'), 'value' => request('country_id'), 'options' => get_zone_country_options()])
                @endif

                <button type="submit" class="btn btn-primary mr-1">
                    {{ __('core::button.search') }}
                </button>
                <a href="{{ route('zone.admin.province.index') }}" class="btn btn-danger">
                    {{ __('core::button.cancel') }}
                </a>
            </form>
            <table class="table table-striped table-bordered dt-responsive nowrap bootstrap4-styling">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('zone::province.name') }}</th>
                    @if(config('cms.zone.legacy_mode'))
                        <th>{{ __('zone::province.district') }}</th>
                    @else
                        <th>{{ __('zone::province.level_2') }}</th>
                    @endif
                    <th>{{ __('zone::province.status') }}</th>
                    <th>{{ __('zone::province.sort_order') }}</th>
                    <th>{{ __('zone::province.zip_code') }}</th>
                    @if(config('cms.zone.enable_country'))
                        <th>{{ __('zone::province.country_id') }}</th>
                    @endif
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $loop->index + $items->firstItem() }}</td>
                        <td>
                            <a href="{{ route('zone.admin.province.edit', $item->id) }}">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('zone.admin.district.index', ['province_id' => $item->id]) }}">
                                @if(config('cms.zone.legacy_mode'))
                                    {{ __('zone::province.district_count', ['count' => $item->level_2->count()]) }}
                                @else
                                    {{ __('zone::province.level_2_count', ['count' => $item->level_2->count()]) }}
                                @endif
                            </a>
                        </td>
                        <td>
                            @if($item->status)
                                <i class="fas fa-check text-success"></i>
                            @endif
                        </td>
                        <td>{{ $item->sort_order }}</td>
                        <td>{{ $item->zip_code }}</td>
                        @if(config('cms.zone.enable_country'))
                            <td>{{ object_get($item, 'country.name') }}</td>
                        @endif
                        <td class="text-right">
                            <a href="{{ route('zone.admin.province.edit', $item->id) }}" class="btn btn-success-soft btn-sm mr-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <table-button-delete url-delete="{{ route('zone.admin.province.destroy', $item->id) }}"></table-button-delete>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
@stop
