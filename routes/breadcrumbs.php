<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

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

// Página Inicial > Potal de notícias
Breadcrumbs::for('noticias', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Portal de Notícias', route('noticias.index'));
});


// Página Inicial > Fórum de Discussão
Breadcrumbs::for('topicos', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Fórum de Discussão', route('topicos.index'));
});

// Página Inicial > Biblioteca Digital
Breadcrumbs::for('documentos', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Biblioteca Digital', route('documentos.index'));
});

// Página Inicial > Banco de soluções
Breadcrumbs::for('solucoes', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Banco de Soluções', route('solucoes.index'));
});