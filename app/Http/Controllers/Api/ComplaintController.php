<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function store(ComplaintRequest $request): JsonResponse
    {
        $data = $request->validated();

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = 'uploads/'.$file->storeAs(
                'pengaduan/'.now()->format('Y/m'),
                Str::uuid()->toString().'.'.strtolower($file->getClientOriginalExtension() ?: 'bin'),
                'uploads',
            );
        }

        $complaint = Complaint::query()->create([
            'name' => $request->boolean('is_anonymous') ? null : ($data['name'] ?? null),
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'category' => $data['category'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'is_anonymous' => $request->boolean('is_anonymous'),
            'attachment_path' => $attachmentPath,
            'status' => 'baru',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'data' => [
                'ticket_number' => $complaint->ticket_number,
                'status' => $complaint->status,
                'status_label' => $complaint->status_label,
                'created_at' => $complaint->created_at?->toIso8601String(),
                'status_endpoint' => '/api/complaints/'.$complaint->ticket_number,
            ],
        ], 201);
    }

    public function show(string $ticket): JsonResponse
    {
        $complaint = Complaint::query()
            ->where('ticket_number', Str::upper($ticket))
            ->firstOrFail();

        return response()->json([
            'data' => [
                'ticket_number' => $complaint->ticket_number,
                'subject' => $complaint->subject,
                'category' => $complaint->category,
                'status' => $complaint->status,
                'status_label' => $complaint->status_label,
                'response' => $complaint->response,
                'created_at' => $complaint->created_at?->toIso8601String(),
                'responded_at' => $complaint->responded_at?->toIso8601String(),
            ],
        ]);
    }
}
