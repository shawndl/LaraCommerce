<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbstractAdminController extends Controller
{
    /**
     * AdminHomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }
}
