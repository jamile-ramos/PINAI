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
    const selectOption = document.querySelector(".select-option");
    const selectBtn = document.querySelector(".select-btn");

    if (selectBtn) {
        selectOption.addEventListener("click", function (e) {
            e.stopPropagation();
            console.log(selectBtn)
            const dropdown = document.querySelector(".dropdown-select");
            dropdown.classList.toggle("active");
        });
    }

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
    function iniciarAba(barraId) {
        const container = document.getElementById(barraId);
        const tabs = container.querySelectorAll('.tab-btn');
        const tabsSelect = container.querySelectorAll('.option-btn');

        tabs.forEach(tab => tab.addEventListener('click', function () {
            tabClicked(tab, barraId);
        }));

        tabsSelect.forEach(tab => tab.addEventListener('click', function () {
            tabClicked(tab, barraId);
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
            iniciarAba(barraId);
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

    // Abrir modais de criação
    document.querySelectorAll('.container-abas').forEach(container => {
        const addBtns = container.querySelectorAll('.add-btn');
        const optionAdds = container.querySelectorAll('.option-add');

        addBtns.forEach(btn => btn.addEventListener('click', function () { abrirCategoria(btn) }));
        optionAdds.forEach(btn => btn.addEventListener('click', function () { abrirCategoria(btn) }));
    });

    function abrirCategoria(btn) {
        const buttonText = btn.textContent.trim();
        console.log('Botão clicado:', buttonText);
        const url = btn.getAttribute('data-url');

        if (buttonText === 'Criar Categoria') {
            const modal = document.getElementById('modalAddCategoria');
            console.log('Modal encontrado:', modal);
            $(modal).modal('show');
            $(modal).removeClass('fade').addClass('show');
            $(modal).css('display', 'block');
        } else if (buttonText === 'Criar Notícia') {
            console.log('url', url)
            window.location.href = url;
        } else if (buttonText === 'Criar Tópico') {
            const modal = document.getElementById('modalAddTopico');
            console.log('Modal encontrado:', modal);
            $(modal).modal('show');
            $(modal).removeClass('fade').addClass('show');
            $(modal).css('display', 'block');
        } else if (buttonText == 'Sugerir Tópico') {
            const modal = document.getElementById('modalAddTopico');
            $('#modalTopicoTitle').text('Sugerir Tópico');
            $('#formAddTopico').attr('action', '/sugestoes/store/');
            $(modal).modal('show');
        }
    }

    // Abrir edit de Topico
    document.querySelectorAll('.container-abas').forEach(container => {
        const editTopicos = container.querySelectorAll('.btn-editTopico');

        editTopicos.forEach(editTopico => {
            editTopico.addEventListener('click', function () {
                const idTopico = editTopico.getAttribute("data-id");
                console.log(idTopico);

                $.ajax({
                    url: '/topicos/edit/' + idTopico,
                    method: 'GET',
                    success: function (response) {
                        $('#titulo').val(response.titulo);

                        $('#formAddTopico').attr('action', '/topicos/update/' + idTopico);

                        if (!$('#formAddTopico input[name="_method"]').length) {
                            $('#formAddTopico').append('<input type="hidden" name="_method" value="PUT">');
                        }

                        $('#modalTopicoTitle').text('Editar Tópico');
                        $('#btnSalvarTopico').text('Atualizar');

                        $('#modalAddTopico').modal('show');
                    },
                    error: function (xhr) {
                        alert('Erro ao buscar dados do tópico: ' + xhr.responseText);
                    }
                });
            });
        });
    });

    // Status dos topicos sugeridos
    document.querySelectorAll('.container-abas').forEach(container => {
        const btns = container.querySelectorAll('.btn');

        btns.forEach(btn => {
            btn.addEventListener('click', () => {
                const btnStatusTop = btn.classList.contains('btn-statusTop');
                console.log(btnStatusTop);
                const status = btn.getAttribute('data-value');
                const id = btn.getAttribute('data-id');
                console.log(id)

                if (btnStatusTop) {
                    const form = document.getElementById('formConfirmacaoTopico');
                    const route = form.getAttribute('data-route');
                    form.action = route.replace(':id', id);

                    const textoConfirmar = document.querySelector('.mensagemConfirmacaoTopico p');
                    console.log(textoConfirmar);
                    const confirmBtn = document.getElementById('botaoConfirmacaoTopico');
                    console.log(confirmBtn);

                    if (status == 1) {
                        if (textoConfirmar) textoConfirmar.textContent = "Tem certeza de que deseja aprovar este tópico?";
                        if (confirmBtn) {
                            confirmBtn.textContent = "Ativar"; 
                            confirmBtn.classList.replace('btn-danger', 'btn-success');
                        }
                    } else {
                        if (textoConfirmar) textoConfirmar.textContent = "Tem certeza de que deseja reprovar este tópico?";
                        if (confirmBtn) {
                            confirmBtn.textContent = "Desativar"; 
                            confirmBtn.classList.replace('btn-success', 'btn-danger');
                        }
                    }
                    document.getElementById('status').value = status;
                    $('#modalConfirmacaoTopico').modal('show');
                }
            });
        });
    });

    // Abrir o modal de exclusão 
    document.querySelectorAll('.container-abas').forEach(container => {
        const deleteButtons = container.querySelectorAll('.btn-remove');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const modal = btn.getAttribute('data-modal');
                const form = document.getElementById('confirmEcluirForm');
                const url = btn.getAttribute('data-url');

                form.setAttribute('action', url);
                document.getElementById('id').value = id;

                $(modal).modal('show');
            });
        });
    });

    // Fazer a requisição para editar publicacao
    document.querySelectorAll('.container-abas').forEach(container => {
        const editButtons = container.querySelectorAll('.btn-edit');
        editButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const url = btn.getAttribute('data-url');
                window.location.href = url;
            })
        });
    });

    // Js do controle da imagem no edit
    var removeImageBtn = document.getElementById('removeImageBtn');

    if (removeImageBtn) {
        const campoImagem = document.getElementById('campoImagem');
        campoImagem.style.display = 'none';
        removeImageBtn.addEventListener('click', function () {
            const preview = document.getElementById('preview');
            preview.style.display = 'none';
            campoImagem.style.display = 'block';
        });
    }

});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
