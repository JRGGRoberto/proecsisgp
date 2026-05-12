<?php

function pagina($adendosPagination){
    unset($_GET['pagina']);
    $gets = http_build_query($_GET);

    //Paginação
    $paginacao = '';
    $paginas   = $adendosPagination->getPages();

    $paginacao .= '<nav aria-label="Page navigation example">
                    <ul class="pagination pagination-sm">'; 
    foreach($paginas as $key=>$pagina){
        $class = $pagina['atual'] ? 'page-item active': 'page-item';
        $paginacao .= 
        '<li class="'.$class.'">
            <a class="page-link" href="?pagina='.$pagina['pagina'].'&'.$gets.'">'
            .$pagina['pagina']
        .'</a>
        </li>';
    }
    $paginacao .= '</ul>
    </nav>
    ';
    echo $paginacao;
}