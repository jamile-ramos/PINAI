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

    public function index($tipo)
    {

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

        return view('components.tabela-categoria-index', compact('categorias', 'tipo'));
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

        $categorias = $this->getCategoriasByTipo($tipo);
        return view('components.tabela-categoria-index', compact('categorias', 'tipo'))
        ->with('success', 'Categoria salva com sucesso!');
    }

    public function delete(Request $request, $tipo)
    {
        $id = $request->categoriaId;

        switch ($tipo) {
            case 'noticia':
                CategoriaNoticia::destroy($id);
                break;
            case 'documento':
                CategoriaDocumento::destroy($id);
                break;
            case 'topico':
                CategoriaTopico::destroy($id);
                break;
            case 'solucao':
                CategoriaSolucao::destroy($id);
                break;
            default:
                return response()->json(['error' => 'Tipo de categoria inválido'], 400);
                break;
        }

        $categorias = $this->getCategoriasByTipo($tipo);
        return view('components.tabela-categoria-index', compact('categorias', 'tipo'))
        ->with('success', 'Categoria excluida com sucesso!');
    }

    private function getCategoriasByTipo($tipo)
    {
        switch ($tipo) {
            case 'noticia':
                return CategoriaNoticia::all();
            case 'documento':
                return CategoriaDocumento::all();
            case 'topico':
                return CategoriaTopico::all();
            case 'solucao':
                return CategoriaSolucao::all();
            default:
                return [];
        }
    }
}
