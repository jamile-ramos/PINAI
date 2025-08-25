document.addEventListener('DOMContentLoaded', function () {
    // Mantém um item de sidebar ativo mesmo após recarregar ou navegar para outra página
    $(document).ready(function () {
        $(".nav-item a").on("click", function () {
            const href = $(this).attr("href");
            localStorage.setItem('active_nav_item', href);
        });
    });

    // Código dos botões de acessibilidade (contraste)
    // CONTRASTE
    const body = document.body;
    const contraste = document.getElementById('contraste');

    // Aplica no body ao carregar a página
    if (localStorage.getItem('altoContraste') === 'true') {
        body.classList.add('alto-contraste');
    }

    if (contraste) {
        contraste.addEventListener("click", (e) => {
            e.preventDefault();
            body.classList.toggle("alto-contraste");
            localStorage.setItem('altoContraste', body.classList.contains("alto-contraste"));
        });
    }

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

    // =============================
    // Barra dropdown com acessibilidade + persistência
    // =============================

    const selectBtn = document.querySelector(".select-btn");
    const selectOption = document.querySelector(".select-option");
    const dropdown = document.querySelector(".dropdown-select");

    document.querySelectorAll('.container-abas').forEach(container => {
        const barraId = container.id;
        const optionInside = container.querySelector(".select-option");
        // Renomeia "Visão Geral" para "Minhas Notícias" em abaProfile
        if (optionInside && optionInside.innerText.trim() === 'Visão Geral' && barraId === 'abaProfile') {
            optionInside.innerText = 'Minhas Notícias';
        }

        if (barraId === 'abaProfile') {
            if (selectBtn) {
                selectBtn.addEventListener("focus", () => {
                    const selected = selectBtn.querySelector(".select-option");
                    if (selected) selected.focus();
                });
            }
            container.querySelectorAll(".line-button, .btns-select").forEach(el => el.remove());
        }
    });

    if (dropdown) {
        dropdown.setAttribute('role', 'listbox');
        dropdown.setAttribute('id', 'dropdown-options');
    }

    let optionBtns = [];
    let actionBtns = document.querySelectorAll(".btns-select .option-add");
    let allBtns = [...optionBtns, ...actionBtns];
    let activeIndex = 0;

    if (dropdown) {
        optionBtns = dropdown.querySelectorAll(".option-btn");
    }

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

    //Editar dados do usuário
    $(document).ready(function () {
        $('.btn-info').on('click', function () {
            const userId = $(this).data('id');
            const userName = $(this).data('name');
            const userEmail = $(this).data('email');
            const userType = $(this).data('type');
            const userNai = $(this).data('nai');

            $('#userId').val(userId);
            $('#userName').val(userName);
            $('#userEmail').val(userEmail);
            $('#userType').val(userType);
            $('#userNai').val(userNai);

            $('#editUserModal').modal('show');
        });

        $('#saveUserChanges').on('click', function () {
            const userId = $('#userId').val();
            const userName = $('#userName').val();
            const userEmail = $('#userEmail').val();
            const userType = $('#userType').val();
            const userNai = $('userNai').val();

            $.ajax({
                url: '/usuarios/' + userId + '/update',
                method: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    userId: userId,
                    userName: userName,
                    userType: userType,
                    userEmail: userEmail,
                    userNai: userNai
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
            const userNai = this.getAttribute('data-nai');

            document.getElementById('userId').value = userId;
            document.getElementById('userName').value = userName;
            document.getElementById('userEmail').value = userEmail;
            document.getElementById('userType').value = userType;
            if (userNai != 'selecione') {
                document.getElementById('userType').value = userNai;
            } else {
                document.getElementById('userType').value = 'selecione';
            }

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

        // Limpa o campo de pesquisa
        const searchInput = document.querySelector('.search-form input[name="query"]');
        if (searchInput) {
            searchInput.value = '';
        }

        contents.forEach(content => content.classList.remove('show'));

        const contentId = tab.getAttribute('content-id');
        const content = document.getElementById(contentId);
        content.classList.add('show');

        // Formulario query
        const form = document.querySelector('.search-form');
        form.addEventListener('submit', function () {
            if (contentId) {
                document.getElementById('abaAtiva').value = contentId;
            }
        });

        const selectOption = containerElement.querySelector('.select-option');
        if (selectOption) {
            selectOption.textContent = tab.innerText;
        }
        localStorage.setItem('dropdownSelected', tab.innerText);
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

    // Restaura a última seleção ao carregar a página
    const savedValue = localStorage.getItem("dropdownSelected");
    if (savedValue && selectOption) {
        selectOption.innerText = savedValue;
    }

    // Função que restaura o estado da aba ativa ao redimensionar a página
    const restoreActiveTabOnResize = () => {
        document.querySelectorAll('.container-abas').forEach(container => {
            const barraId = container.id;
            const activeTabId = localStorage.getItem(`active_tab_${barraId}`);

            if (activeTabId) {
                const tabs = container.querySelectorAll('.tab-btn');
                tabs.forEach(tab => {
                    const contentId = tab.getAttribute('content-id');
                    const form = document.querySelector('.search-form');

                    form.addEventListener('submit', function () {
                        if (contentId) {
                            document.getElementById('abaAtiva').value = contentId;
                        }
                    });

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

    // Função que restaura o estado da aba ativa ao recarregar a página
    document.querySelectorAll('.container-abas').forEach(container => {
        const tabs = container.querySelectorAll('.tab-btn');
        const contents = container.querySelectorAll('.content-link');

        tabs.forEach(tabElement => tabElement.classList.remove('active'));
        contents.forEach(contentElement => contentElement.classList.remove('show'));

        const abaId = container.id;
        const idAbaPadrao = tabs[0].getAttribute('content-id');
        const abaAtiva = localStorage.getItem(`active_tab_${abaId}`) || idAbaPadrao;

        if (abaAtiva) {
            tabs.forEach(tabElement => {
                if (tabElement.getAttribute('content-id') === abaAtiva) {
                    tabElement.classList.add('active');
                    const form = document.querySelector('.search-form');

                    form.addEventListener('submit', function () {
                        document.getElementById('abaAtiva').value = abaAtiva;
                    });
                }
            });

            contents.forEach(contentElement => {
                if (contentElement.id === abaAtiva) {
                    contentElement.classList.add('show');
                }
            });
        }
    });

    /* Remover  localStorage quando o usuário for deslogado */
    document.querySelector('#logout-link').addEventListener('click', () => {
        localStorage.clear();
    });

    /* Remover o localStorage quando um link do sidebar for clicado */
    const sidebarLinks = document.querySelectorAll('.nav-secondary');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            const contraste = localStorage.getItem('altoContraste');
            localStorage.clear();

            // Verifica se tem contraste e se tiver, mesmo que mude de rota o contraste vai persistir
            if (contraste === 'true') {
                localStorage.setItem('altoContraste', 'true');
            }
        });
    });

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
        } else if (buttonText === "Adicionar NAI") {
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
                if (statusSelect) {
                    statusSelect.value = selected;
                }

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
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = document.getElementById('confirmExcluirForm');
            const url = btn.getAttribute('data-url');
            form.setAttribute('action', url);
        });
    });


    // Abrir o modal de exclusão Resposta
    document.querySelectorAll('.post-options, .comment-options').forEach(container => {
        const btnPontinhos = container.querySelector(".options-button");

        if (btnPontinhos) {
            btnPontinhos.addEventListener('click', () => {
                const btnsOpcoes = container.querySelector(".options-menu");
                const excluir = btnsOpcoes.querySelector(".btn-destroy");

                if (excluir) {
                    excluir.addEventListener('click', () => {
                        const modal = excluir.getAttribute('data-modal');
                        const form = document.getElementById('confirmExcluirForm');
                        const url = excluir.getAttribute('data-url');

                        form.setAttribute('action', url);
                        $(modal).modal('show');
                    }, { once: true });
                }
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
    const campoImagem = document.getElementById('campoImagem');
    if (removeImageBtn) {
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

    // Exibe o formulario de editar comentário ao clicar no botao comentar dentro da postagem
    document.querySelectorAll(".edit-comment-toggle").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const conteudo = this.dataset.conteudo;

            // esconder o texto normal
            document.getElementById(`comment-content-${id}`).classList.add("d-none");

            // mostrar form
            const form = document.getElementById(`edit-form-${id}`);
            form.classList.remove("d-none");

            // preencher textarea
            document.getElementById(`edit-${id}`).value = conteudo;
        });
    });

    // Clicar em "Cancelar"
    document.querySelectorAll(".btn-cancelar-edit").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;

            // esconder form
            document.getElementById(`edit-form-${id}`).classList.add("d-none");

            // mostrar comentário normal
            document.getElementById(`comment-content-${id}`).classList.remove("d-none");
        });
    });

    // ===== DEBUG SETUP =====
    const DEBUG = true;
    const dlog = (...args) => DEBUG && console.log('[MENTIONS]', ...args);

    //=====================================================
    // MENCIONAR USUÁRIO EM COMENTÁRIO NAS POSTAGENS DO FÓRUM
    //=====================================================
    let mencoesMap = {}; // armazena menções por respostaId ou comentárioId

    // ----------------------------------------------------
    // LISTENER INPUT
    // ----------------------------------------------------
    document.querySelectorAll('.mention-input').forEach(textarea => {
        textarea.addEventListener('input', function () {
            const cursorPos = textarea.selectionStart;
            const text = textarea.value.substring(0, cursorPos);

            let respostaId, tipo, comentarioId;

            if (textarea.id.startsWith("comentario-")) {
                respostaId = textarea.id.split('-')[1];
                tipo = 'criar';
            } else if (textarea.id.startsWith("edit-")) {
                comentarioId = textarea.id.split('-')[1];
                const formulario = document.getElementById(`edit-form-${comentarioId}`);
                respostaId = formulario?.dataset.idresposta;
                tipo = 'edit';
            }

            const match = text.match(/@([^\s@]*)$/);
            dlog('INPUT', { id: textarea.id, tipo, respostaId, comentarioId, hasAtMatch: !!match, cursorPos });

            if (match) {
                const termo = match[1];
                const url = `/comentarios/usuarios/${respostaId}?q=${encodeURIComponent(termo)}`;
                dlog('FETCH start', { url, termo });

                fetch(url)
                    .then(res => {
                        dlog('FETCH status', res.status);
                        return res.json();
                    })
                    .then(data => {
                        dlog('FETCH data', data);
                        mostrarSugestoes(data.usuarios, respostaId, textarea, tipo, comentarioId);
                    })
                    .catch(err => dlog('FETCH error', err));
            } else {
                // Se não está digitando @, esconde menu
                if (tipo === 'criar') {
                    const menu = document.getElementById(`mention-suggestions-${respostaId}`);
                    if (menu) menu.style.display = 'none';
                    dlog('HIDE menu criar', { menuId: `mention-suggestions-${respostaId}`, exists: !!menu });
                } else if (comentarioId) {
                    const menu = document.getElementById(`mention-suggestions-edit-${comentarioId}`);
                    if (menu) menu.style.display = 'none';
                    dlog('HIDE menu edit', { menuId: `mention-suggestions-edit-${comentarioId}`, exists: !!menu });
                }
            }
        });
    });

    // ----------------------------------------------------
    // MENU DE SUGESTÕES
    // ----------------------------------------------------
    function mostrarSugestoes(usuarios, respostaId, textarea, tipo, comentarioId) {
        dlog('mostrarSugestoes()', { tipo, respostaId, comentarioId, count: usuarios?.length });

        let menu, lista, menuId, listaId;

        if (tipo === 'criar') {
            menuId = `mention-suggestions-${respostaId}`;
            listaId = `suggestions-list-${respostaId}`;
        } else {
            menuId = `mention-suggestions-edit-${comentarioId}`;
            listaId = `suggestions-list-edit-${comentarioId}`;
        }

        menu = document.getElementById(menuId);
        lista = document.getElementById(listaId);

        if (!menu || !lista) {
            dlog('ERRO: menu/lista não encontrados', { menuId, listaId, menuExists: !!menu, listaExists: !!lista });
            return;
        }

        lista.innerHTML = '';

        if (!usuarios || usuarios.length === 0) {
            menu.style.display = 'none';
            dlog('Sem usuários, ocultando menu', { menuId });
            return;
        }

        usuarios.forEach(usuario => {
            const li = document.createElement('li');
            li.innerHTML = `
      <a class="dropdown-item d-flex align-items-center suggestion-item"
         href="#"
         data-idusuario="${usuario.id}"
         data-nomeusuario="${usuario.name}"
         data-respostaid="${respostaId}"
         data-tipo="${tipo}"
         data-comentarioid="${comentarioId || ''}">
        <i class="fas fa-user-circle fa-2x text-secondary me-2"></i>
        <span class="text-truncate"><strong class="d-block">${usuario.name}</strong></span>
      </a>`;
            lista.appendChild(li);
        });

        const rect = textarea.getBoundingClientRect();
        menu.style.position = 'absolute';
        menu.style.left = rect.left + 'px';
        menu.style.top = rect.bottom + window.scrollY + 'px';
        menu.style.display = 'block';

        dlog('MENU pronto', { menuId, items: lista.children.length, styleDisplay: menu.style.display });
    }

    // ----------------------------------------------------
    // CLICK NAS SUGESTÕES
    // ----------------------------------------------------
    document.addEventListener('click', function (event) {
        const link = event.target.closest('.suggestion-item');
        if (!link) return;

        event.preventDefault();

        const nome = link.dataset.nomeusuario;
        const id = link.dataset.idusuario;
        const respostaId = link.dataset.respostaid;
        const tipo = link.dataset.tipo;
        const comentarioId = link.dataset.comentarioid;

        dlog('CLICK suggestion', { nome, id, respostaId, tipo, comentarioId });

        let textarea, inputMencoes, chave;

        if (tipo === 'criar') {
            textarea = document.getElementById(`comentario-${respostaId}`);
            inputMencoes = document.getElementById(`mencoes-${respostaId}`);
            chave = respostaId;
        } else {
            textarea = document.getElementById(`edit-${comentarioId}`);
            inputMencoes = document.querySelector(`#edit-form-${comentarioId} input[name="mencoes"]`);
            chave = `edit-${comentarioId}`;
        }

        dlog('Targets', { textareaId: textarea?.id, inputId: inputMencoes?.id, chave });

        if (!textarea) {
            dlog('ERRO: textarea não encontrado!');
            return;
        }

        const cursorPos = textarea.selectionStart ?? textarea.value.length;
        const before = textarea.value.substring(0, cursorPos);
        const after = textarea.value.substring(cursorPos);
        textarea.value = before.replace(/@([^\s@]*)$/, `@${nome} `) + after;
        textarea.focus();

        if (!mencoesMap[chave]) mencoesMap[chave] = [];
        mencoesMap[chave].push({ id: Number(id), nome: nome });

        dlog('mencoesMap após clique', { chave, mencoes: mencoesMap[chave] });

        if (inputMencoes) {
            inputMencoes.value = JSON.stringify(mencoesMap[chave]);
            dlog('input[mencoes] preenchido', inputMencoes.value);
        }

        const menuId = (tipo === 'criar')
            ? `mention-suggestions-${respostaId}`
            : `mention-suggestions-edit-${comentarioId}`;
        const menu = document.getElementById(menuId);
        if (menu) {
            menu.style.display = 'none';
            dlog('Fechando menu', menuId);
        } else {
            dlog('Menu pra fechar não encontrado', menuId);
        }
    });

    // ----------------------------------------------------
    // ATUALIZA MENÇÕES (sync textarea x hidden)
    // ----------------------------------------------------
    function atualizarMencoes({ chave, textareaVal }) {
        dlog('atualizarMencoes() INIT', { chave, textareaVal });

        if (typeof textareaVal !== "string") {
            const textarea = document.querySelector(`#${chave}`);
            textareaVal = textarea ? textarea.value : "";
            dlog('textareaVal obtido do DOM', { chave, textareaVal });
        }

        const nomesCapturados = [...textareaVal.matchAll(/@([A-Za-zÀ-ú\s]+)/g)]
            .map(m => m[1].trim());

        const hidden = document.querySelector(`#mencoes-${chave}`);
        if (!hidden) {
            dlog('[WARN] Campo hidden não encontrado', { chave });
            return;
        }

        let mencoesExistentes = [];
        try {
            mencoesExistentes = JSON.parse(hidden.value || "[]");
        } catch (e) {
            dlog('[ERROR] JSON parse falhou', { error: e, hiddenVal: hidden.value });
            mencoesExistentes = [];
        }

        const resultado = mencoesExistentes.filter(m =>
            nomesCapturados.includes(m.nome)
        );

        hidden.value = JSON.stringify(resultado);

        dlog("atualizarMencoes() DONE", {
            chave,
            nomesCapturados,
            mencoesExistentes,
            resultado,
            inputVal: hidden.value
        });
    }

    // ----------------------------------------------------
    // INIT NOS FORMS DE EDIÇÃO
    // ----------------------------------------------------
    document.querySelectorAll('form.edit-comment-form').forEach(form => {
        const textarea = form.querySelector('.mention-input');
        const comentarioId = textarea.id.replace('edit-', '');
        const chave = `edit-${comentarioId}`;

        if (textarea) {
            dlog("[INIT] Rodando atualizarMencoes() no carregamento do form", {
                comentarioId,
                chave,
                textareaVal: textarea.value
            });

            atualizarMencoes({ chave, textareaVal: textarea.value });
        } else {
            dlog("[INIT] Nenhum textarea encontrado para form", { comentarioId });
        }
    });



    // Toggle de visibilidade do menu de menções
    /*let usuarios = [];
    let nomeUsuarioMencionado = '';

    document.querySelectorAll('.mention-user').forEach(btn =>
        btn.addEventListener('click', function () {
            let respostaId = btn.getAttribute('data-id');
            let menu = document.getElementById(`mention-menu-${respostaId}`);
            let userList = document.getElementById(`user-list-${respostaId}`);
            let noUsersMessage = document.getElementById(`no-users-${respostaId}`);

            let openMenus = document.querySelectorAll('.mention-menu');

            if (!btn) {
                openMenus.forEach(menu => {
                    menu.style.visibility = 'hidden';
                });
                return;
            }

            event.preventDefault();

            if (!menu || !userList) {
                return;
            }

            if (menu.style.visibility === 'visible') {
                menu.style.visibility = 'hidden';
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
                        if (usuarios && usuarios.length > 0) {
                            menu.style.visibility = 'visible';
                        } else {
                            noUsersMessage.style.visibility = 'visible';
                            btn.style.visibility = 'hidden';

                            setTimeout(function () {
                                noUsersMessage.style.visibility = 'hidden';
                            }, 5000);
                        }

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
    });*/

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


    /* Estados e cidades dos Nai no Painel de usuários */
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');

    if (estadoSelect && cidadeSelect) {
        const estadoBd = estadoSelect.getAttribute('data-estado');
        const cidadeBd = cidadeSelect.getAttribute('data-cidade');
        fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
            .then(response => response.json())
            .then(estados => {
                estados.sort((a, b) => a.nome.localeCompare(b.nome)); //ordena por nome
                estados.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.sigla;
                    option.text = estado.sigla + " - " + estado.nome;
                    if (estadoBd) {
                        if (estadoBd === estado.sigla) {
                            option.selected = true;
                            carregarCidades(estado.id);
                        }
                    }
                    option.setAttribute('data-id', estado.id);
                    estadoSelect.add(option);
                });

            });

        estadoSelect.addEventListener('change', () => {
            const selectedOption = estadoSelect.options[estadoSelect.selectedIndex];
            const estadoId = selectedOption.getAttribute('data-id');
            cidadeSelect.innerHTML = '<option value="" disabled selected>Carregando...</option>';

            carregarCidades(estadoId)
        });

        function carregarCidades(estadoId) {
            if (estadoId) {
                fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`)
                    .then(response => response.json())
                    .then(cidades => {
                        cidadeSelect.innerHTML = '<option value="" disabled selected>Selecione a cidade</option>';
                        cidades.forEach(cidade => {
                            const option = document.createElement('option');
                            option.value = cidade.nome;
                            if (cidadeBd) {
                                if (cidadeBd === cidade.nome) {
                                    option.selected = true;
                                }
                            }
                            option.text = cidade.nome
                            cidadeSelect.add(option)
                        });
                    });
            }
        }
    }

    /* Visualizar nome do estado na tabela de NAI em painel de usuários */
    const tableNais = document.getElementById('table-nais');

    if (tableNais) {
        const estadoTds = tableNais.querySelectorAll('td[id^="estado-"]');

        estadoTds.forEach(td => {
            const uf = td.textContent.trim();

            fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
                .then(response => response.json())
                .then(estados => {
                    estados.sort((a, b) => a.nome.localeCompare(b.nome));
                    estados.forEach(estado => {
                        if (uf === estado.sigla) {
                            td.innerHTML = estado.nome;
                        }
                    });
                });
        });
    }

    // Corrigir posicionamento do footer
    $(document).ready(function () {
        // Verifica se main-panel existe e se o footer já não está dentro
        if ($('.main-panel').length && $('#rodape').length) {
            // Move o footer para dentro do main-panel
            $('.main-panel').append($('#rodape'));
        }
    });

    // Compartilhar noticia
    const btn = document.getElementById("shareButton");
    if (btn) {
        btn.addEventListener("click", () => {
            const url = btn.getAttribute("data-url");
            compartilharNoticia(url);
        });
    }
});

// Evento para ocultar alertas com jQuery
$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
});

// Compartilhar noticia
function compartilharNoticia(url) {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'Confira esta notícia:',
            url: url,
        })
            .catch(err => console.log('Erro ao compartilhar:', err));
    } else {
        // Fallback: copia o link para área de transferência
        navigator.clipboard.writeText(url);
        alert('Link copiado para a área de transferência!');
    }
}

