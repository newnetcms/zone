@extends('core::admin.master')

@section('meta_title', __('zone::country.index.page_title'))

@section('page_title', __('zone::country.index.page_title'))

@section('page_subtitle', __('zone::country.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('zone::country.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        {{ __('zone::country.index.page_title') }}
                    </h6>
                </div>
                <div class="text-right">
                    <div class="actions">
	                    @admincan('zone.admin.country.create')
	                        <a href="{{ route('zone.admin.country.create') }}" class="action-item">
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
                @input(['item' => null, 'name' => 'name', 'label' => __('zone::country.name'), 'value' => request('name')])

                <button type="submit" class="btn btn-primary mr-1">
                    {{ __('core::button.search') }}
                </button>
                <a href="{{ route('zone.admin.country.index') }}" class="btn btn-danger">
                    {{ __('core::button.cancel') }}
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap bootstrap4-styling">
                    <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th nowrap>{{ __('zone::country.name') }}</th>
                        <th nowrap>{{ __('zone::country.code') }}</th>
                        <th nowrap>{{ __('zone::country.province') }}</th>
                        <th nowrap>{{ __('zone::country.is_active') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $loop->index + $items->firstItem() }}</td>
                            <td nowrap>
                                <a href="{{ route('zone.admin.country.edit', $item->id) }}">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td nowrap>{{ $item->code }}</td>
                            <td nowrap>
                                <a href="{{ route('zone.admin.province.index', ['country_id' => $item->id]) }}">
                                    {{ __('zone::country.province_count', ['count' => $item->provinces->count()]) }}
                                </a>
                            </td>
                            <td>
                                @if($item->is_active)
                                    <i class="fas fa-check text-success"></i>
                                @endif
                            </td>
                            <td nowrap class="text-right">
                                @admincan('zone.admin.country.edit')
                                    <a href="{{ route('zone.admin.country.edit', $item->id) }}" class="btn btn-success-soft btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endadmincan

                                @admincan('zone.admin.country.destroy')
                                    <table-button-delete url-delete="{{ route('zone.admin.country.destroy', $item->id) }}"></table-button-delete>
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
