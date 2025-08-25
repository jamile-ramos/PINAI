<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;

trait EnforcesCorrectSlug
{
    protected function redirectIfWrongSlug(Model $model, string $slug, string $routeName, string $idKeyName = 'id', array $params = [])
    {
        // Comparar o slug vindo da url ($slug) e o real do bd ($model->slug) e se forem diferentes ele procura o slug certo para redimensionar o usuário corretamente.
        if ($model->slug !== $slug) {
            return redirect()->route($routeName, array_merge($params, [
                'id'   => $model->getKey(),
                'slug' => $model->slug,
            ]), 301);
        }
        return null;
    }
}
