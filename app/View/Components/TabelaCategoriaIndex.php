<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabelaCategoriaIndex extends Component
{
    public $categorias;
    public $tipo;

    public function __construct($categorias, $tipo)
    {
        $this->categorias = $categorias;
        $this->tipo = $tipo;
    }

    public function render()
    {
        return view('components.tabela-categoria-index');
    }
}
