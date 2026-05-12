<?php

    //GETS
    unset($_GET['status']);
    unset($_GET['pagina']);
    unset($_GET['palavra']);
    $gets = http_build_query($_GET);

   
    //Paginação
    $paginacao = '';
    $paginas   = $obPagination->getPages();
    $paginacao .= '<nav aria-label="Page navigation example">
                    <ul class="pagination pagination-sm">'; 

    if($obPagination->getQntPages() > 13){
      $paginacao .= 
      '<li class="page-item">
        <a class="page-link" href="?pagina=1&'.$gets.'">﹤</a>
       </li>';
    }
    

    foreach($paginas as $key=>$pagina){

      $class = $pagina['atual'] ? 'page-item active': 'page-item';

      $paginacao .= 
        '<li class="'.$class.'">
          <a class="page-link" href="?pagina='.$pagina['pagina'].'&'.$gets.'">'.$pagina['pagina']  .'</a>
         </li>';
    }

    if($obPagination->getQntPages() > 13){
      $paginacao .= 
      '<li class="page-item">
        <a class="page-link" href="?pagina='. $obPagination->getQntPages() .'&'.$gets.'">﹥</a>
       </li>';
    }
  
    $paginacao .= '</ul>
    </nav>
    ';

$paginacao .= '</ul>
</nav>
';