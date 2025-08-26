@extends('layouts.app')

@section('title', 'Acessibilidade')

@section('content')

<div class="container-abas" id="acessibilidade">
    {{ Breadcrumbs::render('acessibilidade')}}
    <div class="row mb-5">
        <div class="col-12">
            <h1 class=" h1 section-title mb-3 text-primary text-center fw-bold">O Que É Acessibilidade Web, Afinal?</h1>
            <p class="texto-justificado">A acessibilidade web vai além de uma simples adaptação; é um princípio de design. Conforme definido pela
                <a href="https://www.w3c.br/traducoes/wcag/wcag21-pt-BR/" target="_blank" class="fw-bold text-primary">Iniciativa para a Acessibilidade da Web (WAI)</a>,
                ela significa que pessoas com deficiência podem <strong>perceber, operar, entender e interagir</strong> com a web. Isso inclui um vasto grupo de usuários, como pessoas com deficiências:
            </p>
            <ul class="list-unstyled mt-2">
                <li><i class="fas fa-eye text-primary icon-acessibilidade"></i><strong>Visuais:</strong> Cegueira, baixa visão e daltonismo.</li>
                <li><i class="fas fa-headset text-primary icon-acessibilidade mt-2"></i><strong>Auditivas:</strong> Surdez e deficiências auditivas.</li>
                <li><i class="fas fa-wheelchair text-primary icon-acessibilidade mt-2"></i><strong>Físicas e motoras:</strong> Limitações de movimento que impedem o uso do mouse.</li>
                <li><i class="fas fa-brain text-primary icon-acessibilidade mt-2"></i><strong>Cognitivas e neurológicas:</strong> Dificuldades de leitura, atenção e memória.</li>
            </ul>
            <p class="mt-2 texto-justificado">Nosso objetivo é proporcionar uma experiência inclusiva, onde a tecnologia se adapta a você, e não o contrário.</p>
        </div>
    </div>
    <hr class="my-4">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title mb-3 text-primary fw-bold">Recursos de Acessibilidade em Nosso Site</h2>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center text-primary"><i class="fas fa-keyboard text-primary icon-acessibilidade"></i>Navegação por Teclado</h5>
                    <p class="card-text lh-lg texto-justificado">
                        Muitos usuários com deficiências motoras ou visuais dependem do teclado para navegar. Nosso site foi projetado para ser <strong>totalmente navegável sem a necessidade de um mouse</strong>. Você pode usar a tecla <strong>Tab</strong> para percorrer todos os links e campos de formulário e a tecla <strong>Enter</strong> para ativá-los.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center text-primary"><i class="fas fa-circle-half-stroke text-primary icon-acessibilidade"></i>Alto Contraste</h5>
                    <p class="card-text texto-justificado">
                        O modo de alto contraste é um recurso essencial para pessoas com baixa visão, daltonismo e até mesmo para quem sofre de fadiga ocular. Ao ativá-lo, as cores do site são ajustadas para criar uma <strong>diferenciação máxima entre o texto e o fundo</strong>, tornando a leitura mais confortável e eficiente.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center text-primary"><i class="fas fa-hand-holding-heart text-primary icon-acessibilidade"></i>VLibras</h5>
                    <p class="card-text texto-justificado">
                        Para a comunidade surda, a comunicação em Libras (Língua Brasileira de Sinais) é fundamental. Nosso site utiliza o VLibras, um assistente virtual que <strong>traduz automaticamente o conteúdo</strong> do texto para Libras, oferecendo um canal de comunicação mais natural e acessível.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center text-primary"><i class="fas fa-magnifying-glass-plus text-primary icon-acessibilidade"></i>Zoom de Conteúdo</h5>
                    <p class="card-text texto-justificado">
                        Sabemos que o tamanho da fonte ideal varia para cada pessoa. Por isso, nosso site permite que você ajuste facilmente o nível de zoom. Você pode usar os atalhos padrão do seu navegador: <strong>Ctrl +</strong> (ou ⌘ + no Mac) para aumentar o zoom e <strong>Ctrl -</strong> (ou ⌘ - no Mac) para diminuir o zoom.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-3">Estamos aqui para ajudar</h2>
                <p class="lead mb-4">
                    Se você encontrar algum problema de acessibilidade, por favor, entre em contato conosco.
                </p>
                <p>
                    <a href="mailto:jamiledasilvaramos@gmail.com" class="fw-bold text-primary text-decoration-none">
                        <i class="fas fa-envelope me-2"></i>
                        jamiledasilvaramos@gmail.com
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection