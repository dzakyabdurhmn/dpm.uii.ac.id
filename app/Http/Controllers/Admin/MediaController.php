<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaUploadRequest;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $imagesOnly = $request->boolean('images');

        $media = Media::query()
            ->when($imagesOnly, fn ($query) => $query->where('mime_type', 'like', 'image/%'))
            ->latest('id')
            ->paginate(24)
            ->withQueryString();

        return view('admin.media.index', [
            'media' => $media,
            'imagesOnly' => $imagesOnly,
        ]);
    }

    public function store(MediaUploadRequest $request): JsonResponse|RedirectResponse
    {
        $file = $request->file('file');
        $directory = now()->format('Y/m');
        $extension = strtolower($file->getClientOriginalExtension() ?: 'bin');
        $filename = Str::uuid()->toString().'.'.$extension;

        $path = $file->storeAs($directory, $filename, 'uploads');

        $media = Media::query()->create([
            'name' => $file->getClientOriginalName(),
            'file_path' => 'uploads/'.$path,
            'mime_type' => $file->getMimeType() ?: $file->getClientMimeType(),
            'size' => (int) $file->getSize(),
            'alt_text' => $request->input('alt_text'),
            'user_id' => $request->user()?->getKey(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $media->id,
                'name' => $media->name,
                'url' => $media->url,
                'is_image' => $media->isImage(),
            ]);
        }

        return back()->with('success', 'Berkas "'.$media->name.'" berhasil diunggah.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        Storage::disk('uploads')->delete(Str::after($media->file_path, 'uploads/'));

        $media->delete();

        return back()->with('success', 'Berkas berhasil dihapus.');
    }
}
