<?php

namespace Newnet\Zone\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\AdminUi\Facades\AdminMenu;
use Newnet\Zone\Http\Requests\TownshipRequest;
use Newnet\Zone\Repositories\TownshipRepository;
use Newnet\Zone\ZoneAdminMenuKey;

class TownshipController extends Controller
{
    protected TownshipRepository $townshipRepository;

    public function __construct(TownshipRepository $townshipRepository)
    {
        AdminMenu::activeMenu(ZoneAdminMenuKey::ZONE);
        $this->townshipRepository = $townshipRepository;
    }

    public function index(Request $request)
    {
        $items = $this->townshipRepository->paginate($request->input('max', 20));

        return view('zone::admin.townships.index', compact('items'));
    }

    public function create()
    {
        return view('zone::admin.townships.create');
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
        $item = $this->townshipRepository->find($id);

        return view('zone::admin.townships.edit', compact('item'));
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
            ->route('zone.admin.townships.index')
            ->with('success', __('zone::township.notification.deleted'));
    }
}
