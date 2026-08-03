<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /**
     * Admissions queue — one row per Application, with Pending/Approved/
     * Rejected/Cancelled tabs. All interactivity lives in
     * App\Livewire\Admin\Applications\Index.
     */
    public function index(): View
    {
        $this->authorize('review applications');

        return view('admin.applications.index');
    }
}
