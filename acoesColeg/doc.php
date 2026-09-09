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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        PROEC - Ações de curricularização da extensão
    </title>


    <style>

        /*
        |--------------------------------------------------------------------------
        | CONFIGURAÇÃO GERAL
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }


        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }


        /*
        |--------------------------------------------------------------------------
        | PÁGINA A4
        |--------------------------------------------------------------------------
        */

        .pagina {
            background: white;
            width: 210mm;
            height: 297mm;
            margin: 20px auto;
            padding: 20mm;
            position: relative;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            page-break-after: always;
            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | ÁREA DE CONTEÚDO
        |--------------------------------------------------------------------------
        */

        .conteudo-pagina {
            height: calc(100% - 15mm);
            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | RODAPÉ
        |--------------------------------------------------------------------------
        */

        .rodape {
            position: absolute;
            bottom: 10mm;
            left: 20mm;
            right: 20mm;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMÁRIO
        |--------------------------------------------------------------------------
        */

        .item-sumario {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 8px;
            width: 100%;
        }

        .item-sumario::after {
            content: "";
            flex-grow: 1;
            border-bottom: 2px dotted #aaa;
            margin: 0 10px;
            position: relative;
            top: -4px;
        }


        .titulo-sumario {
            order: 1;
            background: white;
            padding-right: 5px;
            text-decoration: none;
            color: inherit;
            max-width: 80%;
        }

        .num-sumario {
            order: 3;
            background: white;
            padding-left: 5px;
            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | TÍTULOS
        |--------------------------------------------------------------------------
        */

        h1,
        h2 {
            color: #333;
        }


        .titulo-documento {
            margin-top: 0;
            line-height: 1.3;
        }


        /*
        |--------------------------------------------------------------------------
        | CAPA
        |--------------------------------------------------------------------------
        */

        .capa {
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | TABELAS
        |--------------------------------------------------------------------------
        */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }


        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }


        td {
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | IMPRESSÃO
        |--------------------------------------------------------------------------
        */

        @media print {
            body {
                background: white;
            }

            .pagina {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
            }


            @page {
                size: A4;
                margin: 0;
            }
        }

    </style>

</head>


<body>


<!-- ====================================================================== -->
<!-- CAPA -->
<!-- ====================================================================== -->

<div class="pagina" id="pagina-capa">

    <h1 class="capa">
        Lista de trabalhos publicados de Cultura e Extensão
    </h1>


    <div id="containe-capa" class="capa" >

        <p>&nbsp;</p>


        <img
            src="../imgs/logo_unespar.png"
            alt="UNESPAR"
        >


        <h2>
            PROEC
        </h2>


        <h3>
            Pró-Reitoria de Extensão e Cultura
        </h3>


        <p>&nbsp;</p>


        <p>
            Ações de curricularização da extensão do
        </p>


        <h2>

            Colegiado de
            <?php echo htmlspecialchars($dados->colegiado); ?>

        </h2>


        <h3>

            <?php echo htmlspecialchars($dados->campus); ?>

        </h3>


        <p>&nbsp;</p>

        <p>&nbsp;</p>


        <p>

            Emitido em
            <?php echo date('d/m/Y'); ?>.

        </p>

    </div>


    <div class="rodape">

    </div>

</div>



<!-- ====================================================================== -->
<!-- SUMÁRIO -->
<!-- ====================================================================== -->

<div
    class="pagina"
    id="pagina-sumario"
>

    <h1>
        Sumário
    </h1>


    <div id="container-sumario">

        <!-- JavaScript irá inserir os itens -->

    </div>


    <div class="rodape">

        Página
        <span class="num-pagina"></span>

    </div>

</div>



<!-- ====================================================================== -->
<!-- PROJETOS -->
<!-- ====================================================================== -->

<?php foreach ($detalhes as $p) { ?>

    <div class="pagina pagina-projeto">

        <div class="conteudo-pagina">

            <h2 class="titulo-documento">

                <?php echo htmlspecialchars($p->titulo); ?>

            </h2>


            <h4 style="text-align:right;">

                <?php echo htmlspecialchars($p->coord); ?>

            </h4>


            <p>
                <strong>Vigência:</strong><?php echo $p->vigen_ini; ?> à <?php echo $p->vigen_fim; ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <strong>Estado</strong> <?php echo $estados[$p->estado]; ?>
            </p>


            <p>
                <strong>Protocolo:</strong><?php echo htmlspecialchars($p->protocolo); ?>
            </p>

            <p>
                <strong>Resumo</strong>
            </p>


            <p>

                <?php echo $p->resumo; ?>

            </p>


            <table>

                <caption style="text-align:left;">

                    <strong>Público</strong>

                </caption>


                <thead>

                    <tr>

                        <th style="width:20%;">

                            Membros da comunidade externa

                        </th>


                        <th style="width:20%;">

                            Discentes

                        </th>


                        <th style="width:20%;">

                            Docentes

                        </th>


                        <th style="width:20%;">

                            Agentes universitários e Estagiários

                        </th>


                        <th style="width:20%;">

                            Total

                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>
                            <?php echo $p->dim_mem_com_ex; ?>
                        </td>

                        <td>
                            <?php echo $p->dim_disc; ?>
                        </td>

                        <td>
                            <?php echo $p->dim_doce; ?>
                        </td>

                        <td>
                            <?php echo $p->dim_agent_estag; ?>
                        </td>

                        <td>
                            <?php echo $p->total; ?>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <div class="rodape">

            Página

            <span class="num-pagina"></span>

        </div>

    </div>

<?php } ?>



<!-- ====================================================================== -->
<!-- JAVASCRIPT -->
<!-- ====================================================================== -->

<script>

document.addEventListener("DOMContentLoaded", function () {


    /*
    |--------------------------------------------------------------------------
    | CONFIGURAÇÕES
    |--------------------------------------------------------------------------
    */

    let contadorTitulos = 0;


    /*
    |--------------------------------------------------------------------------
    | FUNÇÃO: CRIAR NOVA PÁGINA
    |--------------------------------------------------------------------------
    */

    function criarPagina() {

        const pagina = document.createElement("div");

        pagina.className = "pagina pagina-projeto";


        const conteudo = document.createElement("div");

        conteudo.className = "conteudo-pagina";


        const rodape = document.createElement("div");

        rodape.className = "rodape";

        rodape.innerHTML =
            'Página <span class="num-pagina"></span>';


        pagina.appendChild(conteudo);

        pagina.appendChild(rodape);


        return pagina;
    }



    /*
    |--------------------------------------------------------------------------
    | QUEBRAR CONTEÚDO DOS PROJETOS
    |--------------------------------------------------------------------------
    */

    function quebrarPaginas() {


        /*
         * Selecionamos uma cópia da lista porque vamos
         * adicionar novas páginas durante o processo.
         */

        const paginasProjetos =
            Array.from(
                document.querySelectorAll(".pagina-projeto")
            );


        paginasProjetos.forEach(function (paginaOriginal) {


            let paginaAtual = paginaOriginal;

            let conteudoAtual =
                paginaAtual.querySelector(".conteudo-pagina");


            /*
             * Enquanto o conteúdo ultrapassar
             * o espaço disponível...
             */

            while (
                conteudoAtual.scrollHeight >
                conteudoAtual.clientHeight
            ) {


                const elementos =
                    Array.from(conteudoAtual.children);


                /*
                 * Segurança
                 */

                if (elementos.length <= 1) {

                    break;

                }


                /*
                 * Pega o último elemento
                 */

                const ultimo =
                    elementos[elementos.length - 1];


                /*
                 * Cria nova página
                 */

                const novaPagina =
                    criarPagina();


                /*
                 * Coloca a nova página depois
                 * da página atual
                 */

                paginaAtual.parentNode.insertBefore(
                    novaPagina,
                    paginaAtual.nextSibling
                );


                /*
                 * Move o último elemento
                 * para a nova página
                 */

                const novoConteudo =
                    novaPagina.querySelector(
                        ".conteudo-pagina"
                    );


                novoConteudo.insertBefore(
                    ultimo,
                    novoConteudo.firstChild
                );


                /*
                 * A nova página passa a ser
                 * a página que estamos analisando.
                 *
                 * Porém precisamos verificar
                 * novamente a página anterior.
                 */

                if (
                    conteudoAtual.scrollHeight >
                    conteudoAtual.clientHeight
                ) {

                    /*
                     * Ainda sobrou conteúdo.
                     *
                     * Criamos outra página.
                     */

                    continue;

                }


                /*
                 * A página atual já está correta.
                 *
                 * Agora verificamos se a nova
                 * página também está cheia.
                 */

                paginaAtual = novaPagina;

                conteudoAtual = novoConteudo;


                /*
                 * Se a nova página também
                 * ultrapassar o tamanho,
                 * o while continuará.
                 */

            }

        });

    }



    /*
    |--------------------------------------------------------------------------
    | EXECUTA A QUEBRA DE PÁGINAS
    |--------------------------------------------------------------------------
    */

    quebrarPaginas();



    /*
    |--------------------------------------------------------------------------
    | NUMERAÇÃO DAS PÁGINAS
    |--------------------------------------------------------------------------
    */

    function numerarPaginas() {
        const paginas =
            document.querySelectorAll(".pagina");


        paginas.forEach(function (pagina, index) {


            const numeroPagina =
                index + 1;


            const span =
                pagina.querySelector(".num-pagina");


            if (span) {

                span.textContent =
                    numeroPagina;

            }

        });

    }



    /*
    |--------------------------------------------------------------------------
    | GERAÇÃO DO SUMÁRIO
    |--------------------------------------------------------------------------
    */

    function gerarSumario() {


        const container =
            document.getElementById(
                "container-sumario"
            );


        container.innerHTML = "";


        const paginas =
            document.querySelectorAll(".pagina");


        paginas.forEach(function (pagina, index) {


            const numeroPagina =
                index + 1;


            const titulos =
                pagina.querySelectorAll(
                    ".titulo-documento"
                );


            titulos.forEach(function (titulo) {


                /*
                 * ID sequencial
                 */

                contadorTitulos++;


                const idElemento =
                    "titulo-" +
                    contadorTitulos;


                titulo.id =
                    idElemento;


                /*
                 * Item do sumário
                 */

                const item =
                    document.createElement("div");


                item.className =
                    "item-sumario";


                /*
                 * Link
                 */

                const link =
                    document.createElement("a");


                link.href =
                    "#" + idElemento;


                link.className =
                    "titulo-sumario";


                link.textContent =
                    titulo.textContent;


                /*
                 * Número da página
                 */

                const numero =
                    document.createElement("span");


                numero.className =
                    "num-sumario";


                numero.textContent =
                    numeroPagina;


                /*
                 * Monta item
                 */

                item.appendChild(link);

                item.appendChild(numero);


                container.appendChild(item);

            });

        });

    }



    /*
    |--------------------------------------------------------------------------
    | EXECUTA A NUMERAÇÃO
    |--------------------------------------------------------------------------
    */

    numerarPaginas();



    /*
    |--------------------------------------------------------------------------
    | EXECUTA A GERAÇÃO DO SUMÁRIO
    |--------------------------------------------------------------------------
    */

    gerarSumario();

});

</script>


</body>

</html>