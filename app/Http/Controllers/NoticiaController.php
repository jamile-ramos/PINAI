<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestStatus\Notice;

class NoticiaController extends Controller
{
    public function index(){

        $query = request('query');
        if($query){
            $noticias = Noticia::where([
                ['title', 'like', '%'.$query.'%']
            ]);
        }else{
            $noticias = Noticia::all();
        }

        return view('noticias.index', compact('noticias'));
    }
}
