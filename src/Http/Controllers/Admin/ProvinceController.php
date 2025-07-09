<?php

namespace Newnet\Zone\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Zone\Http\Requests\ProvinceRequest;
use Newnet\Zone\Repositories\ProvinceRepository;
use Newnet\Zone\ZoneAdminMenuKey;

class ProvinceController extends Controller
{
    protected ProvinceRepository $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);
        $this->provinceRepository = $provinceRepository;
    }

    public function index(Request $request)
    {
        $items = $this->provinceRepository->paginate($request->input('max', 20));

        return view('zone::admin.provinces.index', compact('items'));
    }

    public function create()
    {
        return view('zone::admin.provinces.create');
    }

    public function store(ProvinceRequest $request)
    {
        $item = $this->provinceRepository->create($request->all());

        return redirect()
            ->route('zone.admin.province.edit', [
                'province' => $item,
                'edit_locale' => $request->input('edit_locale'),
            ])
            ->with('success', __('zone::province.notification.created'));
    }

    public function edit($id)
    {
        $item = $this->provinceRepository->find($id);

        return view('zone::admin.provinces.edit', compact('item'));
    }

    public function update(ProvinceRequest $request, $id)
    {
        $this->provinceRepository->updateById($request->all(), $id);

        return back()->with('success', __('zone::province.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->provinceRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('zone::province.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('zone.admin.provinces.index')
            ->with('success', __('zone::province.notification.deleted'));
    }
}
