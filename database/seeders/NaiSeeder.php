<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nai;

class NaiSeeder extends Seeder
{
    public function run(): void
    {
        $nais = [
            [
                'nome' => 'Núcleo de Acessibilidade e Inclusão',
                'instituicao' => 'Universidade Federal de Exemplo',
                'siglaInstituicao' => 'UFE',
                'estado' => 'SP',
                'cidade' => 'São Paulo',
                'email' => 'contato@nai-ufe.edu.br',
                'telefone' => '(11) 1234-5678',
                'site' => 'https://nai-ufe.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI1',
            ],
            [
                'nome' => 'Centro de Inclusão Digital',
                'instituicao' => 'Instituto Nacional de Tecnologia',
                'siglaInstituicao' => 'INT',
                'estado' => 'RJ',
                'cidade' => 'Rio de Janeiro',
                'email' => 'contato@nai-int.org',
                'telefone' => '(21) 2345-6789',
                'site' => 'https://nai-int.org',
                'status' => 'ativo',
                'siglaNai' => 'NAI2',
            ],
            [
                'nome' => 'Laboratório de Acessibilidade Tecnológica',
                'instituicao' => 'Universidade Estadual de Exemplo',
                'siglaInstituicao' => 'UEE',
                'estado' => 'MG',
                'cidade' => 'Belo Horizonte',
                'email' => 'contato@nai-uee.edu.br',
                'telefone' => '(31) 3456-7890',
                'site' => 'https://nai-uee.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI3',
            ],
            [
                'nome' => 'Centro de Estudos em Inclusão',
                'instituicao' => 'Universidade Federal do Sul',
                'siglaInstituicao' => 'UFS',
                'estado' => 'RS',
                'cidade' => 'Porto Alegre',
                'email' => 'contato@nai-ufs.edu.br',
                'telefone' => '(51) 4567-8901',
                'site' => 'https://nai-ufs.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI4',
            ],
            [
                'nome' => 'Núcleo de Tecnologias Inclusivas',
                'instituicao' => 'Instituto de Pesquisa Avançada',
                'siglaInstituicao' => 'IPA',
                'estado' => 'PR',
                'cidade' => 'Curitiba',
                'email' => 'contato@nai-ipa.org',
                'telefone' => '(41) 5678-9012',
                'site' => 'https://nai-ipa.org',
                'status' => 'ativo',
                'siglaNai' => 'NAI5',
            ],
            [
                'nome' => 'Laboratório de Inclusão Digital',
                'instituicao' => 'Universidade Norte de Exemplo',
                'siglaInstituicao' => 'UNE',
                'estado' => 'BA',
                'cidade' => 'Salvador',
                'email' => 'contato@nai-une.edu.br',
                'telefone' => '(71) 6789-0123',
                'site' => 'https://nai-une.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI6',
            ],
            [
                'nome' => 'Centro de Acessibilidade e Educação',
                'instituicao' => 'Universidade do Norte',
                'siglaInstituicao' => 'UN',
                'estado' => 'CE',
                'cidade' => 'Fortaleza',
                'email' => 'contato@nai-un.edu.br',
                'telefone' => '(85) 7890-1234',
                'site' => 'https://nai-un.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI7',
            ],
            [
                'nome' => 'Núcleo de Inclusão Acadêmica',
                'instituicao' => 'Universidade Sulista',
                'siglaInstituicao' => 'US',
                'estado' => 'SC',
                'cidade' => 'Florianópolis',
                'email' => 'contato@nai-us.edu.br',
                'telefone' => '(48) 8901-2345',
                'site' => 'https://nai-us.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI8',
            ],
            [
                'nome' => 'Laboratório de Acessibilidade e Inovação',
                'instituicao' => 'Instituto de Ensino Superior',
                'siglaInstituicao' => 'IES',
                'estado' => 'PE',
                'cidade' => 'Recife',
                'email' => 'contato@nai-ies.org',
                'telefone' => '(81) 9012-3456',
                'site' => 'https://nai-ies.org',
                'status' => 'ativo',
                'siglaNai' => 'NAI9',
            ],
            [
                'nome' => 'Centro de Inclusão e Tecnologia',
                'instituicao' => 'Universidade Central do Brasil',
                'siglaInstituicao' => 'UCB',
                'estado' => 'DF',
                'cidade' => 'Brasília',
                'email' => 'contato@nai-ucb.edu.br',
                'telefone' => '(61) 0123-4567',
                'site' => 'https://nai-ucb.edu.br',
                'status' => 'ativo',
                'siglaNai' => 'NAI10',
            ],
        ];

        foreach ($nais as $nai) {
            Nai::create($nai);
        }
    }
}
