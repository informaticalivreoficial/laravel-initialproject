<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cidades;
use App\Models\Estados;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(25);

        return view('admin.users.index',[
            'users' => $users
        ]);
    }
}
