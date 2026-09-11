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
        rodape.innerHTML = 'Página <span class="num-pagina"></span>';
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
            let conteudoAtual = paginaAtual.querySelector(".conteudo-pagina");
            /*
             * Enquanto o conteúdo ultrapassar
             * o espaço disponível...
             */

            while (
                conteudoAtual.scrollHeight >
                conteudoAtual.clientHeight
            ) {

                const elementos = Array.from(conteudoAtual.children);

                /*
                 * Segurança
                 */

                if (elementos.length <= 1) {
                    break;
                }

                /* Pega o último elemento */

                const ultimo = elementos[elementos.length - 1];

                /* Cria nova página  */

                const novaPagina = criarPagina();

                /* Coloca a nova página depois 
                 * da página atual  */

                paginaAtual.parentNode.insertBefore(
                    novaPagina,
                    paginaAtual.nextSibling
                );


                /*  Move o último elemento
                 * para a nova página */

                const novoConteudo = novaPagina.querySelector(".conteudo-pagina");

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
        const paginas = document.querySelectorAll(".pagina");
        paginas.forEach(function (pagina, index) {
            const numeroPagina = index + 1;
            const span = pagina.querySelector(".num-pagina");
            if (span) {
                span.textContent = numeroPagina;
            }
        });

    }

    /*
    |--------------------------------------------------------------------------
    | GERAÇÃO DO SUMÁRIO
    |--------------------------------------------------------------------------
    */

    function gerarSumario() {
        const container = document.getElementById("container-sumario");
        container.innerHTML = "";
        const paginas = document.querySelectorAll(".pagina");

        paginas.forEach(function (pagina, index) {
            const numeroPagina = index + 1;
            const titulos = pagina.querySelectorAll( ".titulo-documento");
            titulos.forEach(function (titulo) {
                /*  ID sequencial  */
                contadorTitulos++;
                const idElemento = "titulo-" + contadorTitulos;
                titulo.id = idElemento;

                /*  Item do sumário   */
                const item = document.createElement("div");
                item.className = "item-sumario";

                /*  Link  */
                const link = document.createElement("a");
                link.href = "#" + idElemento;
                link.className = "titulo-sumario";
                link.textContent = titulo.textContent;

                /*  Número da página */
                const numero = document.createElement("span");
                numero.className =  "num-sumario";
                numero.textContent = numeroPagina;

                /*  Monta item */
                item.appendChild(link);
                item.appendChild(numero);
                container.appendChild(item);
            });
        });
    }
    numerarPaginas();
    gerarSumario();

});
