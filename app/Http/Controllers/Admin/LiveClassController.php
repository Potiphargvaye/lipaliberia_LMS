<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LiveClassController extends Controller
{
    public function index(): View

    {
        $this->authorize('manage live classes');

        return view('admin.live-classes.index');
    }
}
