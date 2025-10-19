<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Linhas de linguagem para políticas de autorização
    |--------------------------------------------------------------------------
    |
    | As mensagens abaixo são usadas para exibir respostas padronizadas de
    | acesso nas policies da aplicação. São compatíveis com interpolação.
    |
    */

    'responses' => [
        'deny' => [
            'view' => [
                'default'  => 'Você não tem autorização para visualizar :model.',
                'specific' => [
                    'f' => 'Você não tem autorização para visualizar esta :model.',
                    'm' => 'Você não tem autorização para visualizar este :model.',
                ],
            ],
            'create'   => 'Você não tem autorização para criar :model.',
            'update'   => 'Você não tem autorização para editar :model.',
            'delete'   => 'Você não tem autorização para excluir :model.',
            'finish'   => 'Você não tem autorização para finalizar :model.',
            'reopen'   => 'Você não tem autorização para reabrir :model.',
            'feedback' => 'Você não tem autorização para dar feedback em :model.',
            'already'  => [
                'finished' => [
                    'f' => 'Você não pode finalizar esta :model, pois já foi finalizada.',
                    'm' => 'Você não pode finalizar este :model, pois já foi finalizado.',
                ],
            ],
        ],
        'unavailable' => [
            'update'   => ':model não pode ser atualizado(a).',
            'delete'   => ':model não pode ser excluído(a).',
            'finish'   => ':model não pode ser finalizado(a).',
            'reopen'   => ':model não pode ser reaberto(a).',
            'feedback' => ':model não pode receber feedback.',
        ],
    ],
];
