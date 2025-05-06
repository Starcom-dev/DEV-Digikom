<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
//import return type View
use Illuminate\View\View;

class PrivacyController extends Controller
{
    public function privacy(): View
    {
        $organisasi = Organisasi::first();
        $privacy = $organisasi->privacy ?? '';
        return view('pages.privacy.privacy', compact('privacy'));
    }
    public function remove(): View
    {
        return view('pages.privacy.remove');
    }
}
