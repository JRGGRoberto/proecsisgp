<?php

require '../vendor/autoload.php';
use App\Entity\Projeto;
use App\Session\Login;

Login::requireLogin();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = Login::getUsuarioLogado();

if (!isset($_GET['id'], $_GET['v'])) {
    echo 'não passado id e versão';
    exit;
}

$id = $_GET['id'];
$ver = $_GET['v'];

// CONSULTA AO PROJETO
$obProjeto = new Projeto();
$obProjeto = Projeto::getProjeto($id, $ver);

if (!$obProjeto instanceof Projeto) {
    echo 'Projeto não encontrado';
    exit;
}

echo '<pre>';
print_r($obProjeto->titulo);
print_r($obProjeto->protocolo);
echo '</pre>';

if (isset($_POST['titulo'])) {
    $obProjeto->renovacao($vigen_ini, $vigen_fim);

    echo 'Novo projeto!';
}
?>  
    <form method="POST" enctype="multipart/form-data" ></form>    
        <div class="col-3">
          <div class="form-group">
            <label>Início vigência</label>
            <input type="date" name="vigen_ini" id="vigen_ini" class="form-control" value="<?php echo substr($obProjeto->vigen_ini, 0, 10); ?>" required>
          </div>
        </div>

        <div class="col-3">
          <div class="form-group">
            <label>Fim vigência</label>
            <input type="date" name="vigen_fim" id="vigen_fim" class="form-control" value="<?php echo substr($obProjeto->vigen_fim, 0, 10); ?>" required>
          </div>
        </div>

        <input type="submit" value="OK">
    </form>
