<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menu = $this->headerMenu();

        return view('admin.menu.index', [
            'menu' => $menu,
            'items' => MenuItem::query()
                ->where('menu_id', $menu->id)
                ->whereNull('parent_id')
                ->with('children')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.menu.form', [
            'item' => new MenuItem([
                'parent_id' => $request->integer('parent') ?: null,
                'sort_order' => 0,
                'is_active' => true,
            ]),
            'parents' => $this->topLevelItems(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->headerMenu()->items()->create($this->validated($request));

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Item menu berhasil ditambahkan.');
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('admin.menu.form', [
            'item' => $menuItem,
            'parents' => $this->topLevelItems($menuItem->getKey()),
        ]);
    }

    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $menuItem->update($this->validated($request));

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Item menu berhasil diperbarui.');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Item menu berhasil dihapus.');
    }

    /**
     * @return Collection<int, MenuItem>
     */
    private function topLevelItems(?int $exceptId = null)
    {
        return MenuItem::query()
            ->where('menu_id', $this->headerMenu()->id)
            ->whereNull('parent_id')
            ->when($exceptId, fn ($query) => $query->whereKeyNot($exceptId))
            ->orderBy('sort_order')
            ->get();
    }

    private function headerMenu(): Menu
    {
        return Menu::query()->firstOrCreate(
            ['location' => 'header'],
            ['name' => 'Menu Utama'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $data = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'url' => ['nullable', 'string', 'max:2048'],
            'parent_id' => ['nullable', 'integer', 'exists:menu_items,id'],
            'target' => ['required', 'in:_self,_blank'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
