document.addEventListener('DOMContentLoaded', function () {
    // Evento para botões "Alterar tipo"
    document.querySelectorAll('.btn-primary').forEach(button => {
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

            console.log('id usuario', userId);
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



    // Evento para toggle categorias
    const toggleCategorias = document.querySelector('.toggle-categorias');
    if (toggleCategorias) {
        toggleCategorias.addEventListener('click', function () {
            const categoriasUrl = '/categorias/noticia';

            fetch(categoriasUrl)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('conteudo-categorias').innerHTML = data;
                })
                .catch(error => {
                    console.error('Erro ao carregar categorias:', error);
                });
        });
    }

    document.body.addEventListener('click', function (event) {
        if (event.target && event.target.matches('.btn-action')) {
            const categoriaId = event.target.getAttribute('data-id');
            const tipo = event.target.getAttribute('data-tipo');

            // Define o ID da categoria no campo oculto do modal
            document.getElementById('categoriaId').value = categoriaId;

            // Ajusta a URL do formulário de exclusão
            const form = document.getElementById('deleteForm');
            const route = form.getAttribute('action');
            form.action = route.replace(':tipo', tipo);

            console.log('ID da Categoria:', categoriaId);
            console.log('Tipo:', tipo);
            console.log('Ação do formulário de exclusão:', form.action);

            // Abre o modal de confirmação
            $('#confirmDeleteModal').modal('show');
        }

        $('.close').click(function () {
            $('#confirmDeleteModal').modal('hide');
        });

        $('#deleteForm').submit(function (event) {
            event.preventDefault(); // Previne o envio tradicional do formulário

            const form = $(this);
            const actionUrl = form.attr('action');  // URL do formulário (com o tipo de categoria)

            // Enviar a requisição AJAX
            $.ajax({
                url: actionUrl,
                type: 'DELETE',
                data: form.serialize(),  // Serializa o formulário para enviar os dados
                success: function (response) {
                    // Após a exclusão bem-sucedida, atualiza a tabela de categorias
                    $('#conteudo-categorias').html(response);

                    // Fecha o modal
                    $('#confirmDeleteModal').modal('hide');

                    // Esconde o backdrop após a execução bem-sucedida
                    $('.modal-backdrop').css('display', 'none');
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao excluir categoria:', error);
                    alert('Ocorreu um erro ao tentar excluir a categoria.');
                }
            });
        });
    });

});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});


