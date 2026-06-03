<?php
$adm = '';

if ($tipo == 'prof'){
    $hidden = '';
    $form = 'Professor';
}
elseif ($tipo == 'ag'){
    $hidden = 'hidden';
    $form = 'Agente';
}

if ($_GET['valida'] == 'true' && $validade == 1){
    $btnEnviar = 'Cadastrar';
    $adm = '[Administrador]';
}
else {
    $btnEnviar = 'Solicitar cadastro';
}

if ($_GET['cargo'] == 'ag'){
    $na = 'n/a';
}
else {
    $na = null;
}
?>

<script src="../includes/funcoes/func_preencherCCC.js"></script>
<script src="../includes/funcoes/func_filtroCPF.js"></script>
<script src="../includes/funcoes/func_filtroTelefone.js"></script>
<script src="../includes/funcoes/func_filtroEmails.js"></script>
<script src="../includes/funcoes/func_filtroVerificarLinks.js"></script>

<main class="container mt-4">

    <div class="form-row d-flex align-items-center mb-3">
        <h1 class="mb-0">Cadastrar <?= $form.' '.$adm?></h1>

        <button
            type="button"
            class="btn btn-primary btn-sm ml-auto"
            onclick="history.back()"
        >
            Voltar
        </button>
    </div>

    <form id="cadastro" method="POST">
        <!-- Linha 1 -->
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="form-group col-md-4">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" required
                    placeholder="000.000.000-00"
                >
            </div>
        </div>

        <!-- Linha 2 -->
        <div <?=$hidden?> class="form-row">
            
            <div class="form-group col-md-6">
                <label for="titulacao">Titulação</label>

                <select id="titulacao" name="titulacao" class="form-control" required>
                    <option value="<?=$na?>" selected disabled> Selecione... </option>
                    <option value="mestre" >Mestre</option>
                    <option value="doutor" >Doutor</option>
                    <option value="especialista" >Especialista</option>
                    <option value="graduado" >Graduado</option>
                </select>
            </div>

            <div class="form-group col-md-6">
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
        </div>

        <!-- Linha 3 -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" required
                    placeholder="nome.sobrenome@unespar.edu.br"
                >
            </div>

            <div class="form-group col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control"
                    placeholder="(99)99999-9999"
                >
            </div>
        </div>

        <?php if ($hidden): ?>

            <!-- Linha 4 -->
            <!-- Se for cadastrado por administrador, ai não fica disable -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="ca">Campus</label>

                    <select id="ca" name="ca" class="form-control" required>
                        <?php
                            echo $CAop;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="categoria">
                        Categoria funcional
                    </label>

                    <select id="categoria" name="categoria" class="form-control" required>
                        <option value="" selected disabled> Selecione... </option>
                        <option value="e" >Efetivo</option>
                        <option value="t" >Temporário</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
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


            </div>

        <?php else: ?>

            <!-- Linha 4 -->
            <!-- Se for cadastrado por administrador, ai não fica disable -->
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="ca">Campus</label>

                    <select id="ca" name="ca" class="form-control" required>
                        <?php
                            echo $CAop;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="ce">Centro</label>

                    <select id="ce" name="ce" class="form-control" required>
                        <?php
                            echo $CEop;
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="co">Colegiado</label>

                    <select id="co" name="co" class="form-control" required>
                        <?php
                            echo $COop;
                        ?>
                    </select>
                </div>
            </div>

            <!-- Linha 5 -->
            <div class="form-row align-items-end">

                <div class="form-group col-md-3">
                    <label for="categoria">
                        Categoria funcional
                    </label>

                    <select id="categoria" name="categoria" class="form-control" required>
                        <option value="" selected disabled> Selecione... </option>
                        <option value="e" >Efetivo</option>
                        <option value="t" >Temporário</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="regime">
                        Regime de trabalho
                    </label>

                    <select id="regime" name="regime" class="form-control" required>
                        <option value="n/a" selected disabled> Selecione... </option>
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

                <div class="form-group col-md-6">
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

            </div>

        <?php endif; ?>

        <!-- Linha 6 Observação -->
        <div class="form-row align-items-end">
        </div>

        <!-- Botões -->
        <div class="form-row mt-3">
            <div class="col">
                <button
                    type="submit"
                    class="btn btn-success"
                >
                    <?= $btnEnviar ?>
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
<script>

</script>
</main>