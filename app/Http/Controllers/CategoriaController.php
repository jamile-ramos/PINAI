<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaDocumento;
use App\Models\CategoriaNoticia;
use App\Models\CategoriaSolucao;
use App\Models\CategoriaTopico;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    private $modelMap = [
        'noticias' => CategoriaNoticia::class,
        'documento' => CategoriaDocumento::class,
        'topicos' => CategoriaTopico::class,
        'solucao' => CategoriaSolucao::class,
    ];

    public function store(Request $request, $tipo)
    {
        $model = $this->getModelByTipo($tipo);

        if ($model === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        $categoriaModel = new $model;
        $categoriaModel->nomeCategoria = $request->nomeCategoria;
        $categoriaModel->idUsuario = Auth::User()->id;
        $categoriaModel->save();

        return redirect()->route("{$tipo}.index")->with('success', 'Categoria criada com sucesso!');
    }

    public function delete(Request $request, $tipo)
    {
        $id = $request->id;

        $model = $this->getModelByTipo($tipo);

        if ($model === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        $model::destroy($id);

        return redirect()->route("{$tipo}.index")->with('success', 'Categoria excluida com sucesso!');
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

