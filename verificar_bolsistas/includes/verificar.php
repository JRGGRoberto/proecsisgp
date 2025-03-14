<?php 
require '../vendor/autoload.php';

use App\Session\Login;
$obUsuario = Login::getUsuarioLogado();

use App\Entity\CompararAlunos;
$idPermitido = CompararAlunos::getIdPermitidos();
$id_enviar = CompararAlunos::id_enviar();

use App\Entity\Outros;

$nomes = [];
foreach ($idPermitido as $id) {
    $selectProfs = 'SELECT u.nome FROM usuarios u WHERE u.id = "'.$id.'"';
    $select = Outros::qry($selectProfs);

    if (!empty($select) && isset($select[0]->nome)) {
        $nomes[] = $select[0]->nome;
    }
}

$idResponsavel = $id_enviar[0];
$selectEnviar = 'SELECT u.nome FROM usuarios u WHERE u.id = "'.$idResponsavel.'"';
$responsavelEnviar = Outros::qry($selectEnviar);
$responsavelNome = $responsavelEnviar[0]->nome; 

// echo '<pre>';
//     print_r($_POST);
// echo '</pre>';
// exit;
?>


<script>
    function abreviarNome(nome) {
        return nome.length > 25 ? nome.substring(0, 25) + "..." : nome;
    }

    function selecionarArquivo(id) {
        document.getElementById(id).click();
    }

    function exibirNomeArquivo(input, labelId, addBtnId, removeBtnId, sendBtnId) {
        const arquivos = input.files;
        const label = document.getElementById(labelId);
        const addButton = document.getElementById(addBtnId);
        const removeButton = document.getElementById(removeBtnId);
        const sendButton = document.getElementById(sendBtnId);

        if (arquivos.length > 0) {
            let nomes = [];
            for (let i = 0; i < arquivos.length; i++) {
                nomes.push(abreviarNome(arquivos[i].name));
            }
            label.textContent = nomes.join(", ");
            addButton.style.display = 'none';  // Esconde o botão Adicionar
            removeButton.style.display = 'block';  // Mostra o botão Excluir
            sendButton.disabled = false; // Habilita o botão Enviar
        } else {
            label.textContent = "Sem arquivos...";
            addButton.style.display = 'block';  // Mostra o botão Adicionar
            removeButton.style.display = 'none';  // Esconde o botão Excluir
            sendButton.disabled = true; // Desabilita o botão Enviar
        }
    }

    function removerArquivo(inputId, labelId, addBtnId, removeBtnId, sendBtnId) {
        document.getElementById(inputId).value = ''; // Limpa o arquivo selecionado
        document.getElementById(labelId).textContent = "Sem arquivos...";
        document.getElementById(addBtnId).style.display = 'block'; // Mostra o botão Adicionar
        document.getElementById(removeBtnId).style.display = 'none'; // Esconde o botão Excluir
        document.getElementById(sendBtnId).disabled = true; // Desabilita o botão Enviar
    }

    function enviarArquivo(idArquivo) {
        const input = document.getElementById(idArquivo);
        const file = input.files[0];

        if (!file) {
            alert("Selecione um arquivo antes de enviar.");
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: "array" });

            const sheetName = workbook.SheetNames[0]; // Pega a primeira planilha
            const worksheet = workbook.Sheets[sheetName];

            // Converte os dados do Excel para JSON
            const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            // Obtém as chaves a partir da primeira linha da planilha
            const headers = jsonData.shift(); // Remove o cabeçalho do array

            // Cria um array de objetos com os dados
            const result = jsonData.map(row => {
                let obj = {};
                headers.forEach((header, index) => {
                    obj[header] = row[index] || "";
                });
                return obj;
            });

            // Exibe os dados no <div id="resultado">
            document.getElementById("resultado").innerHTML = `<pre>${JSON.stringify(result, null, 2)}</pre>`;

        };

        reader.readAsArrayBuffer(file);
    }
</script>


<div class="card shadow" style="margin-top: 90px">

    <div class="card-body">
        <!-- Botão que abre o modal -->
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-dark btn-sm w-auto px-2" data-toggle="modal" data-target="#ComoFunciona">
                Como funciona ?
            </button>
        </div>

        <!-- Modal centralizado -->
        <div class="modal fade" id="ComoFunciona" tabindex="-1" role="dialog" aria-labelledby="tituloModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> <!-- Adicionado modal-lg -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModal">Como funciona?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li>Os documentos terão que ser padronizados para a leitura correta do sistema</li>
                            <li>O documentos terão que ser .xls ou .xlsx</li>
                            <li>Na primeira linha das tabelas é necessário identificar as colunas (nome, CPF e convênio)</li>
                            <li>A não utilização da padronização acarretará no mal funcionamento do sistema</li>
                            <li>Deve ser inserido um único documento contendo os dados dos bolsistas</li>
                            <li>Após todos os documentos serem inseridos, o professor Sérgio Dantas verificará se existe alguma dualidade dos bolsistas</li>
                            <li>Caso haja dualidade, será apresentada para os professores</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <h2 class="text-center mb-4">Verificação de duplicidade de convênio dos alunos</h2>
        <hr>        

        <form>
            <?php  
                $qnt = count($idPermitido);
                for ($i = 0; $i < $qnt; $i++):  
                    $idArquivo = "file-usuario-" . $i;  
                    $idLabel = "label-usuario-" . $i;  
                    $addBtnId = "add-btn-" . $i;
                    $removeBtnId = "remove-btn-" . $i;
                    $sendBtnId = "send-btn-" . $i;
            ?>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"> <?php print $nomes[$i] ?> </label>
                    <label id="<?= $idLabel ?>" class="col-sm-5 col-form-label">Sem arquivos...</label>
                    <input type="file" id="<?= $idArquivo ?>" class="d-none" accept=".xlsx,.xls" 
                        onchange="exibirNomeArquivo(this, '<?= $idLabel ?>', '<?= $addBtnId ?>', '<?= $removeBtnId ?>', '<?= $sendBtnId ?>')">

                    <div class="col-sm-2 px-1">
                        <?php if (isset($obUsuario['id']) && $obUsuario['id'] == $idPermitido[$i]): ?>

                            <button type="button" id="<?= $addBtnId ?>" class="btn btn-success btn-block" 
                                onclick="selecionarArquivo('<?= $idArquivo ?>')">
                            Adicionar</button>

                            <button type="button" id="<?= $removeBtnId ?>" class="btn btn-danger btn-block" 
                                style="display: none; margin-top: 0;" onclick="removerArquivo('<?= $idArquivo ?>', '<?= $idLabel ?>', '<?= $addBtnId ?>', '<?= $removeBtnId ?>', '<?= $sendBtnId ?>')">
                            Excluir</button>

                        <?php else: ?>
                            <a class="btn btn-secondary btn-block" style="opacity: 0.7;">Adicionar</a>
                        <?php endif; ?>
                        
                    </div>

                    <div class="col-sm-2.5 px-1">
                        <?php if (isset($obUsuario['id']) && $obUsuario['id'] == $idPermitido[$i]): ?>
                            <button type="button" id="<?= $sendBtnId ?>" class="btn btn-primary btn-block" 
                                onclick="enviarArquivo('<?= $idArquivo ?>')" disabled>Enviar</button>
                        <?php else: ?>
                            <a class="btn btn-secondary btn-block" style="opacity: 0.7;">Enviar</a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endfor; ?>
        </form>

        <!-- botão de enviar o projeto -->
        <?php if (isset($obUsuario['id']) && in_array($obUsuario['id'], $id_enviar, true)): ?>
            <div class="dropdown-divider"></div>
            <div class="d-flex justify-content">
                <button type="button" class="btn btn-dark btn-lg" >Verificar</button>
            </div>
        <?php else: ?>
            <div class="dropdown-divider"></div>
            <a>Aguarde a verificação de: <?php echo $responsavelNome?> </a>
        <?php endif;?>
        
    </div>
</div>

 <div id="resultado"></div>

<?php  
    $data = '<div id="resultado"></div>';
?>

<?php
    // $data = '<div id="resultado"></div>';
    // echo '<pre>';
        // print_r($data);
    // echo '</pre>';
    // exit;
    // $arrData = json_decode($data, true);
    // print_r($arrData);

    // print_r($data);
?>
