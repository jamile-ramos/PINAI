<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MinhasPublicacoes extends Component
{
    /**
     * Exemplo de dado que pode ser passado ao componente.
     *
     * @var string
     */
    public $titulo;

    /**
     * Cria uma nova instância do componente.
     *
     * @param string $titulo
     */
    public function __construct($titulo = 'Título Padrão')
    {
        $this->titulo = $titulo;
    }

    public function render(): View|string
    {
        return view('components.minhas-publicacoes');
    }
}
