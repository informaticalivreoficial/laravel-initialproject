<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CatPost as CatPostRequest;
use Illuminate\Http\Request;
use App\Models\CatPost;

class CatPostController extends Controller
{
    public function index()
    {
        $categorias = CatPost::orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(25);
        return view('admin.categorias.index', [
            'categorias' => $categorias
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.categorias.create',[
            'catpai' => $request->catpai
        ]);
    }

    public function store(CatPostRequest $request)
    {
        $criarCategoria = CatPost::create($request->all());
        $criarCategoria->fill($request->all());

        $criarCategoria->setSlug();
        
        if($request->id_pai != null){
            return redirect()->route('categorias.edit', [
                'id' => $criarCategoria->id,
            ])->with(['color' => 'success', 'message' => 'Sub Categoria cadastrada com sucesso!']);
        }else{
            return redirect()->route('categorias.edit', [
                'id' => $criarCategoria->id,
            ])->with(['color' => 'success', 'message' => 'Categoria cadastrada com sucesso!']);
        }
    }

    public function edit($id)
    {
        $categoria = CatPost::where('id', $id)->first();
        return view('admin.categorias.edit', [
            'categoria' => $categoria,
        ]);
    }

    public function update(CatPostRequest $request, $id)
    {
        $categoria = CatPost::where('id', $id)->first();
        $categoria->fill($request->all());

        $categoria->save();
        $categoria->setSlug();
        
        if($categoria->id_pai != null){
            return redirect()->route('categorias.edit', [
                'id' => $categoria->id,
            ])->with(['color' => 'success', 'message' => 'Sub Categoria atualizada com sucesso!']);
        }else{
            return redirect()->route('categorias.edit', [
                'id' => $categoria->id,
            ])->with(['color' => 'success', 'message' => 'Categoria atualizada com sucesso!']);
        }
        
    }
}
