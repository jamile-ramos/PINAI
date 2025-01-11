<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabelaCategoriaIndex extends Component
{
    public $tipo;

    public function __construct($tipo)
    {
        $this->tipo = $tipo;
    }

    public function render(): View|Closure|string
    {
        return view('components.tabela-categoria-index');
    }
}
