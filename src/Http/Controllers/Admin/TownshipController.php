<?php

namespace Newnet\Zone\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Zone\Http\Requests\TownshipRequest;
use Newnet\Zone\Models\ZoneDistrict;
use Newnet\Zone\Models\ZoneTownship;
use Newnet\Zone\Repositories\TownshipRepository;
use Newnet\Zone\ZoneAdminMenuKey;

class TownshipController extends Controller
{
    protected TownshipRepository $townshipRepository;

    public function __construct(TownshipRepository $townshipRepository)
    {
        $this->townshipRepository = $townshipRepository;
    }

    public function index(Request $request)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $items = $this->townshipRepository->paginate($request->input('max', 20));

        $district = null;
        if ($district_id = $request->input('district_id')) {
            $district = ZoneDistrict::find($district_id);
        }

        return view('zone::admin.township.index', compact('items', 'district'));
    }

    public function create(Request $request)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $item = new ZoneTownship();
        if ($district_id = $request->input('district_id')) {
            $item->district_id = $district_id;
        } else {
            return back();
        }

        return view('zone::admin.township.create', compact('item'));
    }

    public function store(TownshipRequest $request)
    {
        $item = $this->townshipRepository->create($request->all());

        return redirect()
            ->route('zone.admin.township.edit', [
                'township' => $item,
                'edit_locale' => $request->input('edit_locale'),
            ])
            ->with('success', __('zone::township.notification.created'));
    }

    public function edit($id)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $item = $this->townshipRepository->find($id);

        return view('zone::admin.township.edit', compact('item'));
    }

    public function update(TownshipRequest $request, $id)
    {
        $this->townshipRepository->updateById($request->all(), $id);

        return back()->with('success', __('zone::township.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->townshipRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('zone::township.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('zone.admin.township.index')
            ->with('success', __('zone::township.notification.deleted'));
    }
}
