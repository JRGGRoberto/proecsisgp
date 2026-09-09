<?php
$adm = '';

if ($tipo == 'prof') {
    $form = 'Professor';
    $titulos = 'Professores';
    $valueForm = '';
    // Largura do col-md-XPTO
    $colMdEmail = '9';
    $colMdCatFunc = '2';
    $colMdCampus = '3';
    $colMdPortaria = '10';
} elseif ($tipo == 'ag') {
    $form = 'Agente';
    $titulos = 'Agentes';
    $valueForm = 'n/a';
    // Largura do col-md-XPTO
    $colMdEmail = '9';
    $colMdCatFunc = '3';
    $colMdCampus = '2';
    $colMdPortaria = '10';
}

$anoAtual = date('Y');
$proxAno = date('Y') + 1;

if ($_GET['valida'] == 'true' && $validade == 1) {
    $btnEnviar = 'Cadastrar';
    $adm = '[Administrador]';
} else {
    $btnEnviar = 'Solicitar cadastro';
}

// Mensagens dependendo de acordo com o sucesso
$alert = '';
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
    $alert = '
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Solicitação enviada com sucesso!
            <button type="button" class="close ml-2" data-dismiss="alert">
                &times;
            </button>
        </div>
    ';
} elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 2) {
    $alert = '
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Usuário cadastrado com sucesso!
            <button type="button" class="close ml-2" data-dismiss="alert">
                &times;
            </button>
        </div>
    ';
} elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 'false') {
    $alert = '
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-center align-items-center text-center" role="alert">
            Erro ao realizar cadastro!
            <button type="button" class="close ml-2" data-dismiss="alert">
                &times;
            </button>
        </div>
    ';
}

// --- MONTAGEM DO HTML PARA NÃO FICAR FEIO DO PROFESSOR PRO AGENTE ---
$htmlEmail = '
    <div class="form-group col-md-'.$colMdEmail.'">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" class="form-control" required
            placeholder="nome.sobrenome@unespar.edu.br"
        >
    </div>
';

$htmlTitulacao = '
    <div class="form-group col-md-3">
        <label for="titulacao">Titulação</label>
        <select id="titulacao" name="titulacao" class="form-control" required>
            <option value="'.$valueForm.'" selected> Selecione... </option>
            <option value="mestre" >Mestre</option>
            <option value="doutor" >Doutor</option>
            <option value="especialista" >Especialista</option>
            <option value="bacharel" >Bacharel</option>
        </select>
    </div>
';

$htmlLattes = '
    <div class="form-group col-md-8">
        <label for="lattes">
            Lattes
        
            <span class="badge badge-warning text-dark">
                Inserir o link do lattes
            </span>
        </label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    lattes.cnpq.br
                </span>
            </div>

            <input type="text" id="lattes" name="lattes" class="form-control">
        </div>
    </div>
';

$htmlPortaria = '
    <div class="form-group col-md-'.$colMdPortaria.'">
        <label for="portaria">
            Portaria

            <span class="badge badge-warning text-dark">
                Inserir o link da portaria
            </span>
        </label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    www.unespar.edu.br
                </span>
            </div>

            <input type="text" id="portaria" name="portaria" class="form-control">
        </div>
    </div>
';

$htmlCampus = '
    <div class="form-group col-md-'.$colMdCampus.'">
        <label for="ca">Campus</label>

        <select id="ca" name="ca" class="form-control" required>
            '.$CAop.'
        </select>
    </div>
';

$htmlCentro = '
    <div class="form-group col-md-4">
        <label for="ce">Centro</label>

        <select id="ce" name="ce" class="form-control" required>
            '.$CEop.'
        </select>
    </div>
';

$htmlColegiado = '
    <div class="form-group col-md-5">
        <label for="co">Colegiado</label>

        <select id="co" name="co" class="form-control" required>
                '.$COop.'
        </select>
    </div>
';

$htmlCatFunc = '
    <div class="form-group col-md-'.$colMdCatFunc.'">
        <label for="categoria">
            Categoria funcional
        </label>

        <select id="categoria" name="categoria" class="form-control" required>
            <option value="" selected disabled> Selecione... </option>
            <option value="e" >Efetivo</option>
            <option value="c" >Temporário</option>
        </select>
    </div>
';

$htmlRT = '
    <div class="form-group col-md-2">
        <label for="regime">
            Regime de trabalho
        </label>

        <select id="regime" name="regime" class="form-control">
            <option value="'.$valueForm.'" selected> Selecione... </option>
            <option value="TIDE" >TIDE</option>
            <option value="40" >40</option>
            <option value="34" >34</option>
            <option value="28" >28</option>
            <option value="24" >24</option>
            <option value="20" >20</option>
            <option value="12" >12</option>
            <option value="10" >10</option>
            <option value="9" >9</option>
            <option value="8" >8</option>
        </select>
    </div>
';

$htmlAnoLetivo = '
    <div class="form-group col-md-2">
        <label>Ano letivo</label>
        <div class="row">
            <div class="col-6">
                <label class="card-opcao w-100">
                    <input type="radio" id="ano" name="ano" value="'.$anoAtual.'" required>
                    <span class="indicador"></span>
                    <span class="numero">'.$anoAtual.'</span>
                </label>
            </div>
            <div class="col-6">
                <label class="card-opcao w-100">
                    <input type="radio" id="ano" name="ano" value="'.$proxAno.'" required>
                    <span class="indicador"></span>
                    <span class="numero">'.$proxAno.'</span>
                </label>
            </div>
        </div>
    </div>
';

?>

<!-- Os JS abaixo estão sendo usados dentro de func_filtroCPF e func_filtroEmail -->
<script src="../includes/funcoes/func_preencherCCC.js"></script>
<script src="../includes/funcoes/func_filtroTelefone.js"></script>
<script src="../includes/funcoes/func_filtroVerificarLinks.js"></script>
<!-- função pai (tudo vem dela) -->
<script src="../includes/funcoes/func_validacaoCadastro.js"></script>
<!-- funções filhos -->
<script src="../includes/funcoes/func_filtroCPF.js"></script>
<script src="../includes/funcoes/func_filtroEmail.js"></script>
<!-- função verificadora -->
<script src="../includes/funcoes/func_verificarDuplicidadeDados.js"></script>
<!-- função de exibir o alert -->
<script src="../includes/funcoes/func_exibirAlertasBootstrap.js"></script> 

<main class="container mt-4">

    <div class="form-row d-flex align-items-center mb-3">
        <h1 class="mb-0"><?php echo $btnEnviar.' '.$form.' '.$adm; ?></h1>
        <button
            type="button"
            class="btn btn-primary btn-sm ml-auto"
            onclick="history.back()"
        >
            Voltar
        </button>
    </div>
    <p class="mb-4">
        <strong>As solicitações serão encaminhadas para uma avaliação e futura adição dos <?php echo $titulos; ?> solicitados</strong>
    </p>

    <!-- Mensagem de Sucesso -->
    <div>
        <?php echo $alert; ?>
    </div>
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) { ?>
        <script>
            const url = new URL(window.location);
            url.search = url.search.replace('sucesso=1', 'sucesso');
            window.history.replaceState({}, document.title, url);
        </script>
    <?php } elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 2) { ?>
        <script>
            const url = new URL(window.location);
            url.search = url.search.replace('sucesso=2', 'sucesso');
            window.history.replaceState({}, document.title, url);
        </script>
    <?php } ?>

    <!-- Mostra a mensagem de alerta -->
    <div id="mensagens"></div>

    <form id="cadastro" method="POST">
        <!-- Linha 1 -->
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required
                    placeholder="Nome completo"
                >
            </div>

            <div class="form-group col-md-4">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" required
                    placeholder="000.000.000-00"
                >
            </div>

            <div class="form-group col-md-3">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control"
                    placeholder="(99)99999-9999"
                >
            </div>

        </div>

        <?php if ($tipo == 'prof') { ?>
            <!-- Linha 2 -->
            <div class="form-row">
                <?php
                    echo $htmlEmail;
            echo $htmlTitulacao;
            ?>
            </div>

            <!-- Linha 3 -->
            <div class="form-row">
                <?php
                echo $htmlAnoLetivo;
            echo $htmlPortaria;
            ?>
            </div>

            <!-- Linha 4 -->
            <div class="form-row">
                <?php
                echo $htmlCampus;
            echo $htmlCentro;
            echo $htmlColegiado;
            ?>
            </div>

            <!-- Linha 5 -->
            <div class="form-row align-items-end">
                <?php
                echo $htmlCatFunc;
            echo $htmlRT;
            echo $htmlLattes;
            ?>
            </div>

        <?php } elseif ($tipo == 'ag') { ?>
            <!-- Linha 2 -->
            <div class="form-row">
                <?php
                echo $htmlCatFunc;
            echo $htmlEmail;
            ?>
            </div>

            <!-- Linha 3 -->
            <div class="form-row">
                <?php
                echo $htmlCampus;
            echo $htmlPortaria;
            ?>
            </div>

        <?php } ?>

        <!-- Botões -->
        <div class="form-row mt-3">
            <div class="col">
                <button
                    type="submit"
                    class="btn btn-success"
                >
                    <?php echo $btnEnviar; ?>
                </button>

                <button
                    type="reset"
                    class="btn btn-success"
                >
                    Limpar
                </button>
            </div>
        </div>
        <br>
    </form>
<?php echo $script; ?>
</main>