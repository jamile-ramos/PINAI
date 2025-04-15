<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaDocumento;
use App\Models\CategoriaNoticia;
use App\Models\CategoriaSolucao;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    private $modelMap = [
        'noticias' => CategoriaNoticia::class,
        'documentos' => CategoriaDocumento::class,
        'solucao' => CategoriaSolucao::class,
    ];

    public function store(Request $request, $tipo)
    {
        $request->validate([
            'nomeCategoria' => 'required|string|max:255'
        ]);

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

    public function destroy(Request $request, $tipo)
    {
        $model = $this->getModelByTipo($tipo);

        if ($model === null) {
            return response()->json(['error' => 'Tipo de categoria inválido'], 400);
        }

        $categoria = $model::findOrFail($request->id);
        $categoria->update(['status' => 'inativo']);

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

