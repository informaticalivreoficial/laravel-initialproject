<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Post as PostRequest;
use App\Models\User;
use App\Models\Post;
use App\Models\PostGb;
use App\Models\CatPost;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if($request->segments()[2] == 'artigos'){
            $tipo = 'artigo';
            $linkView = 'blog.artigo';
            $tituloPagina = 'Artigos';
        }elseif($request->segments()[2] == 'noticias'){
            $tipo = 'noticia';
            $linkView = 'noticia';
            $tituloPagina = 'Notícias';
        }elseif($request->segments()[2] == 'paginas'){
            $tipo = 'pagina';
            $linkView = 'pagina';
            $tituloPagina = 'Páginas';
        }

        $posts = Post::where('tipo', $tipo)->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(25);
        
        return view('admin.posts.index', [
            'posts' => $posts,
            'tituloPagina' => $tituloPagina,
            'linkView' => $linkView
        ]);
    }    

    public function create()
    {
        $categorias = CatPost::orderBy('titulo', 'ASC')->get();
        $users = User::where('admin', '=', '1')->orWhere('editor', '=', '1')->get();
        return view('admin.posts.create',[
            'users' => $users,
            'categorias' => $categorias
        ]);
    }

    public function store(PostRequest $request)
    {
        $criarPost = Post::create($request->all());
        $criarPost->fill($request->all());

        $secao = ($request->tipo == 'artigo' ? 'artigos' : 
                 ($request->tipo == 'noticia' ? 'noticias' : 
                 ($request->tipo == 'pagina' ? 'paginas' : 'posts')));

        $criarPost->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }
        
        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $postGb = new PostGb();
                $postGb->post = $criarPost->id;
                $postGb->path = $image->storeAs($secao.'/' . $criarPost->id, Str::slug($request->titulo) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $postGb->save();
                unset($postGb);
            }
        }
        return redirect()->route('posts.edit', [
            'id' => $criarPost->id,
        ])->with(['color' => 'success', 'message' => $request->tipo.' cadastrado com sucesso!']);
    }

    public function edit($id)
    {
        $categorias = CatPost::orderBy('titulo', 'ASC')->get();
        $editarPost = Post::where('id', $id)->first();
        $users = User::where('admin', '=', '1')->orWhere('editor', '=', '1')->get();

        if($editarPost->tipo == 'artigo'){
            $tipo = 'artigos';
            $tituloPagina = 'Artigo';
        }elseif($editarPost->tipo == 'noticia'){
            $tipo = 'noticias';
            $tituloPagina = 'Notícia';
        }elseif($editarPost->tipo == 'pagina'){
            $tipo = 'paginas';
            $tituloPagina = 'Página';
        }
        
        return view('admin.posts.edit', [
            'post' => $editarPost,
            'users' => $users,
            'categorias' => $categorias,
            'tituloPagina' => $tituloPagina,
            'tipo' => $tipo
        ]);
    }

    public function update(PostRequest $request, $id)
    {
        $postUpdate = Post::where('id', $id)->first();
        $postUpdate->fill($request->all());

        $secao = ($request->tipo == 'artigo' ? 'artigos' : 
                 ($request->tipo == 'noticia' ? 'noticias' : 
                 ($request->tipo == 'pagina' ? 'paginas' : 'posts')));

        $postUpdate->save();
        $postUpdate->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $postImage = new PostGb();
                $postImage->post = $postUpdate->id;
                $postImage->path = $image->storeAs($secao.'/' . $postUpdate->id, Str::slug($request->titulo) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $postImage->save();
                unset($postImage);
            }
        }

        return redirect()->route('posts.edit', [
            'id' => $postUpdate->id,
        ])->with(['color' => 'success', 'message' => $request->tipo.' atualizado com sucesso!']);
    } 

    public function postSetStatus(Request $request)
    {        
        $post = Post::find($request->id);
        $post->status = $request->status;
        $post->save();
        return response()->json(['success' => true]);
    }

    public function categoriaList(Request $request)
    {   
        $allData = array();
        $categorias = CatPost::where('tipo', '=', $request->categoria_tipo)->where('id_pai', null)->get();     
        foreach($categorias as $key => $categoria){
            $allData[$key]['catTitulo'] = $categoria->titulo;
            $allData[$key]['catId'] = $categoria->id;

            $subCat = array();
            if($categoria->children){
                foreach($categoria->children as $k => $subcategoria){
                    $subCat['id'] = $subcategoria->id; 
                    $subCat['titulo'] = $subcategoria->titulo; 
                }
            }
            $allData[$key]['subcategory'] = $subCat;       
        }       
        return response()->json(['data' => $allData]);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = PostGb::where('id', $request->image)->first();
        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();
        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = PostGb::where('id', $request->image)->first();
        $allImage = PostGb::where('post', $imageSetCover->post)->get();
        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }
        $imageSetCover->cover = true;
        $imageSetCover->save();
        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }

    public function delete(Request $request)
    {
        $postdelete = Post::where('id', $request->id)->first();
        $postGb = PostGb::where('post', $postdelete->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        $tipo = ($postdelete->tipo == 'artigo' ? 'este artigo' : 
                 ($postdelete->tipo == 'noticia' ? 'esta notícia' : 
                 ($postdelete->tipo == 'pagina' ? 'esta página' : 'este post')));

        if(!empty($postdelete)){
            if(!empty($postGb)){
                $json = "<b>$nome</b> você tem certeza que deseja excluir $tipo? Existem imagens adicionadas e todas serão excluídas!";
                return response()->json(['error' => $json,'id' => $postdelete->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir $tipo?";
                return response()->json(['error' => $json,'id' => $postdelete->id]);
            }            
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }
    }
    
    public function deleteon(Request $request)
    {
        $postdelete = Post::where('id', $request->post_id)->first();  
        $imageDelete = PostGb::where('post', $postdelete->id)->first();
        $postR = $postdelete->titulo;

        $secao = ($postdelete->tipo == 'artigo' ? 'artigos' : 
                 ($postdelete->tipo == 'noticia' ? 'noticias' : 
                 ($postdelete->tipo == 'pagina' ? 'paginas' : 'posts')));

        if(!empty($postdelete)){
            if(!empty($imageDelete)){
                Storage::delete($imageDelete->path);
                Cropper::flush($imageDelete->path);
                $imageDelete->delete();
                Storage::deleteDirectory($secao.'/'.$postdelete->id);
                $postdelete->delete();
            }
            $postdelete->delete();
        }
        return redirect()->route('posts.'.$secao.'')->with([
            'color' => 'success', 
            'message' => $postdelete->tipo.' '.$postR.' foi removido com sucesso!'
        ]);
    }
}
