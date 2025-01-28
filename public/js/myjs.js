document.addEventListener('DOMContentLoaded', function () {
    // Mantém um item de sidebar ativo mesmo após recarregar ou navegar para outra página
    $(document).ready(function () {
        var activeItem = localStorage.getItem("active_nav_item");

        if (window.location.href.indexOf("dashboard") > -1) {
            activeItem = "/dashboard";
        }

        if (activeItem) {
            $(".nav-item").removeClass("submenu active");
            $(".nav-item i").removeClass("icon-active");

            var activeLink = $(".nav-item a[href='" + activeItem + "']");
            activeLink.parent().addClass("submenu active");
            activeLink.find("i").addClass("icon-active");
        }

        $(".nav-item a").on("click", function () {
            $(".nav-item").removeClass("submenu active");
            $(".nav-item i").removeClass("icon-active");

            $(this).parent().addClass("submenu active");
            $(this).find("i").addClass("icon-active");

            localStorage.setItem("active_nav_item", $(this).attr('href'));
        });
    });

    // Adiciona a classe 'active' ao link clicado
    $(document).ready(function () {
        $(".filtros a").on("click", function (event) {
            $(".filtros a").removeClass("active");

            $(this).addClass("active");
        });
    });

    // Clicar no icone e aparece a barra de pesquisa
    $(document).ready(function () {
        $(".search-icon").on("click", function () {
            $(".search-input").blur();
            $(".search-input").css({
                "border": "1px solid transparent",
                "background-color": "transparent"
            });

            $(".navbar").addClass("search-mode");

            const filtrosSelect = document.getElementById('filtrosSelect');
            $(".search-icon").hide();
            $('.tab-btn').hide();
            $('.add-btn').hide();
            $(".close-search").show();

            $(".search-form").show();
            $(".search-input").show().focus();
        });

        $(".close-search").on("click", function () {
            $(".navbar").removeClass("search-mode");

            $(".close-search").hide();
            $('.tab-btn').show();
            $('.add-btn').show();
            $(".search-icon").show();


            $(".search-form").hide();
            $(".search-input").hide();

            $(".search-input").blur();
            $(".search-input").css({
                "border": "1px solid transparent",
                "background-color": "transparent"
            });
        });
    });
    
    /* Dropdonw do menu */
    document.querySelector(".select-option").addEventListener("click", function () {
        const dropdown = document.querySelector(".select-btn");
        dropdown.classList.toggle("active"); 
    });
    
    // Fechar dropdown ao clicar fora
    document.addEventListener("click", function (e) {
        const dropdown = document.querySelector(".select-btn");
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("active");
        }
    });

    //Alterar tipo no painel de usuários
    $(document).ready(function () {
        $('.btn-info').on('click', function () {
            var userId = $(this).data('id');
            var userName = $(this).data('name');
            var userEmail = $(this).data('email');
            var userType = $(this).data('type');

            $('#userId').val(userId);
            $('#userName').val(userName);
            $('#userEmail').val(userEmail);
            $('#userType').val(userType);

            $('#editUserModal').modal('show');
        });

        $('#saveUserChanges').on('click', function () {
            var userId = $('#userId').val();
            var userType = $('#userType').val();

            $.ajax({
                url: '/usuarios/' + userId + '/update',
                method: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    userId: userId,
                    userType: userType
                },
                success: function (response) {
                    $('#editUserModal').modal('hide');

                    location.reload();
                },
                error: function (response) {
                    alert("Erro ao atualizar tipo de usuário.");
                }
            });
        });
    });

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

    // Codigo para barra de filtros responsiva
    /*const filtrosSelect = document.getElementById('filtrosSelect');
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

    // Js dos content das abas links
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => tab.addEventListener('click', () => tabClicked(tab)));

    const tabClicked = (tab) => {
        tabs.forEach(tab => tab.classList.remove('active'));
        tab.classList.add('active')

        const contents = document.querySelectorAll('.content-link');

        contents.forEach(content => content.classList.remove('show'));

        const contentId = tab.getAttribute('content-id');
        const content = document.getElementById(contentId);

        content.classList.add('show');

        const selectOption = document.querySelector('.select-option');
        if(selectOption){
            const textSelect = tab.innerText;
            selectOption.textContent = textSelect;
            const dropdown = document.querySelector(".select-btn");
            dropdown.classList.remove("active");
        }
    }

    // Js dos content das abas select
    const tabsSelect = document.querySelectorAll('.option-btn');
    tabsSelect.forEach(tab => tab.addEventListener('click', () => tabClicked(tab)));

});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
