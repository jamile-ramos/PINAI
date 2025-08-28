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
                    <h2 class="fs-2 card-title text-primary fw-bold mb-3">Nossa Missão e Solução</h>
                    <p class="card-text texto-justificado">
                        Nas Instituições Federais de Ensino, os Núcleos de Acessibilidade e Inclusão (NAIs) enfrentam o desafio de garantir oportunidades iguais de aprendizado para todos os estudantes. Historicamente, cada núcleo atuava isoladamente, limitando o alcance de suas ações. Para resolver isso, nasceu o <strong>PINAI</strong> — a Plataforma Interativa de Núcleos de Acessibilidade e Inclusão. Ela proporciona um espaço digital para que os NAIs compartilhem recursos, boas práticas e soluções inovadoras, promovendo colaboração, troca de experiências e fortalecimento de toda a rede de acessibilidade, contribuindo para um futuro educacional mais inclusivo.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5 g-4">

    <!-- Portal de Notícias -->
    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-start border-primary rounded-3 h-100">
            <div class="card-body">
                <h2 class="fs-5 card-title text-primary mb-2"><i class="fas fa-newspaper me-2"></i>Portal de Notícias</h5>
                <p class="text-muted mb-3" style="text-align: justify; line-height: 2;">
                    Mantenha-se por dentro de tudo que acontece no seu NAI. O <strong>Portal de Notícias</strong> oferece informações confiáveis e atualizadas, incluindo:
                </p>
                <ul class="text-muted mb-3" style="line-height: 2; padding-left: 1rem;">
                    <li>•<strong> Comunicados oficiais:</strong> Eventos, prazos e políticas internas.</li>
                    <li>•<strong> Notícias e novidades:</strong> Atualizações do NAI e da comunidade acadêmica.</li>
                    <li>• </i><strong>Projetos e conquistas:</strong> Resultados e iniciativas de professores e estudantes.</li>
                    <li>• </i><strong>Conteúdo educativo:</strong> Artigos e materiais que promovem boas práticas pedagógicas.</li>
                </ul>
                <p class="text-muted mb-0" style="text-align: justify; line-height: 2;">
                    Um espaço para todos se manterem informados e conectados.
                </p>
            </div>
        </div>
    </div>

    <!-- Fórum de Discussão -->
    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-start border-primary rounded-3 h-100">
            <div class="card-body">
                <h2 class="fs-5 card-title text-primary mb-2"><i class="fas fa-comments me-2"></i>Fórum de Discussão</h5>
                <p class="text-muted mb-3" style="text-align: justify; line-height: 2;">
                    Um espaço colaborativo para interagir com outros membros do NAI. No <strong>Fórum de Discussão</strong>, você pode:
                </p>
                <ul class="text-muted mb-3" style="line-height: 2; padding-left: 1rem;">
                    <li>•<strong> Tirar dúvidas:</strong> Questões sobre acessibilidade e inclusão.</li>
                    <li>•<strong> Compartilhar ideias:</strong> Sugestões de atividades adaptadas e recursos pedagógicos.</li>
                    <li>•<strong> Debater metodologias:</strong> Práticas inovadoras e eficazes.</li>
                    <li>•<strong> Trocar experiências:</strong> Relatos de desafios e sucessos em sala de aula.</li>
                </ul>
                <p class="text-muted mb-0" style="text-align: justify; line-height: 2;">
                    Estimula o diálogo, cooperação e fortalece a rede de conhecimento coletivo.
                </p>
            </div>
        </div>
    </div>

    <!-- Biblioteca Digital -->
    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-start border-primary rounded-3 h-100">
            <div class="card-body">
                <h2 class="fs-5 card-title text-primary mb-2"><i class="fas fa-book me-2"></i>Biblioteca Digital</h5>
                <p class="text-muted mb-3" style="text-align: justify; line-height: 2;">
                    A <strong>Biblioteca Digital</strong> disponibiliza materiais educativos variados para apoiar professores e estudantes. Você pode:
                </p>
                <ul class="text-muted mb-3" style="line-height: 2; padding-left: 1rem;">
                    <li>•<strong> Consultar materiais:</strong> Livros, artigos, cartilhas e guias didáticos.</li>
                    <li>•<strong> Compartilhar multimídia:</strong> Vídeos, apresentações e infográficos.</li>
                    <li>•<strong> Explorar recursos acessíveis:</strong> Materiais adaptados para diferentes necessidades.</li>
                    <li>•<strong> Pesquisar facilmente:</strong> Filtre por tema, público ou tipo de recurso.</li>
                </ul>
                <p class="text-muted mb-0" style="text-align: justify; line-height: 2;">
                    Facilita o acesso organizado e inclusivo a conteúdos importantes.
                </p>
            </div>
        </div>
    </div>

    <!-- Banco de Soluções -->
    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-start border-primary rounded-3 h-100">
            <div class="card-body">
                <h2 class="fs-5 card-title text-primary mb-2"><i class="fas fa-lightbulb me-2"></i>Banco de Soluções</h5>
                <p class="text-muted mb-3" style="text-align: justify; line-height: 2;">
                    O <strong>Banco de Soluções</strong> é o espaço para documentar, compartilhar e explorar práticas pedagógicas eficazes. Você pode:
                </p>
                <ul class="text-muted mb-3" style="line-height: 2; padding-left: 1rem;">
                    <li>•<strong> Compartilhar materiais:</strong> Atividades adaptadas e planejamentos pedagógicos.</li>
                    <li>•<strong> Publicar ferramentas:</strong> Softwares, aplicativos e recursos digitais educativos.</li>
                    <li>•<strong> Registrar tutoriais:</strong> Vídeos e apresentações sobre metodologias inclusivas.</li>
                    <li>•<strong> Divulgar projetos:</strong> Estratégias replicáveis por outros NAIs.</li>
                </ul>
                <p class="text-muted mb-0" style="text-align: justify; line-height: 2;">
                    Incentiva a colaboração, troca de experiências e o fortalecimento da rede de boas práticas.
                </p>
            </div>
        </div>
    </div>

</div>



</div>



@endsection