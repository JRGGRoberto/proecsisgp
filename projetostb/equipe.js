
// Array para armazenar os equipe
//let equipe = [ ];   // informação vem do 'cadastrar.php' ou do 'editar.php'


function deleteAllRows(){
    $("#tabela-equipe tbody tr").remove(); 
  }
  
  function carregarDados(){
     equipe.forEach(e => insereTable(e) );
  }
  
  function clearModalEquipe(){
    document.getElementById("nome").value = "";
    document.getElementById("instituicao").value = "";
    document.getElementById("formacao").value = "";
    document.getElementById("funcao").value = "Membro da equipe executora";
    document.getElementById("tel").value = "";

  //  document.getElementById("dtinicio").value = "";
  //  document.getElementById("dtfim").value = "";
  }
  
  function fecharModalEquipe(){            
    $('#modalEquipe').modal('hide');
  }
             
  // Função para editar contato da tabela
  function formEditarMembro(id){
    $('#modalEquipe').modal('show');
    
    let index = equipe.findIndex(e => e.id === id);
    var myObj = equipe[index];
    
    // Preenche os inputs
    document.getElementById("nome").value        = myObj.nome;
    document.getElementById("instituicao").value = myObj.instituicao;
    document.getElementById("formacao").value    = myObj.formacao;
    document.getElementById("funcao").value      = myObj.funcao;
    document.getElementById("tel").value         = myObj.tel;

 //   document.getElementById("dtinicio").value    = myObj.dtinicio.substr(0, 10);
 //   document.getElementById("dtfim").value       = myObj.dtfim.substr(0, 10);
            
    document.getElementById("titleMemb").innerHTML = 'Editar dados';
    document.getElementById("addMemb").hidden = true;
    let altMemb = document.getElementsByName("altMemb")[0];
    altMemb.hidden = false;
    altMemb.setAttribute("id",  (myObj.id) );              
  };
  
  function formAddEquipe(){
    $('#modalEquipe').modal('show');
    document.getElementById("addMemb").hidden = false;
    document.getElementsByName("altMemb")[0].hidden = true;
    clearModalEquipe();
    document.getElementById("titleMemb").innerHTML = 'Adicionar membro';
  }
  
  function updatMembro(ida) {
    // Obter os valores dos inputs
         
    let idM = parseInt(ida.id);
    let nome = document.getElementById("nome").value;
    let instituicao = document.getElementById("instituicao").value;
    let formacao = document.getElementById("formacao").value;
    let funcao = document.getElementById("funcao").value;
    let tel = document.getElementById("tel").value;

  //  let dtinicio = document.getElementById("dtinicio").value;
  //  let dtfim = document.getElementById("dtfim").value;
     
    
    let dadosAtual = {
      id: idM,
      nome: nome,
      instituicao: instituicao,
      formacao: formacao,
      funcao: funcao,
      tel: tel
      
      // dtinicio: dtinicio,
      // dtfim: dtfim,
    };
                
    idx = equipe.findIndex(e => e.id === idM);
  
    equipe[idx] = dadosAtual;
     
    deleteAllRows();
    carregarDados();
    clearModalEquipe();
    fecharModalEquipe();
  }

  function formataDate(dataTexo){
    let ano =  dataTexo.substr(0, 4);
    let mes =  dataTexo.substr(5, 2);
    let dia = dataTexo.substr(8, 2);
    return dia +'/'+ mes +'/'+ ano;

  }
  
  function insereTable(novoContato){
    // Adicionar uma nova linha na tabela
    let tabela = document.getElementById("tabela-equipe").getElementsByTagName("tbody")[0];
    let novaLinha = tabela.insertRow();
      let celId = novaLinha.insertCell(0);
      let celNome = novaLinha.insertCell(1);
      let celInstituicao = novaLinha.insertCell(2);
      let celFormacao = novaLinha.insertCell(3);
      let celFuncao = novaLinha.insertCell(4);
      let celTelefone = novaLinha.insertCell(5);

    //  let celDtinicio = novaLinha.insertCell(6);
    //  let celDtfim = novaLinha.insertCell(7);

      let celDelete = novaLinha.insertCell(6);
  
    celId.innerHTML = novoContato.id;
    celNome.innerHTML = novoContato.nome;
    celInstituicao.innerHTML = novoContato.instituicao;
    celFormacao.innerHTML = novoContato.formacao;
    celFuncao.innerHTML = novoContato.funcao;
    celTelefone.innerHTML = novoContato.tel;
    //celDtinicio.innerHTML =formataDate(novoContato.dtinicio);
    //celDtfim.innerHTML = formataDate(novoContato.dtfim);

    celDelete.innerHTML = '<center><button type="button" class="btn btn-light btn-sm" onclick="excluirContato(' + novoContato.id + ')">⛔</button><button type="button" class="btn btn-light btn-sm" onclick="formEditarMembro(' + novoContato.id + ')">✏️</button></center></center>';
  }
  
  // Função para adicionar um contato na tabela
  function adicionarContato() {
    // Obter os valores dos inputs
    let nome = document.getElementById("nome").value;
    let instituicao = document.getElementById("instituicao").value;
    let formacao = document.getElementById("formacao").value;
    let funcao = document.getElementById("funcao").value;
    let tel = document.getElementById("tel").value;
   // let dtinicio = document.getElementById("dtinicio").value;
   // let dtfim = document.getElementById("dtfim").value;
      
    let max = Math.max.apply(Math, equipe.map(e => e.id));
    if(max == '-Infinity'){ max = 0; }

    if( nome.length > 0 ) {
      // Criar um novo objeto de contato
      let novoContato = {
        id: max + 1, //equipe.length + 1,
        nome: nome,
        instituicao: instituicao,
        formacao: formacao,
        funcao: funcao,
        tel: tel
        // dtinicio: dtinicio,
        // dtfim: dtfim,
      };
          
      // Adicionar o novo contato no array
      equipe.push(novoContato);
         
      //Call preenche <Table>
      insereTable(novoContato);
              
      // Limpar os inputs
      clearModalEquipe();
      fecharModalEquipe();
    }
  }
  
  // Função para excluir um contato da tabela
  function excluirContato(id) {
    // Encontrar o índice do contato no array
    let index = equipe.findIndex(contato => contato.id === id);
         
    // Remover o contato do array
    equipe.splice(index, 1);
       
    // Remover a linha correspondente da tabela
    let tabela = document.getElementById("tabela-equipe").getElementsByTagName("tbody")[0];
    tabela.deleteRow(index);
  }
  
  carregarDados();