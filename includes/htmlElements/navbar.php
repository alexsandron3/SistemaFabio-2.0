<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">INÍCIO </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="relatoriosPasseio.php">RELATÓRIOS </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    PESQUISAR
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
                    <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    CADASTRAR
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
                    <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
                    <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    OUTROS
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="log.php">LOGS</a>
                    <a class="dropdown-item" href="listaPagamentosPendentes.php">PAGAMENTOS PENDENTES</a>
                    <?php

                    if ($_SESSION["nivelAcesso"] == 0) {
                    ?>
                        <a class="dropdown-item" href="cadastroDespesas.php">SAIR</a>
                    <?php
                    }
                    ?>

                </div>
            </li>
        </ul>
    </div>
</nav>