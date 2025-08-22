@extends('layouts.app')

@section('title', 'Sobre')

@section('content')
<div class="container-abas">
    {{ Breadcrumbs::render('sobre') }}
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">Sobre Nós: A Plataforma PINAI</h1>
            <p class="lead text-muted mb-5">
                Nossa missão é construir pontes e quebrar barreiras para tornar a educação mais acessível e inclusiva para todos.
            </p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h4 class="card-title text-primary fw-bold mb-3">O Desafio que nos Move</h4>
                    <p class="card-text texto-justificado">
                        Nas Instituições Federais de Ensino, o compromisso com a acessibilidade e a inclusão de estudantes com deficiência é uma missão constante. Na linha de frente dessa jornada estão os Núcleos de Acessibilidade e Inclusão (NAIs), essenciais para garantir que esses estudantes tenham as mesmas oportunidades de aprendizado e desenvolvimento.
                    </p>
                    <p class="card-text texto-justificado">
                        No entanto, por muito tempo, o trabalho dos NAIs foi feito de forma isolada. Cada núcleo, em sua própria instituição, dedicava-se a encontrar soluções, reinventando o que já havia sido descoberto em outro lugar. A falta de um sistema de comunicação e colaboração específico limitava o alcance de suas ações e o número de estudantes que poderiam ser beneficiados.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h4 class="card-title text-primary fw-bold mb-3">Nossa Solução: A Plataforma PINAI</h4>
                    <p class="card-text texto-justificado">
                        É para resolver este desafio que nasceu o <strong>PINAI</strong> — a Plataforma Interativa de Núcleos de Acessibilidade e Inclusão.
                    </p>
                    <p class="card-text texto-justificado">
                        Nossa plataforma é um ambiente digital concebido para <strong>quebrar barreiras geográficas e operacionais</strong>. O PINAI é um ponto de encontro para os NAIs, facilitando a <strong>interação, colaboração e troca de recursos</strong> de forma eficiente. Nosso objetivo é transformar o trabalho desses núcleos, permitindo que compartilhem melhores práticas, soluções inovadoras e materiais de apoio.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h4 class="card-title text-primary fw-bold mb-3">Nosso Impacto</h4>
                    <p class="card-text">
                        Acreditamos que, ao unir o conhecimento e a experiência de cada NAI, podemos fortalecer toda a rede de acessibilidade nas Instituições Federais de Ensino. Com o PINAI, esperamos que os núcleos possam trabalhar de forma mais colaborativa e eficiente, construindo um futuro educacional mais inclusivo para todos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection