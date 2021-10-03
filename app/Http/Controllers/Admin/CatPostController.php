<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
