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
    public function index()
    {
        $posts = Post::orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(25);
        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $categorias = CatPost::orderBy('titulo', 'ASC')->get();
        $users = User::where('admin', '=', '1')->orWhere('superadmin', '=', '1')->get();
        return view('admin.posts.create',[
            'users' => $users,
            'categorias' => $categorias
        ]);
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
}
