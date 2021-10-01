<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => env('ADMIN_NOME'),
                'email' => env('ADMIN_EMAIL'),
                'email_verified_at' => now(),
                'password' => bcrypt(env('ADMIN_PASS')),
                'senha' => env('ADMIN_PASS'),
                'remember_token' => \Illuminate\Support\Str::random(10),
                'cpf' => '11111111111',
                'rg' => '111111111',            
                'uf' => '25',
                'nasc' => '2004-12-14',
                'created_at' => now(),//Data e hora Atual
                'genero' => 'masculino',
                'cidade' => '5351',
                'telefone' => '11111111',
                'celular' => '11111111',
                'whatsapp' => '11111111',
                'superadmin' => 1,
                'status' => 1
            ]            
        ]);
    }
}
