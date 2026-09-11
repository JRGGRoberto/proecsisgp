<?php

require '../vendor/autoload.php';

use App\Entity\Ca_Ce_Co;
use App\Entity\Outros;

$estados = [
    0 => 'Não submetido',
    1 => 'Em avaliação',
    2 => 'Não iniciado',
    3 => 'Em execução',
    4 => 'Aguarde Relatório Final',
    5 => 'Finalizado',
    51 => 'Finalizado',
    6 => 'Em avaliação',
    7 => 'Em avaliação',
    9 => 'Cancelado',
];

/*
|--------------------------------------------------------------------------
| DADOS DO COLEGIADO
|--------------------------------------------------------------------------
*/

$co_id = $_GET['co'];
$CaCeCo = new Ca_Ce_Co();
$dados = $CaCeCo->getRegistros(' co_id = "'.$co_id.'" ')[0];

/*
|--------------------------------------------------------------------------
| CONSULTA DOS PROJETOS
|--------------------------------------------------------------------------
*/

$qry = "
SELECT 
   te.nome tipo,   
   TRIM(p.titulo) titulo,
   p.coord, 
   DATE_FORMAT(p.vigen_ini, '%d/%m/%Y') vigen_ini,
   DATE_FORMAT(p.vigen_fim, '%d/%m/%Y') vigen_fim,
   p.protocolo,
   p.resumo,
   p.acec,
   p.estado,
   r.id id_rel,
   r.tipo tp_rel,
   rdf.dim_mem_com_ex, 
   rdf.dim_disc,
   rdf.dim_doce,
   rdf.dim_agent_estag,
   (
      rdf.dim_mem_com_ex +
      rdf.dim_disc +
      rdf.dim_doce +
      rdf.dim_agent_estag
   ) total
FROM   
   projmaster p 
   INNER JOIN tipo_exten te 
      ON te.id = p.tipo_exten 
   LEFT JOIN relats r 
      ON r.idproj = p.id 
      AND r.publicado = 1
   LEFT JOIN rel_detal_final rdf 
      ON (rdf.id, rdf.ver) = (r.id, r.ver)
WHERE
   p.para_avaliar = '".$co_id."';
";

$detalhes = Outros::qry($qry);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta  name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROEC - Ações de curricularização da extensão</title>
    <link rel="stylesheet" href="pagsuma.css">
</head>
   <body>
        <!-- ====================================================================== -->
        <!-- CAPA -->
        <!-- ====================================================================== -->
        
        <div class="pagina" id="pagina-capa">
            <h1 class="capa">Lista de trabalhos publicados de Cultura e Extensão</h1>
            <div id="containe-capa" class="capa" >
                <p>&nbsp;</p>
                <img src="../imgs/logo_unespar.png" alt="UNESPAR">
                <h2>PROEC</h2>
                <h3>Pró-Reitoria de Extensão e Cultura</h3>
                <p>&nbsp;</p>
                <p>Ações de curricularização da extensão do</p>
                <h2>Colegiado de<?php echo htmlspecialchars($dados->colegiado); ?></h2>
                <h3><?php echo htmlspecialchars($dados->campus); ?></h3>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>Emitido em<?php echo date('d/m/Y'); ?>.</p>
            </div>
            <div class="rodape"></div>
        </div>
        
        <!-- ====================================================================== -->
        <!-- SUMÁRIO -->
        <!-- ====================================================================== -->
        
        <div class="pagina" id="pagina-sumario">
            <h1>Sumário</h1>
            <div id="container-sumario">
                <!-- JavaScript irá inserir os itens -->
            </div>
        
            <div class="rodape">Página<span class="num-pagina"></span>
            </div>
        </div>


<!-- ====================================================================== -->
<!-- PROJETOS -->
<!-- ====================================================================== -->

<?php
$totalPessoasAtnd = 0;
$qntTrabalhos = 0;
foreach ($detalhes as $p) {
    ++$qntTrabalhos;
    ?>
    <div class="pagina pagina-projeto">
        <div class="conteudo-pagina">
            <h2 class="titulo-documento"><?php echo htmlspecialchars($p->titulo); ?></h2>
            <h4 style="text-align:right;"><?php echo htmlspecialchars($p->coord); ?></h4>
            <p>
                <strong>Vigência:</strong><?php echo $p->vigen_ini; ?> à <?php echo $p->vigen_fim; ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <strong>Estado</strong> <?php echo $estados[$p->estado]; ?>
            </p>
            <p><strong>Protocolo:</strong><?php echo htmlspecialchars($p->protocolo); ?></p>
            <p><strong>Resumo</strong></p>
            <p><?php echo $p->resumo; ?></p>


            <?php if ($p->tp_rel != 'fi') { ?>
                <p><strong>Público: </strong> Não possui relatório final ainda.</p>
            <?php } else {
                $totalPessoasAtnd += $p->total; ?>    
               
            <table>
                <caption style="text-align:left;"><strong>Público</strong></caption>
                <thead>
                    <tr>
                        <th style="width:20%;">Membros da comunidade externa</th>
                        <th style="width:20%;">Discentes</th>
                        <th style="width:20%;">Docentes</th>
                        <th style="width:20%;">Agentes universitários e Estagiários</th>
                        <th style="width:20%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $p->dim_mem_com_ex; ?></td>
                        <td><?php echo $p->dim_disc; ?></td>
                        <td><?php echo $p->dim_doce; ?></td>
                        <td><?php echo $p->dim_agent_estag; ?></td>
                        <td><?php echo $p->total; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php }    ?>   

        </div>
        <div class="rodape">Página<span class="num-pagina"></span></div>
    </div>

<?php } ?>

   <div class="pagina">
            <div class="conteudo-pagina">
                <h2 class="titulo-documento">Resumo de ações - Colegiado de <?php echo htmlspecialchars($dados->colegiado); ?></h2>
                <div id="container-pagina">
                    <p>Colegiado de <?php echo htmlspecialchars($dados->colegiado); ?></p>
                    <p>Total de pessoas atendidas: <?php echo $totalPessoasAtnd; ?></p>
                    <p>Quantidade de trabalhos realizados: <?php echo $qntTrabalhos; ?></p>


                    <?php ?>
                </div>
        
            </div>
        <div class="rodape">Página<span class="num-pagina"></span></div>
    </div>

   <script src="pagsuma.js"></script>


   </body>
</html>