<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="d-flex justify-content-lg-start ml-2">
        <a class="btn-just-icon " onclick="history.go(-1)">
            <i class="material-icons">

                <span class="material-icons-outlined">
                    arrow_back
                </span>
            </i>
        </a>

        <a class="btn-just-icon  ml-3" onclick="history.go(+1)">
            <i class="material-icons">

                <span class="material-icons-outlined">
                    arrow_forward
                </span>
            </i>
        </a>

        <a class="btn-just-icon ml-3" onclick="history.go(0)">
            <i class="material-icons mx-auto my-auto">
                refresh
            </i>
        </a>



    </div>

    <div class="container">
        <a class="navbar-brand" href="javascript:;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">INÍCIO </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CADASTRAR
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
                        <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
                        <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="relatoriosPasseio.php">PASSEIOS </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        OUTROS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="listaAniversariantesMes.php">ANIVERSARIANTES DO MÊS</a>
                        <a class="dropdown-item" href="log.php">LOGS</a>
                        <a class="dropdown-item" href="listaPagamentosPendentes.php">PAGAMENTOS PENDENTES</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        PESQUISAR
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
                        <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
                        <a class="dropdown-item" href="pesquisarPagamentos.php">PEQUISAR PAGAMENTOS </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">SAIR</a>

                </li>

            </ul>
        </div>
    </div>
</nav>