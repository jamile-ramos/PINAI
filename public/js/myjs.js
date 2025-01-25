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
    /*const toggleStatusButtons = document.querySelectorAll('.toggle-status');
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

    // Codigo para barra de filtros responsiva
    const filtrosSelect = document.getElementById('filtrosSelect');
    let selectedOption, options;

    if (filtrosSelect) {
        selectedOption = filtrosSelect.querySelector('.selected-option');
        options = filtrosSelect.querySelector('.options');

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

                let model, tipo, idUser;
                const toggleMy = document.querySelector('.toggle-my');
                const toggleAll = document.querySelector('.toggle-all');

                if (toggleMy) {
                    tipo = toggleMy.dataset.value;
                    model = toggleMy.dataset.model;
                    idUser = toggleMy.dataset.user;
                } else if (toggleAll) {
                    model = toggleAll.dataset.model;
                }

                if (value === 'all') {
                    window.location.href = `/${model}?query`;
                } else if (value === 'mys') {
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
    }

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

    // Ocultar botao de remover ou nao
    const removeButton = document.getElementById('remove-imagem-edit');
    const imageField = document.querySelector('.campo-img-edit');
    if (removeButton !== null && imageField !== null) {
        if (removeButton.style.display === 'none') {
            imageField.style.display = 'block';
        } else {
            imageField.style.display = 'none';
        }

        document.body.addEventListener('click', function (event) {
            if (event.target && event.target.matches('#remove-imagem-edit')) {
                const previewContainer = document.getElementById('imagem-preview-container-edit');
                if (previewContainer) {
                    previewContainer.style.display = 'none';
                }
                if (imageField) {
                    imageField.style.display = 'block';
                }
                const fileInput = document.getElementById('imagem');
                if (fileInput) {
                    fileInput.value = '';
                }
            }
        });
    }*/

    // Js dos content-links da barra
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => tab.addEventListener('click', () => tabClicked(tab)));

    const tabClicked = (tab) => {
        tabs.forEach(tab => tab.classList.remove('active'));
        tab.classList.add('active')

        const contents = document.querySelectorAll('.content-link');

        contents.forEach(content => content.classList.remove('show'));

        const contentId = tab.getAttribute('content-id');
        const content = document.getElementById(contentId);

        content.classList.add('show')
    }

});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
