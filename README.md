# SistemaFabio-2.0
 http://fabiopasseios.hopto.org/novoSistema/index.php


## FUNCIONALIDADES PRINCIPAIS

- [X] CADASTRAR, PESQUISAR, EDITAR E DELETAR CLIENTES <a href="#010"> V0.1.0 </a>
- [X] CADASTRAR, PESQUISAR, EDITAR E <a href="#TIP1"> DELETAR* </a> PASSEIOS  <a href="#010"> V0.1.0 </a>
- [X] CADASTRAR, PESQUISAR, EDITAR DESPESAS   <a href="#010"> V0.1.0 </a>
- [X] CADASTRAR, PESQUISAR, EDITAR PAGAMENTOS <p> <a href="#010"> V0.1.0 </a> - <a href="#012"> V0.1.2 </a> </p>
- [X] CRIAR LISTA DE PASSEIO   <a href="#012"> V0.1.2</a>
- [X] IMPRIMIR LISTA DE PASSEIO  <a href="#012"> V0.1.2</a>
- [X] EXPORTAR LISTA DE PASSEIO  <a href="#012"> V0.1.2</a>
- [ ] DELETAR PAGAMENTOS
- [ ] CADASTRAR DEPENDENTES(CRIANÇAS)
- [ ] INTEGRAÇÃO COM A RF PARA VERIFICAÇÃO DE CPF

## FUNCIONALIDADES SECUNDÁRIAS

- [ ] VERIFICAÇÃO NA HORA DA ATUALIZAÇÃO DE DADOS DO USUÁRIO SE JÁ EXISTE UM CLIENTE COM O CPF INSERIDO
- [ ] LISTAGEM COM TODOS OS PASSEIOS E QUANTIDADE DE VAGAS DISPONÍVEIS

## BUGS CONHECIDOS <p id="TIP1" > </p>
- [ ] **NO MOMENTO NÃO É POSSÍVEL DELETAR UM PASSEIO JÁ QUE PARA DELETAR UM PASSEIO É PRECISO DELETAR OS PAGAMENTOS E A PARTE DE DELETAR PAGAMENTOS NÃO FOI CRIADA AINDA.** 
- [ ] CASO VOCÊ ENTRE NA LISTA DE PASSEIO SEM TER NENHUM CLIENTE, UMA MENSAGEM DE ERROR INTERNO SERÁ EXIBIDA. CORRIGIDO NA 
<a href="#0131">  V0.1.3.1 </a>
- [X] **CASO VOCÊ CADASTRE O PAGAMENTO DE UM CLIENTE SEM ANTES TER CADASTRADO UMA DESPESA, OS VALORES DE SEGURO VIAGEM PODERÃO SER CALCULADOS INCORRETAMENTE.** CORRIGIDO NA 
<a href="#0131">  V0.1.3.1 </a>
 
##  V0.1 | 16.11.2020 <p id="010"> </p>
 * ### CADASTRAR
   * #### CLIENTE
   * #### PASSEIO
     * IMPOSSÍVEL DE REGISTRAR DOIS PASSEIOS COM MESMO NOME E DATA
   * #### DESPESAS DO PASSEIO
     * É PRECISO TER UM PASSEIO REGISTRADO PARA QUE VOCÊ CONSIGA REGISTRAR AS DESPESAS
     * SOMA DOS CAMPOS FEITA AUTOMATICAMENTE
     * CASO JÁ EXISTAM DESPESAS CADASTRADAS PARA O TAL PASSEIO, VOCÊ SERÁ REDIRECIONADO PARA A PÁGINA DE EDIÇÃO DE DESPESAS
   * #### PAGAMENTO DO CLIENTE
     * PARA CADASTRAR UM PAGAMENTO VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "PAGAR" NO CLIENTE QUE PREFERIR
       * É PRECISO TER UM PASSEIO REGISTRADO PARA QUE VOCÊ CONSIGA EFETUAR UM PAGAMENTO
       * SOMA DOS CAMPOS FEITA AUTOMATICAMENTE
       * VOCÊ SERÁ REDIRECIONADO PARA PÁGINA DE ATUALIZAÇÃO DE PAGAMENTO CASO JÁ EXISTA UM PAGAMENTO DO CLIENTE PARA O PASSEIO SELECIONADO

 * ### EDITAR INFORMAÇÕES
   * #### CLIENTE
     * PARA EDITAR UM CLIENTE VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "EDITAR" NO CLIENTE QUE PREFERIR
   * #### PASSEIO
     * PARA EDITAR UM PASSEIO VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "EDITAR" NO PASSEIO QUE PREFERIR

 * ### DELETAR
   * #### CLIENTE
     * PARA DELETAR UM CLIENTE VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "DELETAR" NO CLIENTE QUE PREFERIR
   * #### PASSEIO
     * PARA DELETAR UM PASSEIO VÁ PARA ÁREA DE PESQUISAS E CLIQUE EM "DELETAR" NO CLIENTE QUE PREFERIR
 * ### PESQUISAR
   * #### CLIENTE
     * VOCÊ PODE PESQUISAR UM CLIENTE POR QUALQUER PARTE DO NOME 
     * VOCÊ PODE PESQUISAR UM CLIENTE PELO CPF NO FOMATO 000.000.000-00
   * #### PASSEIO
     * VOCÊ PODE PESQUSAR UM PASSEIO POR QUALQUER PARTE DO NOME DO PASSEIO
     * VOCÊ PODE PESQUISAR UM PASSEIO PELO LOCAL DO PASSEIO
    

 
 ## V0.1.1 | 17.11.2020 **HOTFIX**
* ### CADASTRAR 
  * CORRIGIDO UM BUG EM QUE VOCÊ NÃO PODERIA CADASTRAR UM CLIENTE SEM CPF 
  * CORRIGIDO UM BUG EM QUE VOCÊ NÃO CONSEGUIA CADASTRAR CLIENTES PODE CAUSA DO CAMPO "TRANSPORTE"
 

 ## V0.1.2 | 18.11.2020 <p id="012"> </p>
* ### CADASTRAR
  * IMPOSSÍVEL CADASTRAR PASSEIOS COM DATA ANTERIOR A 01/01/2017 
  * SOMENTE PODERÃO SER CADASTRADOS CLIENTES COM IDADE ENTRE 0-150
  * A PARTIR DE AGORA É NECESSÁRIO INSERIR NOME E DATAS VÁLIDAS PARA CADASTRAR UM PASSEIO
  * A PARTIR DE AGORA É NECESSÁRIO INSERIR NOME E DATA DE NASCIMENTO VÁLIDA PARA CADASTRAR UM CLIENTE

* ### LISTAGEM DE CLIENTES
  * AGORA VOCÊ PODE CRIAR E VER A LISTA DE CLIENTES PARA UM PASSEIO
    * PARA INSERIR UM CLIENTE NA LISTA DE PASSEIO VOCÊ PRECISA REALIZAR UM PAGAMENTO COM O CLIENTE DESEJADO
  * ADICIONADA FUNÇÃO DE IMPRIMIR LISTA CLIENTES DE UM PASSEIO
  * ADICIONADA OPÇÃO DE EXPORTAR A LISTA DE CLIENTES DE UM PASSEIO PARA CSV

* ### PAGAMENTO
  * AGORA VOCÊ PODE EDITAR O PAGAMENTO DE UM CLIENTE EM UM DETERMINADO PASSEIO

* ### PESQUISA
  * AGORA É POSSÍVEL PESQUISAR UM CLIENTE PELO NÚMERO DE TELEFONE NO FORMATO (XX) X XXXX-XXXX

## V0.1.2.1 | 18.11.2020 **HOTFIX**
 * ### CADASTRO 
  * PÁGINA DE CADASTRAR PASSEIOS AGORA FILTRA OS CARACTERES CORRETAMENTE
  
## V0.1.2.2 | 19.11.2020 **HOTFIX**
 * ### DESPESAS 
  * CORRIGIDO UM BUG EM QUE IMPEDIA VOCÊ DE ATUALIZAR AS DESPESAS DE UM PASSEIO
  
## v0.1.3 | 20.11.2020
 * ### CADASTRO CLIENTE
  * OPÇÕES DE **SELECIONAR MEIO DE TRANSPORTE** E **SELECIONAR SEGURO VIAGEM** MOVIDAS PARA **DESPESAS**
 * ### DESPESAS
  * NO CADASTRO DE DESPESA AGORA VOCÊ DEVERÁ INSERIR O VALOR UNITÁRIO DA DESPESA, E NA CAIXA DE TEXTO MENOR VOCÊ IRÁ INSERIR A QUANTIDADE DE ITENS, O CÁLCULO É FEITO      AUTOMATICAMENTE PELO PROGRAMA
  * A QUANTIDADE DO CAMPO **INGRESSO** VEM POR PADRÃO A QUANTIDADE DE CLIENTES CADASTRADO EM UM PASSEIO, MAS VOCÊ PODERÁ TROCAR ESSA QUANTIDADE SE ACHAR NECESSÁRIO
  * O VALOR DO SEGURO VIAGEM SERÁ CALCULADO AUTOMATICAMENTE APÓS VOCÊ REALIZAR O PAGAMENTO DE UM CLIENTE E SELECIONAR SE ESTE CLIENTE TERÁ OU NÃO SEGURO VIAGEM
   * **CASO VOCÊ CADASTRE UM CLIENTE ANTES DE CADASTRAR AS DESPESAS, O VALOR DO SEGURO VIAGEM PODERÁ SER CALCULADO INCORRETAMENTE.** *SERÁ ADICIONADA UMA VERIFICAÇÃO POSTERIORMENTE*. <a href="#TIP1"> VER MAIS </a>
   
 
