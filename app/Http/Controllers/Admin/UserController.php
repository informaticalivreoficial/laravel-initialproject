<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\User as UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Support\Cropper;
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

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.users.view',[
            'user' => $user
        ]);
    }

    public function team()
    {
        $users = User::where('admin', '=', '1')->orWhere('editor', '=', '1')->paginate(12);
        return view('admin.users.team', [
            'users' => $users    
        ]);
    }

    public function userSetStatus(Request $request)
    {        
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true]);
    }

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
    
    public function store(UserRequest $request)
    {
        $data = $request->all();
        if($request->client == '' && $request->admin == '' && $request->editor == '' && $request->superadmin == ''){
            $data['client'] = 'on';
        }        

        $userCreate = User::create($data);
        if(!empty($request->file('avatar'))){
            $userCreate->avatar = $request->file('avatar')->storeAs('user', Str::slug($request->name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('avatar')->extension());
            $userCreate->save();
        }
        return redirect()->route('users.edit', $userCreate->id)->with(['color' => 'success', 'message' => 'Cadastro realizado com sucesso!']);        
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();    
        $estados = Estados::orderBy('estado_nome', 'ASC')->get();
        $cidades = Cidades::orderBy('cidade_nome', 'ASC')->get(); 
        
        return view('admin.users.edit', [
            'user' => $user,
            'estados' => $estados,
            'cidades' => $cidades
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->first();

        $user->setAdminAttribute($request->admin);
        $user->setEditorAttribute($request->editor);
        $user->setClientAttribute($request->client);
        $user->setSuperAdminAttribute($request->superadmin);

        if(!empty($request->file('avatar'))){
            Storage::delete($user->avatar);
            Cropper::flush($user->avatar);
            $user->avatar = '';
        }

        $user->fill($request->all());

        if(!empty($request->file('avatar'))){
            $user->avatar = $request->file('avatar')->storeAs('user', Str::slug($request->name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('avatar')->extension());
        }

        if(!$user->save()){
            return redirect()->back()->withInput()->withErrors();
        }

        return redirect()->route('users.edit', $user->id)->with([
            'color' => 'success', 
            'message' => 'Usuário atualizado com sucesso!'
        ]);
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $users = User::where(function($query) use ($request){
            if($request->filter){
                $query->orWhere('name', 'LIKE', "%{$request->filter}%");
                $query->orWhere('email', $request->filter);
            }
        })->where('client', '1')->paginate(25);

        return view('admin.users.index',[
            'users' => $users,
            'filters' => $filters
        ]);
    }
}
