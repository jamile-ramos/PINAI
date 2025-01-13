document.addEventListener('DOMContentLoaded', function () {

    // Evento para botões "Alterar tipo"
    document.querySelectorAll('.btn-alterar').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const userName = this.getAttribute('data-name');
            const userEmail = this.getAttribute('data-email');
            const userType = this.getAttribute('data-type');

            console.log('ID do Usuário:', userId);
            console.log('Nome do Usuário:', userName);
            console.log('Email do Usuário:', userEmail);
            console.log('Tipo de Usuário:', userType);

            document.getElementById('userId').value = userId;
            document.getElementById('userName').value = userName;
            document.getElementById('userEmail').value = userEmail;
            document.getElementById('userType').value = userType;

            const form = document.getElementById('editUserForm');
            const route = form.getAttribute('data-route');
            form.action = route.replace(':id', userId);

            console.log('Action do formulário:', form.action);

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

            console.log('ID do usuário', userId);
            console.log('Action do formulário:', form.action);

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

            console.log('ID do usuário:', userId);
            console.log('Ação do formulário:', form.action);

            $('#confirmModal').modal('show');
        });
    });

    // Função para conteudo dinamico de categoria
    function AbriCategorias() {
        const categoriasUrl = '/categorias/noticia';

        fetch(categoriasUrl)
            .then(response => response.text())
            .then(data => {
                document.getElementById('conteudo-categorias').innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar categorias:', error);
            });
    }

    // Evento para toggle categorias
    const toggleCategoriasButton = document.querySelector('.toggle-categorias');
    if (toggleCategoriasButton) {
        toggleCategoriasButton.addEventListener('click', AbriCategorias);
    }

    // Evento para abrir o modal de exclusão
    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.matches('.btn-action')) {
            const categoriaId = event.target.getAttribute('data-id');
            const tipo = event.target.getAttribute('data-tipo');

            document.getElementById('categoriaId').value = categoriaId;

            const form = document.getElementById('deleteForm');
            const route = form.getAttribute('action');
            form.action = route.replace(':tipo', tipo);

            console.log('ID da Categoria:', categoriaId);
            console.log('Tipo:', tipo);
            console.log('Ação do formulário de exclusão:', form.action);

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

    // Evento para abrir o modal de criação de categoria e criar categoria
    $(document).ready(function () {
        $('#abrirModalCategoria').on('click', function () {
            $('#modalCategoria').modal('show');
        });

        $('#abrirModalCategoriaMenor').on('click', function(){
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
                    console.log('Resposta recebida:', response);
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
    });

    // Evento para abrir o modal de criação de notícia 
    const abrirModalBtn = document.getElementById('abrirModalNoticia');
    abrirModalBtn.addEventListener('click', function () {
        $('#criarNoticiaModal').modal('show');
        console.log('clicou')
    })

    const abrirModalBtnMenor = document.getElementById('abrirModalNoticiaMenor');
    abrirModalBtnMenor.addEventListener('click', function () {
        $('#criarNoticiaModal').modal('show');
        console.log('clicou')
    })    

    // Codigo para barra de filtros responsiva
    const filtrosSelect = document.getElementById('filtrosSelect');
    const selectedOption = filtrosSelect.querySelector('.selected-option');
    const options = filtrosSelect.querySelector('.options');

    filtrosSelect.addEventListener('click', () => {
        const isOptionsVisible = options.style.display === 'block';
        options.style.display = isOptionsVisible ? 'none' : 'block';
    });

    document.addEventListener('click', (event) => {
        if (!filtrosSelect.contains(event.target)) {
            options.style.display = 'none';
        }
    });

    options.addEventListener('click', (event) => {
        const button = event.target.closest('.option');
        if (button) {
            const value = button.dataset.value;
            selectedOption.textContent = button.textContent;

            if (value === 'todas') {
                window.location.href = '/noticias?query';
            } else if (value === 'minhas-noticias') {

            } else if (value === 'categorias') {
                AbriCategorias();
            }
            setTimeout(() => {
                options.style.display = 'none';
            }, 50);
        }
    });


});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
