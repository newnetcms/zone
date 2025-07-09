<?php

namespace Newnet\Zone\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Zone\Http\Requests\DistrictRequest;
use Newnet\Zone\Repositories\DistrictRepository;
use Newnet\Zone\ZoneAdminMenuKey;

class DistrictController extends Controller
{
    protected DistrictRepository $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);
        $this->districtRepository = $districtRepository;
    }

    public function index(Request $request)
    {
        $items = $this->districtRepository->paginate($request->input('max', 20));

        return view('zone::admin.district.index', compact('items'));
    }

    public function create()
    {
        return view('zone::admin.district.create');
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
        $item = $this->districtRepository->find($id);

        return view('zone::admin.district.edit', compact('item'));
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
