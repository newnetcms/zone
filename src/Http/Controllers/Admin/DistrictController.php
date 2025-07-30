<?php

namespace Newnet\Zone\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Zone\Http\Requests\DistrictRequest;
use Newnet\Zone\Models\ZoneDistrict;
use Newnet\Zone\Repositories\DistrictRepository;
use Newnet\Zone\ZoneAdminMenuKey;

class DistrictController extends Controller
{
    protected DistrictRepository $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function index(Request $request)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $items = $this->districtRepository->paginate($request->input('max', 20));

        if (config('cms.zone.legacy_mode')) {
            return view('zone::admin.district-old.index', compact('items'));
        } else {
            return view('zone::admin.district.index', compact('items'));
        }
    }

    public function create(Request $request)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $item = new ZoneDistrict();
        if ($province_id = $request->input('province_id')) {
            $item->province_id = $province_id;
        }

        if (config('cms.zone.legacy_mode')) {
            return view('zone::admin.district-old.create', compact('item'));
        } else {
            return view('zone::admin.district.create', compact('item'));
        }
    }

    public function store(DistrictRequest $request)
    {
        $item = $this->districtRepository->create($request->all());

        return redirect()
            ->route('zone.admin.district.edit', [
                'district' => $item,
                'edit_locale' => $request->input('edit_locale'),
            ])
            ->with('success', __('zone::district.notification.created'));
    }

    public function edit($id)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $item = $this->districtRepository->find($id);

        if (config('cms.zone.legacy_mode')) {
            return view('zone::admin.district-old.edit', compact('item'));
        } else {
            return view('zone::admin.district.edit', compact('item'));
        }
    }

    public function update(DistrictRequest $request, $id)
    {
        $this->districtRepository->updateById($request->all(), $id);

        return back()->with('success', __('zone::district.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->districtRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('zone::district.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('zone.admin.district.index')
            ->with('success', __('zone::district.notification.deleted'));
    }
}
