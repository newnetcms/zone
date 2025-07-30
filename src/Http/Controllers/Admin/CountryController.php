<?php

namespace Newnet\Zone\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Zone\Http\Requests\CountryRequest;
use Newnet\Zone\Repositories\CountryRepository;
use Newnet\Zone\ZoneAdminMenuKey;

class CountryController extends Controller
{
    protected CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index(Request $request)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $items = $this->countryRepository->paginate($request->input('max', 20));

        return view('zone::admin.country.index', compact('items'));
    }

    public function create()
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        return view('zone::admin.country.create');
    }

    public function store(CountryRequest $request)
    {
        $item = $this->countryRepository->create($request->all());

        return redirect()
            ->route('zone.admin.country.edit', [
                'country' => $item,
                'edit_locale' => $request->input('edit_locale'),
            ])
            ->with('success', __('zone::country.notification.created'));
    }

    public function edit($id)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);

        $item = $this->countryRepository->find($id);

        return view('zone::admin.country.edit', compact('item'));
    }

    public function update(CountryRequest $request, $id)
    {
        $this->countryRepository->updateById($request->all(), $id);

        return back()->with('success', __('zone::country.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->countryRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('zone::country.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('zone.admin.country.index')
            ->with('success', __('zone::country.notification.deleted'));
    }
}
