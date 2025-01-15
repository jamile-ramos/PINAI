<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaDocumento;
use App\Models\CategoriaNoticia;
use App\Models\CategoriaSolucao;
use App\Models\CategoriaTopico;
use Illuminate\Contracts\View\View;

class CategoriaController extends Controller
{
    private $modelMap = [
        'noticia' => CategoriaNoticia::class,
        'documento' => CategoriaDocumento::class,
        'topico' => CategoriaTopico::class,
        'solucao' => CategoriaSolucao::class,
    ];

    public function index($tipo)
    {
        $categorias = $this->getCategoriasByTipo($tipo);

        if ($categorias === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        return view('components.tabela-categoria-index', compact('categorias', 'tipo'));
    }

    public function create($tipo)
    {
        $categorias = $this->getCategoriasByTipo($tipo);

        if ($categorias === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        return response()->json($categorias);
    }

    public function store(Request $request, $tipo)
    {
        $model = $this->getModelByTipo($tipo);

        if ($model === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        $categoriaModel = new $model;
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

        $model = $this->getModelByTipo($tipo);

        if ($model === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        $model::destroy($id);

        $categorias = $this->getCategoriasByTipo($tipo);
        return view('components.tabela-categoria-index', compact('categorias', 'tipo'))
            ->with('success', 'Categoria excluída com sucesso!');
    }

    private function getCategoriasByTipo($tipo)
    {
        $model = $this->getModelByTipo($tipo);
        return $model ? $model::all() : null;
    }

    private function getModelByTipo($tipo)
    {
        return $this->modelMap[$tipo] ?? null;
    }
}

