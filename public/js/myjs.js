document.addEventListener('DOMContentLoaded', function () {
    // Evento para botões "Alterar tipo"
    document.querySelectorAll('.btn-alterar').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('data-name');
            const userEmail = this.getAttribute('data-email');
            const userType = this.getAttribute('data-type');

            document.getElementById('userId').value = userId;
            document.getElementById('userName').value = userName;
            document.getElementById('userEmail').value = userEmail;
            document.getElementById('userType').value = userType;

            const form = document.getElementById('editUserForm');
            const route = form.getAttribute('data-route');
            form.action = route.replace(':id', userId);

            $('#editUserModal').modal('show');
        });
    });

    // Evento para botões de status
    document.querySelectorAll('.btn-status').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const status = this.getAttribute('data-status');
            document.getElementById('status').value = (status == 0) ? 1 : 0;

            const form = document.getElementById('confirmForm');
            const route = form.getAttribute('data-route');
            form.action = route.replace(':id', userId);

            $('#confirmModal').modal('show');
        });
    });

    // Evento para botões "toggle-status"
    const toggleStatusButtons = document.querySelectorAll('.toggle-status');
    toggleStatusButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');

            document.getElementById('status').value = (currentStatus == 0) ? 1 : 0;

            const buttonText = currentStatus == 0 ? 'Desabilitar' : 'Ativar';
            const buttonClass = currentStatus == 0 ? 'btn-danger' : 'btn-success';

            const confirmButton = document.getElementById('confirmActionBtn');
            confirmButton.innerText = buttonText;
            confirmButton.classList.remove('btn-danger', 'btn-success');
            confirmButton.classList.add(buttonClass);

            const form = document.getElementById('confirmForm');
            const route = form.getAttribute('data-route');
            form.action = route.replace(':id', userId);

            $('#confirmModal').modal('show');
        });
    });

    // Funcao para aparecer o conteudo de categorias
    function AbriCategorias(tipo) {

        const categoriasUrl = `/categorias/${tipo}`;
        fetch(categoriasUrl)
            .then(response => response.text())
            .then(data => {
                document.getElementById('conteudo-categorias').innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar categorias:', error);
            });
    }

    // Funcao para aparecer o conteudo de My publicacoes(pode ser noticias, topicos, documetos, solucoes)
    function AbrirMys(model, tipo, id) {
        const modelUrl = `${model}/${tipo}/${id}`

        fetch(modelUrl)
            .then(response => response.text())
            .then(data => {
                document.getElementById('conteudo-categorias').innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar', error);
            });
    }

    // Evento para toggle categorias
    const toggleCategoriasButton = document.querySelector('.toggle-categorias');
    if (toggleCategoriasButton) {
        toggleCategoriasButton.addEventListener('click', function () {
            const tipo = this.dataset.tipo;
            AbriCategorias(tipo);
        });
    }

    // Evento para toggle my
    const toggleMy = document.querySelector('.toggle-my');
    if (toggleMy) {
        toggleMy.addEventListener('click', function () {
            const model = this.dataset.model;
            const tipo = this.dataset.value;
            const idUser = this.dataset.user;
            AbrirMys(model, tipo, idUser);
        })
    }

    // Evento para abrir o modal de exclusão categoria
    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.matches('.btn-action')) {
            const categoriaId = event.target.getAttribute('data-id');
            const tipo = event.target.getAttribute('data-tipo');

            document.getElementById('categoriaId').value = categoriaId;

            const form = document.getElementById('deleteForm');
            const route = form.getAttribute('action');
            form.action = route.replace(':tipo', tipo);

            $('#confirmDeleteModal').modal('show');
        }

        $('.close').click(function () {
            $('#confirmDeleteModal').modal('hide');
        });

        $('#deleteForm').submit(function (event) {
            event.preventDefault();

            const form = $(this);
            const actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: 'DELETE',
                data: form.serialize(),
                success: function (response) {
                    $('#conteudo-categorias').html(response);
                    $('#confirmDeleteModal').modal('hide');
                    $('.modal-backdrop').remove();
                    $('html, body').css('overflow', 'auto');
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao excluir categoria:', error);
                    alert('Ocorreu um erro ao tentar excluir a categoria.');
                }
            });
        });
    });

    // Evento para abrir o modal de exclusão mys
    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.matches('.btn-excluirNoticia')) {
            const publicacaoId = event.target.getAttribute('data-id');
            const tipo = event.target.getAttribute('data-tipo');

            document.getElementById('publicacaoId').value = publicacaoId;

            const form = document.getElementById('deleteFormPubli');
            const route = form.getAttribute('action');
            form.action = route.replace(':tipo', tipo);

            $('#confirmDeleteModalPubli').modal('show');
        }

        $('.close').click(function () {
            $('#confirmDeleteModalPubli').modal('hide');
        });

        $('#deleteFormPubli').submit(function (event) {
            event.preventDefault();

            const form = $(this);
            const actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: 'DELETE',
                data: form.serialize(),
                success: function (response) {
                    $('#conteudo-categorias').html(response);
                    $('#confirmDeleteModalPubli').modal('hide');
                    $('.modal-backdrop').remove();
                    $('html, body').css('overflow', 'auto');
                    $('.filtros a').removeClass('active');
                    $('.filtros .toggle-my').addClass('active');
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao excluir:', error);
                    alert('Ocorreu um erro ao tentar excluir a categoria.');
                }
            });
        });
    });


    // Evento para abrir o modal de criação de categoria e criar categoria
    /*$(document).ready(function () {
        $('#abrirModalCategoria').on('click', function () {
            $('#modalCategoria').modal('show');
        });
        $('#abrirModalCategoriaMenor').on('click', function () {
            $('#modalCategoria').modal('show');
        })

        $('#createFormCategoria').submit(function (event) {
            event.preventDefault();

            const form = $(this);
            const actionUrl = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#conteudo-categorias').html(response);

                    $('#modalCategoria').modal('hide');

                    $('.filtros a').removeClass('active');
                    $('.filtros .toggle-categorias').addClass('active');

                    $('#createFormCategoria')[0].reset();
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao criar categoria:', error);
                    alert('Ocorreu um erro ao tentar criar a categoria.');
                }
            });
        });
    });*/

    // Evento para abrir o modal de criação de noticia e criar noticia
    /*$(document).ready(function () {
        const abrirModalBtn = document.getElementById('abrirModalNoticia');
        abrirModalBtn.addEventListener('click', function () {
            $('#criarNoticiaModal').modal('show');
        })

        const abrirModalBtnMenor = document.getElementById('abrirModalNoticiaMenor');
        abrirModalBtnMenor.addEventListener('click', function () {
            $('#criarNoticiaModal').modal('show');
        });

        $('#formulario-modal-create').submit(function (event) {
            event.preventDefault();

            const form = $(this);
            console.log('Formulario: ', form);
            const actionUrl = form.attr('action');
            console.log("URL do formulário obtida:", actionUrl);

            const formData = form.serialize();
            console.log("Dados do formulário serializados:", formData);

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#conteudo-categorias').html(response);
                    console.log("Conteúdo atualizado no elemento '#conteudo-categorias'.");

                    $('#criarNoticiaModal').modal('hide');
                    console.log("Modal 'criarNoticiaModal' ocultado.");

                    $('.filtros a').removeClass('active');
                    $('.filtros .toggle-my').addClass('active');
                    console.log("Filtros atualizados: remove 'active' de todos os links e adiciona 'active' em '.toggle-my'.");

                    $('#formulario-modal-create')[0].reset();
                    console.log("Formulário resetado.");
                },
                error: function (xhr, status, error) {
                    console.error("Resposta do servidor:", xhr.responseText);
                    alert('Ocorreu um erro ao tentar criar a notícia.');
                }
            });
        });

        console.log("Script carregado com sucesso.");
    });*/

    // Evento para abrir o modal de criação 
    $(document).ready(function () {
        $('[data-toggle="modal"]').on('click', function () {

            const modalId = $(this).data('target');
            $(modalId).modal('show');

        });
        // Fechar modal e remover backdrop quando clicar no botao fechar
        document.querySelectorAll('[data-dismiss="modal"]').forEach(button => {
            button.addEventListener('click', function () {
                const modal = $(this).closest('.modal');
                modal.modal('hide');
                $('.modal-backdrop').remove();
            });
        });
        // Fechar modal e remover backdrop quando clicar no icone close
        document.querySelectorAll('[data-dismiss="modal"], .close').forEach(button => {
            button.addEventListener('click', function () {
                const modal = $(this).closest('.modal');
                modal.modal('hide');
                $('.modal-backdrop').remove();
            });
        });

        $('form[data-modal="true"]').on('submit', function (event) {
            event.preventDefault();

            const form = $(this);
            const actionUrl = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#conteudo-categorias').html(response);

                    const modalId = form.closest('.modal').attr('id');
                    $(`#${modalId}`).modal('hide');
                    form[0].reset();

                    $('.filtros a').removeClass('active');
                    $('.filtros .toggle-my').addClass('active');

                    $('.modal-backdrop').remove();

                },
                error: function (xhr, status, error) {
                    console.error("Erro:", error);
                    alert('Ocorreu um erro. Tente novamente.');
                }
            });
        });
    });

    // Codigo para barra de filtros responsiva
    const selectedOption = filtrosSelect.querySelector('.selected-option');
    const options = filtrosSelect.querySelector('.options');

    filtrosSelect.addEventListener('click', () => {
        options.classList.toggle('hidden');
        options.classList.toggle('visible');
    });

    document.addEventListener('click', (event) => {
        if (!filtrosSelect.contains(event.target)) {
            options.classList.add('hidden');
            options.classList.remove('visible');
        }
    });

    options.addEventListener('click', (event) => {
        const button = event.target.closest('.option');
        if (button) {
            const value = button.dataset.value;
            selectedOption.textContent = button.textContent;
            const tipo = toggleMy.dataset.value;

            if (value === 'all') {
                window.location.href = '/{$tipo}?query';
            } else if (value === 'mys') {
                const model = toggleMy.dataset.model;
                const idUser = toggleMy.dataset.user;
                AbrirMys(model, tipo, idUser);
            } else if (value === 'categorias') {
                const tipo = button.dataset.tipo;
                AbriCategorias(tipo);
            }
            setTimeout(() => {
                options.classList.add('hidden');
            }, 50);
        }
    });

    //Código para quando a tela for aumentada ou diminuida a opcao selecionada persista
    const links = document.querySelectorAll('.filtros a');
    const opcoes = document.querySelectorAll('.options .option');

    function activeToSelect() {
        const activeLink = document.querySelector('.filtros a.active');
        if (activeLink) {
            const activeValue = activeLink.innerText.trim();
            selectedOption.textContent = activeValue;
        }
    }

    function selectToActive() {
        const selectedValue = selectedOption.innerText.trim().toLowerCase();;

        if (!selectedValue) {
            console.log('Nenhum valor selecionado encontrado!');
        }

        links.forEach(link => {

            if (link.innerText.trim().toLowerCase() === selectedValue) {
                links.forEach(l => {
                    l.classList.remove('active');
                });

                link.classList.add('active');
            }
        });
    }

    links.forEach(link => {
        link.addEventListener('click', function () {
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            activeToSelect();
        });
    });

    opcoes.forEach(option => {
        option.addEventListener('click', function () {
            const selectedValue = this.dataset.value || this.innerText.trim();
            selectedOption.textContent = selectedValue;
            selectToActive();
        });
    });

    window.addEventListener('resize', () => {
        activeToSelect();
        selectToActive();
    });
    activeToSelect();

    // Listar categorias no formulário de criação de notícia/tópico/solução/documentos
    $('#criarNoticiaModal').on('show.bs.modal', function () {

        const select = document.getElementById('categoria');
        const tipo = select.getAttribute('data-tipo');

        fetch(`/categorias/create/${tipo}`)
            .then(response => {
                if (!response.ok) {
                    console.error(`[DEPRECATION WARNING] Falha ao buscar categorias para o tipo: ${tipo}.`);
                    throw new Error('Erro na resposta da API.');
                }
                return response.json();
            })
            .then(data => {
                select.innerHTML = '<option value="" disabled selected>Selecione uma categoria</option>';

                data.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nomeCategoria;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error(`[DEPRECATION WARNING] Erro ao carregar categorias para o tipo: ${tipo}. Detalhes:`, error);
            });
    });


});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
