<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\User as UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Support\Cropper;
use App\Models\Cidades;
use App\Models\Estados;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getUsers();
        return view('admin.users.index',[
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = $this->userService->getUser($id);
        return view('admin.users.view',[
            'user' => $user
        ]);
    }

    public function team()
    {
        $team = $this->userService->getTeam();
        return view('admin.users.team', [
            'team' => $team   
        ]);
    }

    public function userSetStatus(Request $request)
    {   
        $status = $this->userService->setStatus($request->all()); 
        return response()->json($status);
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

        $nasc = Carbon::createFromFormat('d/m/Y', $request->nasc)->format('d-m-Y');        
        
        if(Carbon::parse($nasc)->age < 18){
            return redirect()->back()->with(['color' => 'danger', 'message' => 'Data de nascimento inválida!']);
        }

        if($request->estado_civil == 'casado'){
            $nasc_conjuje = Carbon::createFromFormat('d/m/Y', $request->nasc_conjuje)->format('d-m-Y');
            if(Carbon::parse($nasc_conjuje)->age < 18){
                return redirect()->back()->with(['color' => 'danger', 'message' => 'Data de nascimento do conjuje inválida!']);
            }            
        }

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
            return redirect()->back()->withInput()->withErrors('erro');
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

    public function delete(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);
        if(!empty($user)){
            if($user->id == Auth::user()->id){
                $json = "<b>$nome</b> você não pode excluir sua própria conta!";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->superadmin == 1){
                $json = "<b>$nome</b> você não pode excluir um Super Administrador!";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->admin == 1 && $user->client == 1){
                $json = "<b>$nome</b> você tem certeza que deseja excluir este Administrador? Ele também é um Cliente";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->admin == 1){
                $json = "<b>$nome</b> você tem certeza que deseja excluir um Administrador?";
                return response()->json(['error' => $json,'id' => $user->id]);
            }elseif($user->admin == 0 && $user->client == 1){
                $json = "<b>$nome</b> você tem certeza que deseja excluir este Cliente?";
                return response()->json(['error' => $json,'id' => $user->id]);
            }else{
                return response()->json(['success' => true]);
            }
        }
    }

    public function deleteon(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();        
        if(!empty($user)){
            $perfil = ($user->admin == '1' && $user->client == '1' ? 'Administrador e Cliente' :
                      ($user->admin == '1' && $user->client == '0' ? 'Administrador' :
                      ($user->admin == '0' && $user->client == '1' ? 'Cliente' : 'Cliente')));
            Storage::delete($user->avatar);
            Cropper::flush($user->avatar);
            $user->delete();
        }
        if($user->admin == '1' || $user->Editor == '1'){
            $page = 'team';
        }else{
            $page = 'index';
        }
        
        return redirect()->route('users.'.$page)->with(['color' => 'success', 'message' => $perfil.' removido com sucesso!']);
    }
}
