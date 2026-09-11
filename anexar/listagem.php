<?php
require '../vendor/autoload.php';
require_once '../includes/funcoes/func_mudaAbreviacao.php';
require_once '../propostas/includes/funcoesListagem.php';

use App\Db\Pagination;
use App\Entity\Form_a;
use App\Entity\Form_b;
use App\Entity\Form_C;
use App\Entity\Form_D;
use App\Entity\Form_Parecer;
use App\Entity\Form_Selecprof;
use App\Entity\Outros;
use App\Session\Login;
use App\Entity\Arquivo;
use App\Entity\ProjMaster;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if (!isset($_GET['anexo'])) {
    die('Anexo não encontrado');
}

$nomeRand = $_GET['anexo'];

echo '<pre>';
print_r($user);
echo '</pre>';


$anexo = Arquivo::getArquivo($nomeRand);
if (!$anexo) {
    die('Anexo não encontrado');
}

$titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$protocolo = filter_input(INPUT_GET, 'protocolo', FILTER_SANITIZE_SPECIAL_CHARS);
$coordenador = filter_input(INPUT_GET, 'coordenador', FILTER_SANITIZE_SPECIAL_CHARS);

if ($user['adm'] == 1) {
    $campus = 'Todos';

    $condicoes = [
        strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
        strlen($coordenador) ? 'coord LIKE "%'.str_replace(' ', '%', $coordenador).'%"' : null,
        strlen($protocolo) ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    ];
} else {
    $campus = $user['ca_nome'];

    $condicoes = [
        'campus = "'.$campus.'"',
        strlen($titulo) ? 'titulo LIKE "%'.str_replace(' ', '%', $titulo).'%"' : null,
        strlen($coordenador) ? 'coord LIKE "%'.str_replace(' ', '%', $coordenador).'%"' : null,
        strlen($protocolo) ? 'protocolo LIKE "%'.str_replace(' ', '%', $protocolo).'%"' : null,
    ];
}

$where = implode(' AND ', array_filter($condicoes));

$qntdProjetos = ProjMaster::getQntdRegistros($where);
$obPagination = new Pagination($qntdProjetos, $_GET['pagina'] ?? 1, 10);

$projetos = ProjMaster::getRegistros($where, null, $obPagination->getLimite());

include '../includes/header.php';
include '../includes/paginacao.php';

?>
<style>
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Selecionar onde inserir o anexo</h4>
        </div>
    </div>

    <div id="arquivoSelecionado" class="alert alert-light border mb-4">
        <div class="d-flex align-items-center">
            <div class="mr-3">
                <div id="iconeArquivo" style="width: 48px; height: 48px;"></div>
            </div>

            <div class="flex-grow-1">
                <div id="nomeArquivo" class="font-weight-bold">
                    <?= htmlspecialchars($anexo->nome_orig) ?>
                </div>

                <small id="tamanhoArquivo" class="text-muted"></small>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="get">
                <input
                    type="hidden"
                    name="anexo"
                    value="<?= $anexo->nome_rand ?>"
                >

                <div class="form-row align-items-end">
                    <div class="col-md-5">
                        <label for="titulo" class="font-weight-bold">
                            Proposta
                        </label>
                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            class="form-control"
                            placeholder="Título da proposta"
                            value="<?= $titulo ?? '' ?>"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="coordenador" class="font-weight-bold">
                            Coordenador
                        </label>
                        <input
                            type="text"
                            id="coordenador"
                            name="coordenador"
                            class="form-control"
                            placeholder=""
                            value="<?= $coordenador ?? '' ?>"
                        />
                    </div>

                    <div class="col-md-2">
                        <label for="protocolo" class="font-weight-bold">
                            Protocolo
                        </label>
                        <input
                            type="text"
                            id="protocolo"
                            name="protocolo"
                            class="form-control"
                            value="<?= $protocolo ?? '' ?>"
                        />
                    </div>

                    <div class="col-md-2 mt-3 mt-md-0">
                        <button
                            type="submit"
                            class="btn btn-primary btn-block"
                        >
                            Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <strong>
                <?= $qntdProjetos ?>
            </strong>
            projeto(s) encontrado(s)
        </div>
        <small class="text-muted">
            Campus: <?= $campus ?>
        </small>
    </div>

<form method="post" action="vincular.php">
    <input
        type="hidden"
        name="anexo"
        value="<?= $anexo->nome_rand ?>"
    >

    <div class="accordion" id="accordionProjetos">
        <?php foreach ($projetos as $i => $p): ?>
            <?php
            
            //Pegando cada avaliação dos formulários 
            $formA_obj = Form_a::getRegistroByProj($p->id);
            $formSelecProf_obj = Form_Selecprof::getRegistroByProj($p->id);
            $formParecer_obj = Form_Parecer::getRegistroByProj($p->id);
            $formB_obj = Form_b::getRegistroByProj($p->id);
            $formC_obj = Form_C::getRegistroByProj($p->id);        
            $formD_obj = Form_D::getRegistroByProj($p->id);



            // =========================
            // RELATÓRIO FINAL APROVADO
            // =========================

            $sqlRelatorioFinal = "
                SELECT 
                    ar.id,
                    ar.id_rel,
                    ar.fase_seq ,
                    ar.fases,
                    ar.tp_instancia,
                    CASE
                        WHEN tp_instancia = 'co' THEN 'Coordenador(ª) de colegiado'
                        WHEN tp_instancia = 'ca' THEN 'Chefe de Divisão'
                        WHEN tp_instancia = 'ce' THEN 'Diretor de Centro de Área'
                        WHEN tp_instancia = 'dc' THEN 'Diretor de Campus'
                        WHEN tp_instancia = 'pf' THEN 'Professor Parecerista'
                    END as tipo_instancia,
                    ar.tipo,
                    CASE
                        WHEN tipo = 'fi' THEN 'Final'
                        WHEN tipo = 'pr' THEN 'Prorrogação'
                        WHEN tipo = 're' THEn 'Renovação'
                        WHEN tipo = 'im' THEN 'Importado'
                        WHEN tipo = 'pa' THEN 'Parcial'
                    END as tipo_relatorio
                FROM 
                    avalia_relatorios ar 
                WHERE 
                    ar.idproj = '".$p->id."'
                    AND (ar.resultado = 'a' OR ar.resultado = 'n')
                ORDER BY
   		            ar.fase_seq;
            ";
            $relF = Outros::qry($sqlRelatorioFinal);
        
            //Pegando todos os relatórios do projeto
            // $relatoriosAprovados = array_merge(
            //     // $relP ?: [],
            //     $relF ?: []
            // );
            // echo '<pre>';
            // print_r($relF);
            // echo '</pre>';
        
            
            $tipo_exten = mudaAbreviacaoTipoPropostas($p->tipo_exten);

            //pega o valor inteiro pro case
            $estadoOriginal = $p->estado;

            //cria o badge do estado 
            $estado = getEstadoProjeto($estadoOriginal);
            $p->estado = $estado['badge'];
        ?> 
            <!-- PROJETO -->
            <div class="card mb-2 shadow-sm border-0">
                <div class="card">
                    <div class="card-header bg-white" id="heading<?= $i ?>">
                    <a class="card-link collapsed d-block" data-toggle="collapse" href="#collapse<?= $i ?>" style="text-decoration: none;">
                        <div class="row align-items-center ">
                            <div class="col-sm-12">
                                <div class="">
                                    📃 <?= $p->titulo ?>
                                </div>
                            </div>
                        </div>
                       
                    </a>
                    <div class="row">
                        <div class="col-sm"><strong>Coordenador:</strong> <?= $p->coord ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm"><strong>Protocolo:</strong> <?= $p->protocolo ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm"><strong>Situação:</strong> <?= $p->estado ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm"><strong>Tipo de proposta:</strong> <?= $tipo_exten ?></div>
                    </div>

                </div>
            </div>

                <!-- CONTEÚDO EXPANDIDO -->
                <div
                    id="collapse<?= $i ?>"
                    class="collapse"
                    data-parent="#accordionProjetos"
                >

                    <div class="card-body bg-light">
                        <div class="small text-muted font-weight-bold mb-3">
                            SELECIONE ONDE INSERIR O ANEXO
                        </div>

                        <!-- CADASTRO DA PROPOSTA -->
                        <label class="d-flex align-items-center bg-white border rounded p-3 mb-2 cursor-pointer" >
                            <input
                                class="mr-3"
                                type="checkbox"
                                name="vinculos[]"
                                value="projetos|<?= $p->id ?>"
                            >
                            <div>
                                <div class="font-weight-bold">
                                    Cadastro da proposta
                                </div>
                                <small class="text-muted">
                                    Documento principal do projeto
                                </small>
                            </div>
                        </label>

                        <!-- AVALIAÇÕES -->
                        <?php
                        $avaliacoes = [];

                        if (!empty($formA_obj)) {
                            $avaliacoes[] = [
                                'id' => $formA_obj->id_avaliacao,
                                'titulo' => 'Anexo A',
                                'descricao' => 'Chefe de Divisão — 1/6'
                            ];
                        }


                        if (!empty($formSelecProf_obj)) {
                            $avaliacoes[] = [
                                'id' => $formSelecProf_obj->id_avaliacao,
                                'titulo' => 'Seleção de parecerista',
                                'descricao' => 'Coordenador(ª) de colegiado — 2/6'
                            ];
                        }

                        if (!empty($formParecer_obj)) {
                            $avaliacoes[] = [
                                'id' => $formParecer_obj->id_avaliacao,
                                'titulo' => 'Anexo B - Parecer',
                                'descricao' => 'Professor(ª) — 3/6'
                            ];
                        }

                        if (!empty($formB_obj)) {
                            $avaliacoes[] = [
                                'id' => $formB_obj->id_avaliacao,
                                'titulo' => 'Ata de Reunião Colegiado',
                                'descricao' => 'Coordenador(ª) de colegiado — 4/6'
                            ];
                        }

                        if (!empty($formC_obj)) {
                            $avaliacoes[] = [
                                'id' => $formC_obj->id_avaliacao,
                                'titulo' => 'Parecer comum',
                                'descricao' => 'Diretor(ª) de Centro de Área — 5/6'
                            ];
                        }

                        if (!empty($formD_obj)) {
                            $avaliacoes[] = [
                                'id' => $formD_obj->id_avaliacao,
                                'titulo' => 'Parecer final',
                                'descricao' => 'Chefe de Divisão — 6/6'
                            ];
                        }
                        ?>

                        <?php if (!empty($avaliacoes)): ?>
                            <div class="border rounded bg-white mb-2">
                                <!-- CABEÇALHO -->
                                <a
                                    class="d-flex justify-content-between align-items-center px-3 py-2 text-dark"
                                    data-toggle="collapse"
                                    href="#avaliacoes<?= $i ?>"
                                    style="text-decoration: none;"
                                >
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <strong>
                                            Avaliações
                                        </strong>
                                        <small class="text-muted ml-2">
                                            (clique para selecionar uma etapa)
                                        </small>
                                    </div>
                                </a>

                                <!-- CONTEÚDO -->
                                <div
                                    id="avaliacoes<?= $i ?>"
                                    class="collapse"
                                >
                                    <div class="px-3 pb-2 pt-1">
                                        <?php foreach ($avaliacoes as $avaliacao): ?>
                                            <label
                                                class="d-flex align-items-center border rounded px-3 py-2 mb-1 cursor-pointer"
                                            >
                                                <input
                                                    class="mr-3"
                                                    type="checkbox"
                                                    name="vinculos[]"
                                                    value="forms|<?= $avaliacao['id'] ?>"
                                                >
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= $avaliacao['titulo'] ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?= $avaliacao['descricao'] ?>
                                                    </small>
                                                </div>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($relF)): ?>
                            <div class="border rounded bg-white mb-2">
                                <a
                                    class="d-flex justify-content-between align-items-center px-3 py-2 text-dark"
                                    data-toggle="collapse"
                                    href="#relF<?= $i ?>"
                                    style="text-decoration: none;"
                                >
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <strong>
                                            Relatórios
                                        </strong>
                                        <small class="text-muted ml-2">
                                            (clique para selecionar um relatório)
                                        </small>
                                    </div>
                                </a>

                                <div
                                    id="relF<?= $i ?>"
                                    class="collapse"
                                >
                                    <div class="px-3 pb-2 pt-1">
                                        <?php foreach ($relF as $index => $rel): ?>
                                            <label
                                                class="d-flex align-items-center border rounded px-3 py-2 mb-1 cursor-pointer"
                                            >
                                                <input
                                                    class="mr-3"
                                                    type="checkbox"
                                                    name="vinculos[]"
                                                    value="forms|<?= $rel->id ?>"
                                                >
                                                <div>
                                                    <div class="font-weight-bold">
                                                        <?= $rel->tipo_relatorio ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?=  $rel->tipo_instancia ?>  — <?= $rel->fase_seq ?>/<?= $rel->fases ?>
                                                    </small>
                                                </div>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- AÇÃO DO PROJETO -->
                        <div class="d-flex justify-content-end pt-3 mt-3 border-top">
                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Vincular anexo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</form>


<div class="row mt-2 align-bottom">
    <div class="col">
        <?php echo $paginacao; ?>
    </div>
</div>

<script src="./frescura.js"></script>

<script>
    document.getElementById('iconeArquivo').innerHTML =
        getIconeArquivo('<?= htmlspecialchars($anexo->nome_orig, ENT_QUOTES) ?>');
</script>
<?php include '../includes/footer.php'; ?>
