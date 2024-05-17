  <!-- The Modal -->
  <div class="modal fade" id="modalEquipe">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: #3385ff; color: white">
          <h4 class="modal-title" id="titleMemb">Adicionar membros a equipe</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form class="form-group">
      
              <label for="nome">Nome</label>                  <input type="text" class="form-control" id="nome">
              <label for="instituicao">Instituição</label>    <input type="text" class="form-control" id="instituicao">
              <label for="formacao">Formação</label>          <input type="text" class="form-control" id="formacao">
              <label for="funcao">Função na equipe</label>    <input type="text" class="form-control" id="funcao">
              <label for="tel">Telefone</label>               <input type="text" class="form-control" id="tel">
              <div class="row">
                  <div class="col-6">
                     <label for="dtinicio">Início de vigência</label>
                     <input type="date" class="form-control" id="dtinicio">
                  </div>
                  <div class="col-6">
                       <label for="dtfim">Fim de vigência</label>        <input type="date" class="form-control" id="dtfim">

                  </div>
              </div>

              
              

              <BR><center>
              <button type="button" class="btn btn-secondary btn-sm" onclick="fecharModalEquipe()">Fechar</button>
              <button type="button" id="addMemb" class="btn btn-primary btn-sm" onclick="adicionarContato()">Adicionar</button>
              <button type="button" name="altMemb" class="btn btn-primary btn-sm" onclick="updatMembro(this)">Alterar</button></center>
              
        </form>
        </div>
        

        
      </div>
    </div>
  </div>
<!-- The Modal Fim-->