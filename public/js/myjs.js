// Quando qualquer botão de "Alterar tipo" for clicado
document.querySelectorAll('.btn-info').forEach(button => {
    button.addEventListener('click', function () {
        // Captura os dados do botão clicado
        const userId = this.getAttribute('data-id');
        const userName = this.getAttribute('data-name');
        const userEmail = this.getAttribute('data-email');
        const userType = this.getAttribute('data-type');

        console.log('ID do Usuário:', userId);
        console.log('Nome do Usuário:', userName);
        console.log('Email do Usuário:', userEmail);
        console.log('Tipo de Usuário:', userType);


        // Preenche os campos do modal com os dados capturados
        document.getElementById('userId').value = userId;
        document.getElementById('userName').value = userName;
        document.getElementById('userEmail').value = userEmail;
        document.getElementById('userType').value = userType;

        // Obtemos o valor de data-route diretamente do formulário
        const form = document.getElementById('editUserForm');
        const route = form.getAttribute('data-route');

        // Substitui :id pelo userId
        const updatedAction = route.replace(':id', userId);

        // Atualiza o action do formulário
        form.action = updatedAction;

        console.log('Action do formulário:', form.action);

        // Abre o modal
        $('#editUserModal').modal('show');
    });
});

document.querySelectorAll('.btn-status').forEach(button => {
    button.addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        const status = this.getAttribute('data-status');

        if(status == 0){
            document.getElementById('status').value = 1;
        }else{
            document.getElementById('status').value = 0;
        }

        console.log('id usuario', userId);

        // Obtemos o valor de data-route diretamente do formulário
        const form = document.getElementById('confirmForm');
        const route = form.getAttribute('data-route');

        // Substitui :id pelo userId
        const updatedAction = route.replace(':id', userId);

        // Atualiza o action do formulário
        form.action = updatedAction;

        console.log('Action do formulário:', form.action);

        // Abre o modal
        $('#confirmModal').modal('show');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const toggleStatusButtons = document.querySelectorAll('.toggle-status');

    toggleStatusButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Obtendo os dados do botão clicado
            const userId = this.getAttribute('data-id');
            let currentStatus = this.getAttribute('data-status');
            
            // Alterando o valor do status no formulário
            document.getElementById('status').value = (currentStatus == 0) ? 1 : 0;

            // Alterar o texto e a cor do botão no modal
            const buttonText = currentStatus == 0 ? 'Desabilitar' : 'Ativar';
            const buttonClass = currentStatus == 0 ? 'btn-danger' : 'btn-success';
            
            // Atualizar o texto e a cor do botão de confirmação
            const confirmButton = document.getElementById('confirmActionBtn');
            confirmButton.innerText = buttonText;
            confirmButton.classList.remove('btn-danger', 'btn-success');
            confirmButton.classList.add(buttonClass);

            // Atualizar a URL do formulário com o ID do usuário
            const form = document.getElementById('confirmForm');
            const route = form.getAttribute('data-route');
            const updatedAction = route.replace(':id', userId);
            form.action = updatedAction;

            console.log('ID do usuário:', userId);
            console.log('Ação do formulário:', form.action);

            // Abrir o modal de confirmação
            $('#confirmModal').modal('show');
        });
    });
});

