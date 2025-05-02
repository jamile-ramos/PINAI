<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

use App\Models\Topico;

// Página Inicial
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Página Inicial', route('dashboard'));
});

// Página Inicial > Painel de Usuários
Breadcrumbs::for('painelUsuarios', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Painel de Usuários', route('painel.usuarios'));
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

// Página Inicial > Portal de notícias > Ver notícia
Breadcrumbs::for('verNoticia', function (BreadcrumbTrail $trail, $noticia) {
    $trail->parent('noticias');
    $trail->push($noticia->titulo, route('noticias.show', ['id' => $noticia->id]));
});

// Página Inicial > Potal de notícias > Categoria
Breadcrumbs::for('noticiasCategorias', function (BreadcrumbTrail $trail, $categoria) {
    $trail->parent('noticias');
    $trail->push($categoria->nomeCategoria, route('noticias.noticiasCategorias', ['idCategoria' => $categoria->id]));
});

// Página Inicial > Fórum de Discussão
Breadcrumbs::for('topicos', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Fórum de Discussão', route('topicos.index'));
});

// Página Inicial > Fórum de Discussão > Tópico
Breadcrumbs::for('postagens', function (BreadcrumbTrail $trail, $topico) {
    $trail->parent('topicos');
    $trail->push($topico->titulo, route('postagens.index', ['idTopico' => $topico->id]));
});

// Página Inicial > Fórum de Discussão > Topico > Adicionar Postagem ou Editar Postagem
Breadcrumbs::for('formPostagem', function (BreadcrumbTrail $trail, $idTopico, $tipoForm) {
    $topico = Topico::findOrFail($idTopico);
    $trail->parent('postagens', $topico);
    $trail->push($tipoForm, route('postagens.create', ['idTopico' => $idTopico]));
});

// Página Inicial > Fórum de Discussão > Tópico > Ver postagem
Breadcrumbs::for('verPostagem', function (BreadcrumbTrail $trail, $postagem) {
    $topico = Topico::findOrFail($postagem->idTopico);
    $trail->parent('postagens', $topico);
    $trail->push($postagem->titulo, route('postagens.show', ['id' => $postagem->id]));
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