document.addEventListener('DOMContentLoaded', function () {
    // Mantém um item de sidebar ativo mesmo após recarregar ou navegar para outra página
    $(document).ready(function () {
        const updateActiveNavItem = (activeItem) => {
            $(".nav-item").removeClass("submenu active");
            $(".nav-item i").removeClass("icon-active");
    
            const activeLink = $(".nav-item a[href='" + activeItem + "']");
            activeLink.parent().addClass("submenu active");
            activeLink.find("i").addClass("icon-active");
        };
    
        let activeItem = localStorage.getItem("active_nav_item");
    
        if (window.location.href.indexOf("dashboard") > -1) {
            activeItem = "/dashboard";
        }
    
        if (activeItem) {
            updateActiveNavItem(activeItem);
        }
    
        // Quando um link da navegação for clicado
        $(".nav-item a").on("click", function () {
            const href = $(this).attr('href');
            console.log('Link clicado',href)
            localStorage.setItem("active_nav_item", href);
            updateActiveNavItem(href);
        });
    
        // Ao clicar no botão "Ver mais" do card na página dashboard
        $(".btn-home").on("click", function () {
            const btnVermais = $(this).attr('data-btn');
    
            $(".nav-item").each(function () {
                const dataBtnNav = $(this).find("a").attr("data-btnNav");
    
                if (btnVermais === dataBtnNav) {
                    $(this).addClass("submenu active");
                    localStorage.setItem("active_nav_item", $(this).find("a").attr('href'));
                } else {
                    $(this).removeClass("submenu active");
                }
            });
        });
    
        // Ao clicar nos títulos das notícias na página dashboard
        $("a[data-btn]").on("click", function () {
            const dataBtnValue = $(this).attr("data-btn");
            console.log("Valor de data-btn:", dataBtnValue);
    
            $(".nav-item").each(function () {
                const dataBtnNav = $(this).find("a").attr("data-btnNav");
    
                if (dataBtnValue === dataBtnNav) {
                    $(this).addClass("submenu active");
                    localStorage.setItem("active_nav_item", $(this).find("a").attr('href'));
                } else {
                    $(this).removeClass("submenu active");
                }
            });
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

    document.addEventListener("click", function (e) {
        const dropdown = document.querySelector(".dropdown-select");

        if (dropdown && !dropdown.contains(e.target)) {
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

            const confirmationText = currentStatus == 0 ? 'Tem certeza de que deseja desativar este usuário?' : 'Tem certeza de que deseja ativar este usuário?';
            document.querySelector('.texto-confirmar p').innerText = confirmationText;

            const form = document.getElementById('confirmForm');
            const route = form.getAttribute('data-route');
            form.action = route.replace(':id', userId);

            // Mostra o modal
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
            $('#modalTopicoTitle').text('Adicionar tópico');
            $('#titulo').val('');
            $(modal).modal('show');
            $(modal).removeClass('fade').addClass('show');
            $(modal).css('display', 'block');
        } else if (buttonText === 'Sugerir Tópico') {
            $('#titulo').val('');
            const modal = document.getElementById('modalAddTopico');
            $('#modalTopicoTitle').text('Sugerir Tópico');
            $('#formAddTopico').attr('action', '/sugestoes/store/');
            $(modal).modal('show');
        } else if (buttonText === 'Criar Postagem') {
            console.log('entrou')
            window.location.href = url;
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
                const id = btn.getAttribute('data-id');
                const selected = btn.getAttribute('data-selected');
                const statusSelect = document.getElementById('statusSelect');
                statusSelect.value = selected;

                if (btnStatusTop) {
                    const form = document.getElementById('formConfirmacaoTopico');
                    const route = form.getAttribute('data-route');
                    form.action = route.replace(':id', id);
                    console.log(form)

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

    // Menu edit dentro de postagem (3 pontinhos)
    const pontinhos = document.querySelectorAll('.post-options');

    pontinhos.forEach(pontinho => {
        pontinho.addEventListener('click', (event) => {
            event.stopPropagation();

            const pontinhosMenu = pontinho.querySelector('.options-menu');
            console.log('Pontinho', pontinhosMenu);

            if (pontinhosMenu) {
                const menus = document.querySelectorAll('.options-menu');
                console.log(menus);
                menus.forEach(menu => {
                    if (menu !== pontinhosMenu) {
                        menu.classList.remove('visible');
                    }
                });

                pontinhosMenu.classList.toggle('visible');
            }
        });
    });

    // Fecha o menu se clicar fora
    document.addEventListener('click', (event) => {
        document.querySelectorAll('.options-menu').forEach(menu => {
            if (!menu.contains(event.target)) {
                menu.classList.remove('visible');
            }
        });
    });



});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
