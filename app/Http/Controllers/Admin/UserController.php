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
        $users = User::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->where('client', '1')->paginate(25);

        return view('admin.users.index',[
            'users' => $users
        ]);
    }

    public function team()
    {
        $users = User::where('admin', '=', '1')->orWhere('editor', '=', '1')->paginate(12);
        return view('admin.users.team', [
            'users' => $users    
        ]);
    }

    // public function userSetStatus(Request $request)
    // {        
    //     $user = User::find($request->id);
    //     $user->status = $request->status;
    //     $user->save();
    //     return response()->json(['success' => true]);
    // }

    public function fetchCity(Request $request)
    {
        $data['cidades'] = Cidades::where("estado_id",$request->estado_id)->get(["cidade_nome", "cidade_id"]);
        return response()->json($data);
    } 
    
    public function create()
    {
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get();        

        return view('admin.users.create',[
            'estados' => $estados,
            'cidades' => $cidades
        ]);
    }

    public function edit($id)
    {
        //$tenant = Tenant::where('created_at', '')->all();
        $user = User::where('id', $id)->first();    
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get(); 
        //dd($user->nasc);
        return view('admin.users.edit', [
            'user' => $user,
            //'tenant' => $tenant,
            'estados' => $estados,
            'cidades' => $cidades
        ]);
    }
}
