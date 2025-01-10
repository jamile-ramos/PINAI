// Quando qualquer botão de "Alterar tipo" for clicado
document.querySelectorAll('.btn-info').forEach(button => {
    button.addEventListener('click', function() {
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

        // Abre o modal
        $('#editUserModal').modal('show');
    });
});
