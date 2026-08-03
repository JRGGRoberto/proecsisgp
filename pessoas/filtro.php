<?php

use App\Entity\Ca_Ce_Co;
use App\Entity\Campi;
// use App\Entity\Colegiado;
require '../vendor/autoload.php';

function exibirFiltro($tipo)
{
    if ($tipo == 'ag') {
        $dadosFiltros = Campi::getRegistros();
        $dadosFiltros;
    } 
    elseif ($tipo == 'pf') {
        $dtFiltros = Ca_Ce_Co::getRegistros();

        $dadosFiltros = [];
        foreach ($dtFiltros as $dt) {
            $dadosFiltros[$dt->campus][] = [
                'nome' => $dt->colegiado,
                'id'   => $dt->co_id
            ];
        }
    }

    $html = '
    <form action="'.strtok($_SERVER['REQUEST_URI'], '?').'" method="GET">
    
        <div class="card shadow-sm mb-3">
            
            <div class="card-header bg-light p-0" id="headingFiltros">
                <button
                    class="btn btn-link btn-block text-left p-3"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapseFiltros"
                    aria-expanded="false"
                    aria-controls="collapseFiltros">

                    <strong>Filtros</strong>
                </button>
            </div>

            <div id="collapseFiltros" class="collapse">
                <div class="card-body">

                    <input type="hidden" name="tipo" value="'.$_GET['tipo'].'">
                    <input type="hidden" name="cargo" value="'.$_GET['cargo'].'">
                    <input type="hidden" name="valida" value="'.$_GET['valida'].'">
                    <input type="hidden" name="sucesso" value="">
                
                    <div class="form-group mb-3">
                        <label for="fNome">Nome</label>
                        <input
                            type="text"
                            class="form-control"
                            id="fNome"
                            name="fNome"
                            value="'.htmlspecialchars($_GET['fNome'] ?? '').'"
                            placeholder="Digite um nome"
                        >
                    </div>

                    <div class="d-flex flex-wrap">';

        if($tipo == 'ag'){
            foreach ($dadosFiltros as $dadosFiltro) {
                $checked = '';
                if (
                    isset($_GET['fId']) &&
                    is_array($_GET['fId']) &&
                    in_array($dadosFiltro->id, $_GET['fId'])
                ){
                    $checked = 'checked';
                }
                
                    $html .= '
                    <div class="custom-control custom-checkbox mr-3 mb-2">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="filtro'.$dadosFiltro->id.'"
                            name="fId[]"
                            value="'.$dadosFiltro->id.'"
                            '.$checked.'
                        >
                        <label class="custom-control-label" for="filtro'.$dadosFiltro->id.'">
                            '.htmlspecialchars($dadosFiltro->nome).'
                        </label>
                    </div>';
            }
        }
        elseif ($tipo == 'pf') {
            $html .= '<div class="row" id="accordion">';

            $i = 0;

            foreach ($dadosFiltros as $campus => $colegiados) {

                $headingId = 'heading'.$i;
                $collapseId = 'collapse'.$i;

                $html .= '
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-header p-0" id="'.$headingId.'">
                            <button
                                type="button"
                                class="btn btn-link btn-block text-left collapsed"
                                data-toggle="collapse"
                                data-target="#'.$collapseId.'"
                                aria-expanded="false"
                                aria-controls="'.$collapseId.'">
                                '.$campus.'
                            </button>
                        </div>

                        <div
                            id="'.$collapseId.'"
                            class="collapse"
                            aria-labelledby="'.$headingId.'"
                            data-parent="#accordion">

                            <div class="card-body">';
                            
                                foreach ($colegiados as $valor) {

                                    $checked = '';

                                    if (
                                        isset($_GET['fId']) &&
                                        is_array($_GET['fId']) &&
                                        in_array($valor['id'], $_GET['fId'])
                                    ) {
                                        $checked = 'checked';
                                    }

                                    $html .= '
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="filtro'.$valor['id'].'"
                                            name="fId[]"
                                            value="'.$valor['id'].'"
                                            '.$checked.'>

                                        <label
                                            class="custom-control-label"
                                            for="filtro'.$valor['id'].'">
                                            '.htmlspecialchars($valor['nome']).'
                                        </label>
                                    </div>';
                                }

                $html .= '
                            </div>
                        </div>
                    </div>
                </div>';

                $i++;
            }

            $html .= '</div>';
                

    }

    // Parte que limpa o filtro
    $_GET['sucesso']=null;
    $params = $_GET;
    if(isset($params['fId'])){
        unset($params['fId']);
    }
    if(isset($params['fNome'])){
        unset($params['fNome']);
    }
    $urlLimpar = strtok($_SERVER['REQUEST_URI'], '?');
    if (!empty($params)) {
        $urlLimpar .= '?' . http_build_query($params);
    }

    $html .= '
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            Aplicar Filtros
                        </button>

                        <a href="'.$urlLimpar.'" class="btn btn-outline-secondary">
                            Limpar
                        </a>
                    </div>
                </div> <!-- card-body -->
            </div> <!-- collapseFiltros -->
        </div> <!-- card-shadow -->
    </form>';

    return $html;
}

?>