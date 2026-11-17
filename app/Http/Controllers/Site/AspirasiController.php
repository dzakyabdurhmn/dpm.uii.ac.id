<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\AspirasiRequest;
use App\Models\Complaint;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AspirasiController extends Controller
{
    public function store(AspirasiRequest $request): JsonResponse
    {
        $nama = Str::squish((string) $request->validated('nama'));
        $kontak = trim((string) $request->validated('kontak'));
        $pesan = trim((string) $request->validated('pesan'));

        $isEmail = filter_var($kontak, FILTER_VALIDATE_EMAIL) !== false;
        $isNim = ! $isEmail && preg_match('/^[0-9]{6,15}$/', $kontak) === 1;

        $complaint = Complaint::query()->create([
            'name' => $nama,
            'email' => $isEmail ? $kontak : null,
            'student_id' => $isNim ? $kontak : null,
            'subject' => Str::limit(Str::squish($pesan), 175, '...'),
            'message' => $pesan,
            'is_anonymous' => false,
            'status' => 'baru',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'data' => [
                'ticket_number' => $complaint->ticket_number,
                'status' => $complaint->status,
                'status_label' => $complaint->status_label,
                'created_at' => $complaint->created_at?->toIso8601String(),
            ],
        ], 201);
    }
}
