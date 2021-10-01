<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CatPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_post')->insert([
            [
                'id' => 1,
                'id_pai' => null,
                'titulo' => 'Tecnologia',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'tecnologia', 
                'tags' => 'tecnologia,artigos sobre tecnologia,notícias sobre tecnologia',
                'status' => '1',
                'tipo' => 'artigo',
                'created_at' => now()//Data e hora Atual
            ],
            [
                'id' => 2,
                'id_pai' => null,
                'titulo' => 'Meio Ambiente',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'meio-ambiente', 
                'tags' => 'meio ambiente,artigos sobre meio ambiente,notícias sobre meio ambiente',
                'status' => '1',
                'tipo' => 'artigo',
                'created_at' => now()//Data e hora Atual
            ],
            [
                'id' => 3,
                'id_pai' => 1,
                'titulo' => 'Dicas de informática',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'dicas-de-informatica', 
                'tags' => 'Dicas de informática,artigos sobre Dicas de informática,notícias sobre Dicas de informática',
                'status' => '1',
                'tipo' => 'artigo',
                'created_at' => now()//Data e hora Atual
            ],
            [
                'id' => 4,
                'id_pai' => 2,
                'titulo' => 'Curiosidades',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'curiosidades', 
                'tags' => 'Curiosidades,artigos sobre Curiosidades do Meio Ambiente,notícias sobre Curiosidades do Meio Ambiente',
                'status' => '1',
                'tipo' => 'artigo',
                'created_at' => now()//Data e hora Atual
            ]
        ]);
    }
}
