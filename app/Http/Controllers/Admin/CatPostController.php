<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CatPost as CatPostRequest;
use Illuminate\Http\Request;
use App\Models\CatPost;
use App\Models\Post;
use App\Models\PostGb;
use CoffeeCode\Cropper\Cropper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CatPostController extends Controller
{
    public function index()
    {
        $categorias = CatPost::where('id_pai', null)->orderBy('tipo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')->paginate(25);
        return view('admin.categorias.index', [
            'categorias' => $categorias
        ]);
    }

    public function create(Request $request)
    {        
        $catpai = CatPost::where('id', $request->catpai)->first();
        
        return view('admin.categorias.create',[
            'catpai' => $catpai
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
        if($categoria->id_pai != null){
            $catpai = CatPost::where('id', $categoria->id_pai)->first();
        }else{
            $catpai = null;
        }
        return view('admin.categorias.edit', [
            'categoria' => $categoria,
            'catpai' => $catpai
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

    public function delete(Request $request)
    {
        $categoria = CatPost::where('id', $request->id)->first();
        $subcategoria = CatPost::where('id_pai', $request->id)->first();
        $post = Post::where('categoria', $request->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        $secao = ($categoria->tipo == 'artigo' ? 'artigos' : 
                 ($categoria->tipo == 'noticia' ? 'notícias' : 
                 ($categoria->tipo == 'pagina' ? 'páginas' : 'posts')));

        if(!empty($categoria) && empty($subcategoria)){
            if($categoria->id_pai == null){
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta categoria?";
                return response()->json(['erroron' => $json,'id' => $categoria->id]);
            }else{
                // se tiver posts
                if(!empty($post)){
                    $json = "<b>$nome</b> você tem certeza que deseja excluir esta sub categoria? Ela possui $secao e tudo será excluído!";
                    return response()->json(['erroron' => $json,'id' => $categoria->id]);
                }else{
                    $json = "<b>$nome</b> você tem certeza que deseja excluir esta sub categoria?";
                    return response()->json(['erroron' => $json,'id' => $categoria->id]);
                }                
            }            
        }
        if(!empty($categoria) && !empty($subcategoria)){
            $json = "<b>$nome</b> esta categoria possui sub categorias! É peciso excluí-las primeiro!";
            return response()->json(['error' => $json,'id' => $categoria->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }        
    }

    public function deleteon(Request $request)
    {
        $categoria = CatPost::where('id', $request->categoria_id)->first();  
        $post = Post::where('categoria', $request->id)->first();

        $secao = ($categoria->tipo == 'artigo' ? 'artigos' : 
                 ($categoria->tipo == 'noticia' ? 'notícias' : 
                 ($categoria->tipo == 'pagina' ? 'páginas' : 'posts')));

        $categoriaR = $categoria->titulo;

        if(!empty($categoria)){
            if(!empty($post) && !empty($postgb)){
                $postgb = PostGb::where('post', $post->id)->first();
                Storage::delete($postgb->path);
                Cropper::flush($postgb->path);
                $postgb->delete();
                Storage::deleteDirectory($secao.'/'.$post->id);
                $categoria->delete();
            }
            $categoria->delete();
        }

        if($categoria->id_pai != null){
            return redirect()->route('categorias.index')->with([
                'color' => 'success', 
                'message' => 'A sub categoria '.$categoriaR.' foi removida com sucesso!'
            ]);
        }else{
            return redirect()->route('categorias.index')->with([
                'color' => 'success', 
                'message' => 'A categoria '.$categoriaR.' foi removida com sucesso!'
            ]);
        }        
    }
}
