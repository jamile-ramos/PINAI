<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Nome</th>
                <th>Instituição</th>
                <th>Estado</th>
                <th>Status</th>
                <th>Data de cadastro</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody id="table-nais">
            @if(!empty($nais))
            @foreach($nais as $nai)
            <tr>
                <td class="fw-bold">{{ $nai->nome }} - {{ $nai->siglaNai }}</td>
                <td>{{ $nai->siglaInstituicao }}</td>
                <td class="text-start" id="estado-{{ $nai->id }}" data-id="{{ $nai->id }}">
                    {{ $nai->estado }}
                </td>
                <td class="text-start">
                    {{ $nai->status == 'ativo' ? 'Ativo' : 'Inativo' }}
                </td>
                <td class="text-start">
                    {{ $nai->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="form-button-action">
                        <a class="btn btn-visualizar" href="{{ route('nais.show', ['id' => $nai->id ]) }}" aria-label="Ver informações do Nai {{ $nai->nome }}">
                            Ver mais
                        </a>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-primary btn-edit"
                            data-url="{{ route('nais.edit', ['id' => $nai->id ]) }}"
                            data-original-title="Editar"
                            aria-label="Editar dados do {{ $nai->nome }}">
                            Editar
                        </button>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('nais.destroy') }}"
                            data-id="{{ $nai->id }}"
                            title="Excluir"
                            aria-label="Excluir cadastro {{ $nai->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" class="text-center">Nenhum NAI cadastrado!</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
        {{ $nais->appends(request()->except('nais_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>