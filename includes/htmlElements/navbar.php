<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color:#212121 !important;">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <div class="d-flex justify-content-lg-start ml-2 mr-3">
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
    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Link -->
        <li class="nav-item">
          <a class="nav-link" href="#home">INÍCIO</a>
        </li>

        <!-- CADASTRAR -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            CADASTRAR
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="#cadastroCliente">CLIENTE</a>
            </li>
            <li>
              <a class="dropdown-item" href="#cadastroDespesas">DESPESAS</a>
            </li>
            <li>
              <a class="dropdown-item" href="#cadastroPasseio">PASSEIO</a>
            </li>
          </ul>
        </li>

        <!-- Link -->
        <li class="nav-item">
          <a class="nav-link" href="#relatoriosPasseio">PASSEIOS</a>
        </li>
        <!-- PESQUISAR -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            PESQUISAR
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="#pesquisarCliente">CLIENTE</a>
            </li>
            <li>
              <a class="dropdown-item" href="#pesquisarPasseio">PASSEIO</a>
            </li>
          </ul>
        </li>

        <!-- RELATÓRIOS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            RELATÓRIOS
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="#listaAniversariantesMes">ANIVERSARIANTES DO MÊS</a>
            </li>
            <li>
              <a class="dropdown-item" href="#log">LOGS</a>
            </li>
            <li>
              <a class="dropdown-item" href="#listaPagamentosPendentes">PAGAMENTOS PENDENTES</a>
            </li>
            <li>
              <a class="dropdown-item" href="#pesquisarPagamentos">PAGAMENTOS REALIZADOS</a>
            </li>
            <li>
              <a class="dropdown-item" href="#relatorioPeriodico">RELATÓRIO PERIÓDICO DE VENDAS</a>
            </li>
            <li>
              <a class="dropdown-item" href="#relatorioVendas">RELATÓRIO DE VENDAS</a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item" href="#teste">RELATÓRIO VENDAS ADICIONAL</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <!-- Container wrapper -->
</nav>