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

    // Abre o dropdown
    document.querySelector(".select-option").addEventListener("click", function (e) {
        e.stopPropagation(); // Evita que o clique feche o dropdown imediatamente

        const dropdown = document.querySelector(".dropdown-select");
        dropdown.classList.toggle("active");
    });

    // Fechar dropdown ao clicar fora
    document.addEventListener("click", function (e) {
        const dropdown = document.querySelector(".dropdown-select");

        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("active");
        }
    });

    // Fecha o dropdown quando qualquer opção for clicada
    const optionBtns = document.querySelectorAll(".dropdown-select .option-btn");
    optionBtns.forEach(function (btn) {
        btn.addEventListener("click", function () {
            const dropdown = document.querySelector(".dropdown-select");
            dropdown.classList.remove("active");
        });
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

    // Funcao para iniciar aba
    function iniciarAbar(barraId) {
        const container = document.getElementById(barraId);
        const tabs = container.querySelectorAll('.tab-btn');
        const tabsSelect = container.querySelectorAll('.option-btn');

        tabs.forEach(tab => tab.addEventListener('click', function () {
            tabClicked(tab, barraId); // Passando diretamente o tab
        }));

        tabsSelect.forEach(tab => tab.addEventListener('click', function () {
            tabClicked(tab, barraId); // Passando diretamente o tab
        }));
    }

    const tabClicked = (tab, barraId) => {
        const containerElement = document.getElementById(barraId);
        const tabs = containerElement.querySelectorAll('.tab-btn');
        const contents = containerElement.querySelectorAll('.content-link');

        tabs.forEach(tabElement => tabElement.classList.remove('active'));
        tab.classList.add('active');

        contents.forEach(content => content.classList.remove('show'));

        const contentId = tab.getAttribute('content-id');
        const content = document.getElementById(contentId);
        content.classList.add('show');

        const selectOption = containerElement.querySelector('.select-option');
        if (selectOption) {
            selectOption.textContent = tab.innerText;
        }

        localStorage.setItem(`active_tab_${barraId}`, contentId);
    };

    //Pegando o id do container aba clicado
    const updateTabs = () => {
        document.querySelectorAll('.container-abas').forEach(container => {
            const barraId = container.id;
            iniciarAbar(barraId);
        })
    }

    updateTabs();

    // Função que restaura o estado da aba ativa ao redimensionar a página
    const restoreActiveTabOnResize = () => {
        document.querySelectorAll('.container-abas').forEach(container => {
            const barraId = container.id;
            const activeTabId = localStorage.getItem(`active_tab_${barraId}`);

            if (activeTabId) {
                const tabs = container.querySelectorAll('.tab-btn');
                tabs.forEach(tab => {
                    const contentId = tab.getAttribute('content-id');
                    if (contentId === activeTabId) {
                        tab.classList.add('active');

                        const content = document.getElementById(contentId);
                        if (content) {
                            content.classList.add('show');
                        }
                    } else {
                        tab.classList.remove('active');
                        const content = document.getElementById(contentId);
                        if (content) {
                            content.classList.remove('show');
                        }
                    }
                });
            }
        })
    }

    window.addEventListener("resize", restoreActiveTabOnResize);

    // Abrir modais de criação: Categoria
    document.querySelectorAll('.container-abas').forEach(container => {
        const addBtns = container.querySelectorAll('.add-btn');
        addBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                const buttonText = btn.textContent.trim();
                console.log('Botão clicado:', buttonText);

                if (buttonText === 'Criar Categoria') {
                    const modal = document.getElementById('modalAddCategoria');
                    console.log('Modal encontrado:', modal);
                    $(modal).modal('show');
                    $(modal).removeClass('fade').addClass('show');
                    $(modal).css('display', 'block');
                }
            });
        });
    });

    // Abrir o modal e Atualizar o atributo data-route e o campo oculto do formulário 
    document.querySelectorAll('.container-abas').forEach(container => {
        const deleteButtons = container.querySelectorAll('.btn-remove');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const tipo = btn.getAttribute('data-tipo');
                const idCategoria = btn.getAttribute('data-id');  // Corrigido: pegando o data-id do botão
                const modal = document.querySelector('#confirmExcluirModal');
                const form = document.getElementById('confirmEcluirForm');

                // Corrigido: obtenha a rota e substitua ':tipo' corretamente
                const route = form.getAttribute('data-route');
                const novaRoute = route.replace(':tipo', tipo);

                // Define os valores dinâmicos
                form.setAttribute('action', novaRoute);  // Atualizando a action com a nova rota
                form.setAttribute('id', 'confirmEcluirForm-' + idCategoria);  // Adicionando um ID único ao formulário

                // Atualiza o campo oculto com o valor de categoria
                const categoriaInput = document.getElementById('categoria');
                categoriaInput.value = idCategoria;

                $(modal).modal('show'); // Exibe o modal
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
