<?php
function filtro(){

    $titulo = htmlspecialchars($_GET['titulo'] ?? '');
    $coordenador = htmlspecialchars($_GET['coordenador'] ?? '');
    $protocolo = htmlspecialchars($_GET['protocolo'] ?? '');
    $orderBy = htmlspecialchars($_GET['orderBy'] ?? '');
    
    $hiddenFields = '';
    foreach ($_GET as $key => $value) {
        if (!in_array($key, ['titulo', 'coordenador', 'protocolo', 'orderBy'])) {
            $hiddenFields .= '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($value).'">';
        }
    }

    $selected_Recentes = '';
    $selected_Antigos = '';
    if($orderBy == 'antigo' || $orderBy == null || $orderBy == ''){
        $selected_Recentes = '';
        $selected_Antigos = ' selected ';
    } else {
        $selected_Recentes = ' selected ';
        $selected_Antigos = '';
    }

    $filtro = '
        <form method="GET">
            <strong>Filtro de buscas</strong>

            '.$hiddenFields.'

            <div class="row my-2">
                
                <div class="col-3">
                    <label>Título</label> 
                    <input type="text" name="titulo" class="form-control" value="'.$titulo.'">
                </div>

                <div class="col-3">
                    <label>Coordenador</label> 
                    <input type="text" name="coordenador" class="form-control" value="'.$coordenador.'">
                </div>

                <div class="col-2">
                    <label>Protocolo</label> 
                    <input type="text" name="protocolo" class="form-control" value="'.$protocolo.'">
                </div>

                <div class="col-2">
                    <label>Data de solicitação</label>
                    <select name="orderBy" class="form-control">
                        <option value="antigo"  '.  $selected_Antigos .'>Mais antigos</option>
                        <option value="recente" '.  $selected_Recentes .'>Mais recentes</option>
                    </select>
                </div>

                <div class="col-2 d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm mr-2" style="width: 120px;">
                        <strong>Filtrar</strong>
                    </button>

                    <button type="button" onclick="limparFiltros()" 
                        class="btn btn-secondary btn-sm" style="width: 80px;">
                        Limpar
                    </button>
                </div>

            </div>
        </form>

        <script>
            function limparFiltros() {
                const url = new URL(window.location.href);
                
                url.searchParams.delete("titulo");
                url.searchParams.delete("coordenador");
                url.searchParams.delete("protocolo");
                url.searchParams.delete("orderBy");

                window.location.href = url.pathname + (url.searchParams.toString() ? "?" + url.searchParams.toString() : "");
            }
        </script>

        <br>
    ';

    return $filtro;
}
