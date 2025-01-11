<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\CategoriaDocumento;
use App\Models\CategoriaNoticia;
use App\Models\CategoriaSolucao;
use App\Models\CategoriaTopico;

class CategoriaController extends Controller
{

    public function index($tipo) {
        
        $categorias = [];

        switch ($tipo) {
            case 'noticia':
                $categorias = CategoriaNoticia::all();
                break;
            case 'documento':
                $categorias = CategoriaDocumento::all();
                break;
            case 'topico':
                $categorias = CategoriaTopico::all();
                break;
            case 'solucao':
                $categorias = CategoriaSolucao::all();
                break;
            default:
                return response()->json(['error' => 'Tipo de categoria inválido'], 400);
                break;
        }

        return view('components.tabela-categoria-index', compact('categorias'));
    }

    public function store(Request $request, $tipo)
    {

        switch ($tipo) {
            case 'noticia':
                $categoriaModel = new CategoriaNoticia();
                break;
            case 'documento':
                $categoriaModel = new CategoriaDocumento();
                break;
            case 'topico':
                $categoriaModel = new CategoriaTopico();
                break;
            case 'solucao':
                $categoriaModel = new CategoriaSolucao();
                break;
            default:
                return response()->json(['error' => 'Tipo de categoria inválido'], 400);
                break;
        }

        $categoriaModel->nomeCategoria = $request->nomeCategoria;
        $categoriaModel->idUsuario = $request->idUsuario;

        $categoriaModel->save();

        return redirect()->route('noticias.index');
    }
}
