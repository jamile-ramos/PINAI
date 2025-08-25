<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\CategoriaNoticia;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Str;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

use App\Models\Topico;

// Página Inicial
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Página Inicial', route('dashboard'));
});

// Página Inicial > Painel de Usuários
Breadcrumbs::for('acessibilidade', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Acessibilidade', route('acessibilidade'));
});

// Página Inicial > Sobre
Breadcrumbs::for('sobre', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Sobre', route('sobre'));
});

// Página Inicial > Painel de Usuários
Breadcrumbs::for('painelUsuarios', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Painel de Usuários', route('painel.usuarios'));
});

// Página Inicial > Painel de Usuários > Adicionar Nai /Editar Nai
Breadcrumbs::for('formNai', function (BreadcrumbTrail $trail, $tipoForm) {
    $trail->parent('painelUsuarios');
    $trail->push($tipoForm, route('nais.create'));
});

// Página Inicial > Painel de Usuários > Nai
Breadcrumbs::for('showNai', function (BreadcrumbTrail $trail, $nai) {
    $trail->parent('painelUsuarios');
    $trail->push($nai->nome, route('nais.show', ['id' => $nai->id]));
});

// Página Inicial > Meu perfil
Breadcrumbs::for('myProfile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Meu perfil', route('profile.index'));
});

// Página Inicial > Meu perfil > Editar Perfil
Breadcrumbs::for('editarPerfil', function (BreadcrumbTrail $trail) {
    $trail->parent('myProfile');
    $trail->push('Editar Perfil', route('profile.index'));
});

// Página Inicial > Portal de notícias
Breadcrumbs::for('noticias', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Portal de Notícias', route('noticias.index'));
});

// Página Inicial > Portal de notícias > Adicionar Noticia ou Editar Notícia
Breadcrumbs::for('formNoticia', function (BreadcrumbTrail $trail, $tipoForm) {
    $trail->parent('noticias');
    $trail->push($tipoForm, route('noticias.create'));
});

// Página Inicial > Potal de notícias > Categoria
Breadcrumbs::for('noticiasCategorias', function (BreadcrumbTrail $trail, $categoria) {
    $trail->parent('noticias');
    $trail->push($categoria->nomeCategoria, route('noticias.noticiasCategorias', ['idCategoria' => $categoria->id]));
});

// Página Inicial > Portal de notícias > Ver notícia
Breadcrumbs::for('verNoticia', function (BreadcrumbTrail $trail, $noticia) {

    $urlAnterior = url()->previous();

    if (str_contains($urlAnterior, 'categorias')) {
        $categoria = CategoriaNoticia::findOrFail($noticia->idCategoria);
        $trail->parent('noticiasCategorias', $categoria);
    } else if (str_contains($urlAnterior, 'myProfile')) {
        $trail->parent('myProfile');
    } else {
        $trail->parent('noticias');
    }
    $trail->push($noticia->titulo, route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]));
});

// Página Inicial > Fórum de Discussão
Breadcrumbs::for('topicos', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Fórum de Discussão', route('topicos.index'));
});

// Página Inicial > Fórum de Discussão > Tópico
Breadcrumbs::for('postagens', function (BreadcrumbTrail $trail, $topico) {
    $trail->parent('topicos');
    $trail->push($topico->titulo, route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug]));
});

// Página Inicial > Fórum de Discussão > Topico > Adicionar Postagem ou Editar Postagem
Breadcrumbs::for('formPostagem', function (BreadcrumbTrail $trail, $idTopico, $tipoForm) {
    $topico = Topico::findOrFail($idTopico);
    $trail->parent('postagens', $topico);
    $trail->push($tipoForm, route('postagens.create', ['id' => $idTopico]));
});

// Página Inicial > Fórum de Discussão > Topico > Postagem > Add / Editar Resposta
Breadcrumbs::for('addResposta', function (BreadcrumbTrail $trail, $postagem, $tipoForm) {
    $topico = Topico::findOrFail($postagem->idTopico);
    $trail->parent('postagens', $topico);
    $trail->push($postagem->titulo, route('postagens.show', ['id' => $postagem->id, 'slug' => $postagem->slug]));
    $trail->push($tipoForm, route('respostas.create', ['idPostagem' => $postagem->id]));
});

// Página Inicial > Fórum de Discussão > Topico > Ver postagem
Breadcrumbs::for('verPostagem', function (BreadcrumbTrail $trail, $postagem) {
    $urlAnterior = url()->previous();
    $topico = Topico::findOrFail($postagem->idTopico);

    if (Str::contains($urlAnterior, 'myProfile')) {
        $trail->parent('myProfile');
    } elseif (Str::contains($urlAnterior, "/topicos/{$topico->id}-{$topico->slug}")) {
        $trail->parent('postagens', $topico);
    } else {
        $trail->parent('topicos');
    }

    $trail->push(
        $postagem->titulo,
        route('postagens.show', [
            'id'   => $postagem->id,
            'slug' => $postagem->slug
        ])
    );
});


// Página Inicial > Biblioteca Digital
Breadcrumbs::for('documentos', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Biblioteca Digital', route('documentos.index'));
});

// Página Inicial > Biblioteca Digital > Adicionar Documento / Editar Documento
Breadcrumbs::for('formDocumento', function (BreadcrumbTrail $trail, $tipoForm) {
    $trail->parent('documentos');
    $trail->push($tipoForm, route('documentos.create'));
});

// Página Inicial > Biblioteca Digital > Categoria
Breadcrumbs::for('categoriaDocumento', function (BreadcrumbTrail $trail, $categoria) {
    $trail->parent('documentos');
    $trail->push($categoria->nomeCategoria, route('documentos.documentosCategorias', ['idCategoria' => $categoria->nomeCategoria]));
});

// Página Inicial > Banco de soluções
Breadcrumbs::for('solucoes', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Banco de Soluções', route('solucoes.index'));
});

// Página Inicial > Banco de soluções > Adicionar Solução / Editar Solução
Breadcrumbs::for('formSolucao', function (BreadcrumbTrail $trail, $tipoForm) {
    $trail->parent('solucoes');
    $trail->push($tipoForm, route('solucoes.index'));
});

// Página Inicial > Banco de soluções > Ver solução
Breadcrumbs::for('verSolucao', function (BreadcrumbTrail $trail, $solucao) {
    $urlAnterior = url()->previous();

    if (Str::contains($urlAnterior, 'myProfile')) {
        $trail->parent('myProfile');
    } elseif (Str::contains($urlAnterior, 'solucoes/categorias')) {
        if ($solucao->categoria) {
            $trail->parent('categoriaSolucao', $solucao->categoria);
        } else {
            $trail->parent('solucoes');
        }
    } else {
        $trail->parent('solucoes');
    }

    $trail->push(
        $solucao->titulo,
        route('solucoes.show', ['id' => $solucao->id, 'slug' => $solucao->slug])
    );
});

// Página Inicial > Banco de soluções > Categoria
Breadcrumbs::for('categoriaSolucao', function (BreadcrumbTrail $trail, $categoria) {
    $trail->parent('solucoes');
    $trail->push($categoria->nomeCategoria, route('solucoes.index'));
});
