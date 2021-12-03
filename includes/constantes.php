<?php

    // STATUS PAGAMENTO
    define('CLIENTE_INTERESSADO', 0);
    define('PAGAMENTO_QUITADO', 1);
    define('CLIENTE_CONFIRMADO', 2);
    define('CLIENTE_PARCEIRO', 3);
    define('CLIENTE_CRIANCA', 4);

    //FUNÇÕES DE EXPORTAÇÃO
    define('EXPORTAR_TODOS_PAGAMENTOS_PENDENTES', 1); 

    //USUARIOS
    define('ADMINISTRADOR', 0);
    define('USUARIO_CHEFE', 1);
    define('USUARIO_SIMPLES', 2);
    define('USUARIO_VENDEDOR', 3);

    //MESES DO ANO

    define('MESES_DO_ANO', [ 'JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO' ]);