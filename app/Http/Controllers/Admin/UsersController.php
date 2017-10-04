<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends AbstractAdminController
{
    /**
     * Display all the users details
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._users',
            'users' => $user->paginate(10)
        ]);
    }

    /**
     * Display all the users addresses
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addresses(User $user)
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._usersAddresses',
            'user' => $user
        ]);
    }

    /**
     * Display all the users orders
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders(User $user)
    {
        return view('admin.index', [
            'table' => 'admin._includes._tables._usersOrders',
            'user' => $user
        ]);
    }
}
