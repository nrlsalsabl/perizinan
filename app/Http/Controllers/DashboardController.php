<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission; // Import the Permission model
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::all();
        $userCount = User::count();
        $roleCount = Role::count();
        $permissionCount = Permission::count(); // Assuming you have a Permission model

        // dd($user);

        return view('dashboard', compact('userCount', 'roleCount', 'permissionCount', 'user'));
    }
}
