<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BioLink;

class BioLinkController extends Controller
{
    public function index()
    {
        $bioLink = BioLink::getActive();

        if (! $bioLink) {
            abort(404, 'Bio link tidak ditemukan atau tidak aktif.');
        }

        $bioLink->load([
            'activeGroups.activeItems',
            'activeFeatures',
        ]);

        return view('site.bio-link', [
            'bioLink' => $bioLink,
        ]);
    }
}
