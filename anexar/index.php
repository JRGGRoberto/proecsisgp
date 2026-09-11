<?php

require '../vendor/autoload.php';

use App\Session\Login;
use App\Entity\Arquivo;

Login::requireLogin();
$user = Login::getUsuarioLogado();
//verifica se é post e se tem algum arquivo sendo enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    $file = $_FILES['arquivo'];

    //pega a extensao do arquivo [.jpeg, .docx, .xslx, etc..]
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nomeRand = md5(uniqid('', true)) . '.' . $ext;

    //faz o upload
    $destino = __DIR__ . '/../upload/uploads/' . $nomeRand;
    move_uploaded_file($file['tmp_name'], $destino);

    //cria o objeto do arquivo e insere no banco
    $arquivo = new Arquivo();
    $arquivo->nome_orig = $file['name'];
    $arquivo->nome_rand = $nomeRand;
    $arquivo->size      = $file['size'];
    $arquivo->tipo      = $file['type'];
    //tabela e id_tab serão inseridos de acordo com 
    $arquivo->tabela    = null;
    $arquivo->id_tab    = null;
    $arquivo->user      = $user['id'];

    $arquivo->cadastrar();

    //passa por url o nome_rand do arquivo, facilitar identificação
    header('Location: listagem.php?anexo=' . urlencode($nomeRand));
    exit;
}

include '../includes/header.php';
?>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="mb-4">
        <h4 class="mb-1">
            Adicionar anexo
        </h4>
    </div>

    <!-- CARD DE UPLOAD -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form
                        method="post"
                        enctype="multipart/form-data"
                        id="formUpload"
                    >
                        <!-- ÁREA DE ARQUIVO -->
                        <div class="form-group">
                            <label
                                for="arquivo"
                                class="font-weight-bold"
                            >
                                Arquivo
                            </label>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    name="arquivo"
                                    id="arquivo"
                                    class="custom-file-input cursor-pointer"
                                    required
                                >
                                <label
                                    class="custom-file-label"
                                    for="arquivo"
                                    data-browse="Selecionar"
                                >
                                    Escolha um arquivo...
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Selecione o arquivo que deseja adicionar ao sistema.
                            </small>
                        </div>

                        <!-- ARQUIVO SELECIONADO -->
                        <div
                            id="arquivoSelecionado"
                            class="alert alert-light border d-none"
                        >
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <div id="iconeArquivo" style="width: 48px; height: 48px;"></div>
                                </div>

                                <div class="flex-grow-1">

                                    <div
                                        id="nomeArquivo"
                                        class="font-weight-bold"
                                    ></div>

                                    <small
                                        id="tamanhoArquivo"
                                        class="text-muted"
                                    ></small>
                                </div>
                            </div>
                        </div>


                        <!-- INFORMAÇÕES -->
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="fas fa-info-circle mr-2 mt-1"></i>
                                <div>
                                    <strong>Como funciona?</strong>

                                    <div class="small mt-1">
                                        Após enviar o arquivo, você poderá selecionar em qual proposta o documento será vinculado.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary px-4"
                                id="btnEnviar"
                            >
                                <i class="fas fa-upload mr-1"></i>
                                Enviar arquivo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./frescura.js"></script>

<script>
    document.getElementById('iconeArquivo').innerHTML =
        getIconeArquivo('<?= htmlspecialchars($anexo->nome_orig, ENT_QUOTES) ?>');
</script>

<?php include '../includes/footer.php'; ?>