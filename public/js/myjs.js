document.addEventListener('DOMContentLoaded', function () {
    // Mantém um item de sidebar ativo mesmo após recarregar ou navegar para outra página
    $(document).ready(function () {
        $(".nav-item a").on("click", function () {
            const href = $(this).attr("href");
            localStorage.setItem('active_nav_item', href);
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
            if ($(window).width() > 1195) {
                $('.tab-btn').hide();
                $('.add-btn').hide();
            } else {
                $('.tab-btn').hide();
                $('.add-btn').hide();
                $('.select-btn').hide();
            }
            $(".search-icon").hide();
            $(".close-search").show();
            $(".search-form").show();
            $(".search-input").show().focus();
        });

        $(".close-search").on("click", function () {
            $(".navbar").removeClass("search-mode");

            $(".close-search").hide();

            if ($(window).width() > 1195) {
                $('.tab-btn').show();
                $('.add-btn').show();
            } else if ($(window).width() > 1040 && $(window).width() < 1995) {
                $('.add-btn').show();
                $('.select-btn').show();
            } else {
                $('.select-btn').show();
            }

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

    // Barra dropdown com acessibilidade
    const selectBtn = document.querySelector(".select-btn");
    document.querySelectorAll('.container-abas').forEach(container => {
        const barraId = container.id;
        const selectOption = container.querySelector(".select-option");
        console.log(barraId)
        if (selectOption.innerText.trim() === 'Visão Geral' && barraId == 'abaProfile') {
            selectOption.innerText = 'Minhas publicações';
        }

        if (barraId === 'abaProfile') {
            if (selectBtn) {
                selectBtn.addEventListener("focus", () => {
                    const selected = selectBtn.querySelector(".select-option");
                    if (selected) selected.focus();


                });
            }

            const optionButtons = document.querySelectorAll(".option-btn, .btns-select .option-add");

            container.querySelectorAll(".line-button, .btns-select").forEach(el => el.remove());
        }
    });

    const dropdown = document.querySelector(".dropdown-select");

    if (dropdown) {
        dropdown.setAttribute('role', 'listbox');
        dropdown.setAttribute('id', 'dropdown-options');
    }

    const selectOption = document.querySelector(".select-option");
    let optionBtns = [];

    if (dropdown) {
        optionBtns = dropdown.querySelectorAll(".option-btn");
    }

    // Agora inclui os botões do btns-select
    let actionBtns = document.querySelectorAll(".btns-select .option-add");
    let allBtns = [...optionBtns, ...actionBtns];
    let activeIndex = 0;

    // Atribui IDs e ARIA aos botões, incluindo os btns-select
    allBtns.forEach((btn, index) => {
        if (!btn.id) btn.id = `dropdown-option-${index}`;
        btn.setAttribute('role', 'option');
        btn.setAttribute('aria-selected', 'false');
    });

    if (selectBtn) {
        selectBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdown.classList.toggle("active");
            const expanded = dropdown.classList.contains("active");
            selectBtn.setAttribute("aria-expanded", expanded);
            if (expanded) updateFocus();
        });

        // Acessibilidade via teclado
        selectBtn.addEventListener("keydown", function (e) {
            const key = e.key;

            if (key === "Enter" || key === " ") {
                e.preventDefault();
                dropdown.classList.toggle("active");
                const expanded = dropdown.classList.contains("active");
                selectBtn.setAttribute("aria-expanded", expanded);
                if (expanded) updateFocus();
            } else if (key === "ArrowDown") {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % allBtns.length;
                updateFocus();
            } else if (key === "ArrowUp") {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + allBtns.length) % allBtns.length;
                updateFocus();
            } else if (key === "Escape") {
                dropdown.classList.remove("active");
                selectBtn.setAttribute("aria-expanded", "false");
            } else if (key === "Tab") {
                // Quando o Tab for pressionado, fecha o dropdown e vai para o próximo elemento
                dropdown.classList.remove("active");
                selectBtn.setAttribute("aria-expanded", "false");
            }
        });

        allBtns.forEach((btn, index) => {
            btn.addEventListener("keydown", function (e) {
                if (e.key === "Enter" || e.key === " ") {
                    e.preventDefault();
                    btn.click();  // Aciona a ação do botão
                }
            });
        });
    }

    document.addEventListener("click", function (e) {
        const dropdown = document.querySelector(".dropdown-select");
        const selectBtn = document.querySelector(".select-btn");

        if (dropdown && selectBtn && !dropdown.contains(e.target) && !selectBtn.contains(e.target)) {
            dropdown.classList.remove("active");
            selectBtn.setAttribute("aria-expanded", "false");
        }
    });

    /* Atualizar aria-activedescendant dinamicamente via JavaScript*/
    const options = document.querySelectorAll('[role="option"]');
    const comboBox = document.getElementById('custom-combobox');

    options.forEach(option => {
        option.addEventListener('mouseover', () => {
            comboBox.setAttribute('aria-activedescendant', option.id);
        });
    });


    // Fecha dropdown ao clicar em uma opção
    allBtns.forEach((btn, index) => {
        btn.addEventListener("click", function () {
            setTimeout(() => {
                dropdown.classList.remove("active");
            }, 50);
            selectBtn.setAttribute("aria-expanded", "false");
            activeIndex = index;
            updateFocus();
        });
    });

    // Atualiza visual e ARIA ao focar item
    function updateFocus() {
        allBtns.forEach((btn, index) => {
            if (index === activeIndex) {
                btn.setAttribute("aria-selected", "true");
                btn.classList.add("highlighted");
                btn.focus();
                selectBtn.setAttribute("aria-activedescendant", btn.id || `focus-${index}`);
            } else {
                btn.setAttribute("aria-selected", "false");
                btn.classList.remove("highlighted");
            }
        });
    }

    // Fazer a palavra menu aparecer quando a tela ficar menor e o sidebar sumir
    function verificarTamanhoTela() {
        const textMenu = document.querySelector('.text-menu');
        if (window.innerWidth < 998) {
            textMenu.style.display = 'block';
        } else {
            textMenu.style.display = 'none';
        }
    }

    verificarTamanhoTela();
    window.addEventListener('resize', verificarTamanhoTela);

    //Alterar tipo no painel de usuários
    $(document).ready(function () {
        $('.btn-info').on('click', function () {
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const userEmail = $(this).data('email');
            const userType = $(this).data('type');

            $('#userId').val(userId);
            $('#userName').val(userName);
            $('#userEmail').val(userEmail);
            $('#userType').val(userType);

            $('#editUserModal').modal('show');
        });

        $('#saveUserChanges').on('click', function () {
            const userId = $('#userId').val();
            const userType = $('#userType').val();

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
            document.getElementById('status').value = (status == 'ativo') ? 'inativo' : 'ativo';

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

            document.getElementById('status').value = (currentStatus == 'ativo') ? 'ativo' : 'inativo';
            const buttonText = currentStatus == 'ativo' ? 'Desabilitar' : 'Ativar';
            const buttonClass = currentStatus == 'ativo' ? 'btn-danger' : 'btn-success';

            const confirmButton = document.getElementById('confirmActionBtn');
            confirmButton.innerText = buttonText;
            confirmButton.classList.remove('btn-danger', 'btn-success');
            confirmButton.classList.add(buttonClass);

            const confirmationText = currentStatus == 'ativo' ? 'Tem certeza de que deseja desativar este usuário?' : 'Tem certeza de que deseja ativar este usuário?';
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
        const url = btn.getAttribute('data-url');
        if (buttonText === 'Criar Categoria') {
            const modal = document.getElementById('modalAddCategoria');
            $(modal).modal('show');
            $(modal).removeClass('fade').addClass('show');
            $(modal).css('display', 'block');
        } else if (buttonText === 'Criar Notícia') {
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
            window.location.href = url;
        } else if (buttonText === 'Adicionar documento') {
            window.location.href = url;
        } else if (buttonText === 'Adicionar Solução') {
            window.location.href = url;
        }
    }

    // Abrir edit de Topico
    document.querySelectorAll('.container-abas').forEach(container => {
        const editTopicos = container.querySelectorAll('.btn-editTopico');

        editTopicos.forEach(editTopico => {
            editTopico.addEventListener('click', function () {
                const idTopico = editTopico.getAttribute("data-id");

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
                const form = document.getElementById('confirmExcluirForm');
                const url = btn.getAttribute('data-url');

                form.setAttribute('action', url);
                document.getElementById('id').value = id;

                $(modal).modal('show');
            });
        });
    });

    // Abrir o modal de exclusão Resposta
    document.querySelectorAll('.post-options').forEach(container => {
        const btnPontinhos = container.querySelector(".options-button");

        if (btnPontinhos) {
            btnPontinhos.addEventListener('click', () => {
                const btnsOpcoes = container.querySelector(".options-menu")
                const excluir = btnsOpcoes.querySelector(".resposta-destroy")
                excluir.addEventListener('click', () => {
                    const id = excluir.getAttribute('data-id');
                    const modal = excluir.getAttribute('data-modal');

                    const form = document.getElementById('confirmExcluirForm');
                    const url = excluir.getAttribute('data-url');
                    form.setAttribute('action', url);
                    document.getElementById('id').value = id;
                    $(modal).modal('show');
                })
            });
        }
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
    const removeImageBtn = document.getElementById('removeImageBtn');

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

            if (pontinhosMenu) {
                const menus = document.querySelectorAll('.options-menu');
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

    // Exibe o formulario de comentar ao clicar no botao comentar dentro da postagem
    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function () {
            let respostaId = this.getAttribute('data-id');
            let form = document.getElementById(`comment-form-${respostaId}`);
            document.querySelectorAll('.comment-form-container').forEach(form => form.style.display = 'none');

            if (form) {
                form.style.display = 'block';
                form.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    });

    // Toggle de visibilidade do menu de menções
    let usuarios = [];
    let nomeUsuarioMencionado = '';

    document.querySelectorAll('.mention-user').forEach(btn =>
        btn.addEventListener('click', function () {
            let respostaId = btn.getAttribute('data-id');
            let menu = document.getElementById(`mention-menu-${respostaId}`);
            let userList = document.getElementById(`user-list-${respostaId}`);

            let openMenus = document.querySelectorAll('.mention-menu');

            if (!btn) {
                openMenus.forEach(menu => {
                    menu.style.display = 'none';
                });
                return;
            }

            event.preventDefault();

            if (!menu || !userList) {
                return;
            }

            if (menu.style.display === 'block') {
                menu.style.display = 'none';
                return;
            }

            // Faz a requisição AJAX para obter os usuários e abrir o menu
            fetch(`/comentarios/usuarios/${respostaId}`)
                .then(response => response.json())
                .then(data => {
                    usuarios = data.usuariosUnicos;
                    usuarioAutenticado = data.userAuth;
                    usuarios = usuarios.filter(usuario => usuario.id != usuarioAutenticado.id)
                    if (usuarios && Array.isArray(usuarios)) {
                        userList.innerHTML = '';
                        usuarios.forEach(usuario => {
                            let li = document.createElement('li');
                            li.classList.add('mention-user-item');
                            li.setAttribute('data-user', usuario.name);
                            li.setAttribute('data-idUsuarioMencionado', usuario.id);
                            li.setAttribute('data-id', respostaId);
                            li.textContent = usuario.name;
                            userList.appendChild(li);

                        });

                        // Exibe o menu de menção
                        menu.style.display = 'block';
                    } else {
                        console.error("Erro: dados de usuários inválidos.");
                    }
                })
                .catch(error => {
                    console.error("Erro ao carregar usuários:", error);
                });

        })
    )

    // Pega o usuario para mencionar no textarea
    document.addEventListener('click', function (event) {
        let userItem = event.target.closest('.mention-user-item');
        if (!userItem) return;

        let respostaId = userItem.getAttribute('data-id');
        let btnMencionar = document.getElementById(`mention-user-${respostaId}`);
        let menu = document.getElementById(`mention-menu-${respostaId}`);
        let userName = userItem.getAttribute('data-user');
        let userId = userItem.getAttribute('data-idUsuarioMencionado')
        let textarea = document.getElementById(`comentario-${respostaId}`);
        let inputUsuarioMencionado = document.getElementById('usuarioMencionado');
        inputUsuarioMencionado.value = userId

        if (userName != null) {
            btnMencionar.disabled = true;
            menu.style.display = 'none'
        }

        let cursorPos = textarea.selectionStart;
        let textBefore = textarea.value.substring(0, cursorPos);
        let textAfter = textarea.value.substring(cursorPos);

        textarea.value = textBefore + ` @${userName}` + textAfter;
        textarea.focus();
        nomeUsuarioMencionado = userName;

        // Fecha o menu após a menção ser adicionada
        if (menu) menu.style.display = 'none';
    });

    // Adiciona um ouvinte de evento para monitorar alterações no texto do comentário
    document.addEventListener('input', function (event) {
        if (event.target && event.target.matches('.mention-input')) {
            let respostaId = event.target.getAttribute('id').split('-')[1];
            let textarea = event.target;
            let btnMencionar = document.getElementById(`mention-user-${respostaId}`);

            let texto = textarea.value.trim();

            // Verifica se já existe uma menção
            let nomeParaProcurar = nomeUsuarioMencionado
            let regex = new RegExp("\\b" + nomeParaProcurar + "\\b", "g");
            let resultado = texto.match(regex);

            let nomeUsuarioEncontrado = false;

            // Verifica se a menção é válida e pertence a um usuário existente
            if (resultado) {
                for (let usuario of usuarios) {
                    if (resultado[0] === usuario.name) {
                        nomeUsuarioEncontrado = true;
                    }
                }
            }

            if (resultado != null && nomeUsuarioEncontrado) {
                btnMencionar.disabled = true;
            } else {
                btnMencionar.disabled = false;
            }
        }
    });

    // Fechar formulario de comentario quando clicar em cancelar
    document.querySelectorAll('.btn-cancelar-comment').forEach(btn => {
        btn.addEventListener('click', function () {
            let respostaId = btn.getAttribute('data-id');
            let formComentar = document.getElementById(`comment-form-${respostaId}`);

            formComentar.style.display = 'none'
            let textarea = document.getElementById(`comentario-${respostaId}`);
            textarea.value = ""
        });
    });

    // Logica do botao de arquivo em editar documento
    const arquivo = document.querySelector('#arquivo');
    const previa = document.querySelector('#previaDocumento');

    if (arquivo && previa) {  // Check if elements are found
        arquivo.addEventListener('change', function () {
            if (arquivo.files.length != 0) {
                previa.classList.remove('d-block');
                previa.classList.add('d-none');
            }
        });
    };

    /* Modal excluir conta */
    /*var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'), {
        backdrop: true, // Isso impede o fechamento do modal quando clicado fora.
        keyboard: false  // Isso impede o fechamento do modal com a tecla ESC.
    });*/
    
    
});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});
