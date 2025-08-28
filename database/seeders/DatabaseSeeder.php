<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Nai;
use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use App\Models\Topico;
use App\Models\Postagem;
use App\Models\Resposta;
use App\Models\Comentario;
use App\Models\CategoriaDocumento;
use App\Models\Documento;
use App\Models\CategoriaSolucao;
use App\Models\PublicoAlvo;
use App\Models\Solucao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            NaiSeeder::class,
            UserSeeder::class,
            CategoriaNoticiaSeeder::class,
            NoticiaSeeder::class,
            TopicoSeeder::class,
            PostagemSeeder::class,
            RespostaSeeder::class,
            ComentarioSeeder::class,
            CategoriaDocumentoSeeder::class,
            DocumentoSeeder::class,
            CategoriaSolucaoSeeder::class,
            PublicoAlvoSeeder::class,
            SolucaoSeeder::class,
            SugestaoTopicoSeeder::class
        ]);
    }
}
