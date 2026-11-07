<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $query = Complaint::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', '%'.$request->search.'%')
                    ->orWhere('name', 'like', '%'.$request->search.'%')
                    ->orWhere('subject', 'like', '%'.$request->search.'%');
            });
        }

        $aspirasi = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.aspirasi.index', compact('aspirasi'));
    }

    public function edit(Complaint $aspirasi): View
    {
        return view('admin.aspirasi.edit', compact('aspirasi'));
    }

    public function update(Request $request, Complaint $aspirasi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai,ditolak'],
            'response' => ['nullable', 'string'],
        ]);

        $aspirasi->update([
            'status' => $validated['status'],
            'response' => $validated['response'],
            'responded_at' => filled($validated['response']) ? now() : null,
        ]);

        return redirect()->route('admin.aspirasi.index')
            ->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Complaint $aspirasi): RedirectResponse
    {
        $aspirasi->delete();

        return redirect()->route('admin.aspirasi.index')
            ->with('success', 'Aspirasi berhasil dihapus.');
    }
}
