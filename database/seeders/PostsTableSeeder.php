<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'id' => 1,
                'autor' => 1,
                'tipo' => 'artigo',
                'titulo' => 'Lorem Ipsum is simply dummy',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'lorem-ipsum-is-simply-dummy', 
                'tags' => 'Lorem Ipsum is simply dummy,printing and typesetting,industry standard dummy,Lorem Ipsum has been the industry',
                'views' => '0',
                'categoria' => 3,
                'cat_pai' => 1,
                'status' => '1',
                'comentarios' => '0',
                'thumb_legenda' => 'Legenda da imagem de capa',
                'created_at' => now(),//Data e hora Atual
                'publish_at' => now()//Data e hora Atual
            ],
            [
                'id' => 2,
                'autor' => 1,
                'tipo' => 'artigo',
                'titulo' => 'Lorem Ipsum is simply dummy1',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'lorem-ipsum-is-simply-dummy-1', 
                'tags' => 'Lorem Ipsum is simply dummy,printing and typesetting,industry standard dummy,Lorem Ipsum has been the industry',
                'views' => '0',
                'categoria' => 4,
                'cat_pai' => 2,
                'status' => '1',
                'comentarios' => '0',
                'thumb_legenda' => 'Legenda da imagem de capa',
                'created_at' => now(),//Data e hora Atual
                'publish_at' => now()//Data e hora Atual
            ],
            [
                'id' => 3,
                'autor' => 1,
                'tipo' => 'artigo',
                'titulo' => 'Lorem Ipsum is simply dummy2',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'lorem-ipsum-is-simply-dummy-2', 
                'tags' => 'Lorem Ipsum is simply dummy,printing and typesetting,industry standard dummy,Lorem Ipsum has been the industry',
                'views' => '0',
                'categoria' => 3,
                'cat_pai' => 1,
                'status' => '1',
                'comentarios' => '0',
                'thumb_legenda' => 'Legenda da imagem de capa',
                'created_at' => now(),//Data e hora Atual
                'publish_at' => now()//Data e hora Atual
            ],
            [
                'id' => 4,
                'autor' => 1,
                'tipo' => 'artigo',
                'titulo' => 'Lorem Ipsum is simply dummy3',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'slug' => 'lorem-ipsum-is-simply-dummy-3', 
                'tags' => 'Lorem Ipsum is simply dummy,printing and typesetting,industry standard dummy,Lorem Ipsum has been the industry',
                'views' => '0',
                'categoria' => 4,
                'cat_pai' => 2,
                'status' => '1',
                'comentarios' => '0',
                'thumb_legenda' => 'Legenda da imagem de capa',
                'created_at' => now(),//Data e hora Atual
                'publish_at' => now()//Data e hora Atual
            ]
        ]);
    }
}
