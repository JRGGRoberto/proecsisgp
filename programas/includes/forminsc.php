  <section>
    <div class="center">
    <form action="senddata.php" method="post" enctype="multipart/form-data">
        <fieldset name="identification">
          <legend>Ficha de inscrição</legend>
    
          <fieldset name="dadospessoais">
            <legend>Dados pessoais</legend>
    
            <div class="line">
              <label for="nome">Nome</label>
              <input 
                type="text" name="nome" id="nome"
                maxlength="40"
                size="40"
                required>
            </div>
            
            <div class="line">
              <label for="rg">RG</label>
              <input type="text" name="rg" id="rg" maxlength="20" style="width:155px;" required>
            </div>
    
            <div class="line">
              <label for="cpf">CPF</label>
              <input class="info" type="text" name="cpf" id="cpf" maxlength="11"  onfocusout="valCPF()" 
              style="width:110px;"
              required> 
            </div>
    
            <div class="line">
              <label for="dt_nasc">Dt. de nasc.</label>
              <input type="date" name="dt_nasc" id="dt_nasc" 
              
              style="width:140px;" required>
            </div>
    
          </fieldset>

          
          <?php
            $id = 'u'.uniqid(rand(10, 100));
          /* bin2hex(random_bytes(8)); echo $id; */
          // echo $id;
          ?>
      <input type="hidden" name="id" value="<?php echo $id; ?>">
          
          <fieldset>
            <legend>Endereço</legend>
            <div class="line">
              <label for="ender">Endereço</label>
              <input type="text" name="ender" id="ender" style="width:180px;" maxlength="40" size="30" required="">
            </div>
           
            <div class="line">
              <label for="bairro">Bairro</label>
              <input type="text" name="bairro" id="bairro" style="width:120px;"  required>
            </div>
    
            <div class="line">
              <label for="cidade">Cidade</label>
              <input type="text" name="cidade" id="cidade" required>
            </div>
    
            <div class="line">
          <label for="estados">Estado</label>
          <select name="estados" id="estados" required>
              <option value="AC">AC</option>
              <option value="AL">AL</option>
              <option value="AP">AP</option>
              <option value="AM">AM</option>
              <option value="BA">BA</option>
              <option value="CE">CE</option>
              <option value="DF">DF</option>
              <option value="ES">ES</option>
              <option value="GO">GO</option>
              <option value="MA">MA</option>
              <option value="MT">MT</option>
              <option value="MS">MS</option>
              <option value="MG">MG</option>
              <option value="PA">PA</option>
              <option value="PB">PB</option>
              <option value="PR" selected>PR</option>
              <option value="PE">PE</option>
              <option value="PI">PI</option>
              <option value="RJ">RJ</option>
              <option value="RN">RN</option>
              <option value="RS">RS</option>
              <option value="RO">RO</option>
              <option value="RR">RR</option>
              <option value="SC">SC</option>
              <option value="SP">SP</option>
              <option value="SE">SE</option>
              <option value="TO">TO</option>
          </select>
            </div>
    
            <div class="line">
              <label for="cep">CEP</label>
              <input type="text" name="cep" id="cep" 
              maxlength=9 minlength=9 style="width:77px;" 
              placeholder="00000-000" pattern="[0-9]{5}-[0-9]{3}"
              required>
              <input type="hidden" id="orgao1" name="orgao1" value="7">
            </div>
    
          </fieldset> 
          
          <fieldset>
            <legend>Contatos</legend>
    
            <div class="line">
              <label for="tel1">Telefone</label>
              <input type="tel" 
                pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}"
                placeholder="(00) 0000-00009"
                name="tel1" id="tel1" required>
            </div>
            
            <div class="line">
              <label for="tel2">Telefone</label>
              <input type="tel" 
              pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}"
                placeholder="(00) 0000-00009"
                name="tel2" id="tel2">
            </div>
    
            <div class="line">
              <label for="email">E-mail</label>
              <input type="email" name="email" id="email" maxlength="40"
                size="40"  placeholder="seuemail@domain.com.br" required/>
            </div>
    
          </fieldset>
    
          <fieldset>
            <legend>Informações acadêmicas</legend>
    
            <div class="line">
              <label for="curso">Curso</label>
              <input 
                type="text" name="curso" id="curso"
                maxlength="40"
                size="40"
                required>
              </div>
      
              <div class="line">
                <label for="serie">Série</label>
                <input 
                  type="number" min="1"
                  name="serie" id="serie" 
                  style="width:50px;"
                  required/>
              </div>
      
      
              <div class="line">
                <label for="prof">Professor(a)</label>

                <select name="prof" id="prof"  required style="width:350px;" onchange="ativaBTN();" required>
                   <option >Selecione</option>

                   <?php
                              require_once 'db/conn.php';
          include_once 'db/get_profs.php';

          $conn->close();

          ?> 

<script>
  let dados =[];
  dados =  <?php echo $json; ?>
</script>                
                </select>

        <input type="hidden" name="address" id="address" value="<?php
                  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                      $ip = $_SERVER['HTTP_CLIENT_IP'];
                  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                  } else {
                      $ip = $_SERVER['REMOTE_ADDR'];
                  }
          echo $ip;
          ?>" >
              </div>
              
        
          </fieldset>


          <fieldset>
            <legend>Dados do projeto do professor selecionado</legend>
    
            <div >
              <label for="tituloproj">Titulo do projeto</label>
              <input 
                type="text" name="tituloproj" id="tituloproj"
                readonly
                size="120"  style="background-color: #E9E9ED;"
                >
            </div>

            <div class="line" style="padding: 20px 0; ">
              <label for="campus">Campus</label>
              <input 
                type="text" name="campus" id="campus"
                readonly 
                size="46"  style="background-color: #E9E9ED;"
              >
            </div>

            <div class="line">
              <label for="garea">Grande área  CNPQ</label>
              <input 
                type="text" name="garea" id="garea"
                readonly 
                size="56"  style="background-color: #E9E9ED;"
              >
            </div>


            <div class="line" style="padding: 0px 0 20px 0; ">
              <label for="area">Área CNPQ</label>
              <input 
                type="text" name="area" id="area"
                readonly 
                size="50"  style="background-color: #E9E9ED;"
              >
            </div>

            <div class="line">
              <label for="sarea">Subaria  CNPQ</label>
              <input 
                type="text" name="sarea" id="sarea"
                readonly 
                size="54" style="background-color: #E9E9ED;"
              >
            </div>
         </fieldset>
          
          
        <!--     
          <input type="hidden" name="bolsa" value="PIBEX">
          <fieldset hidden>
              <legend>Programa de bolsa</legend>
    
              <label for="pibex">PIBEX</label>
              <input type="radio" name="bolsa" id="pibex" value="PIBEX" >
    
              <label for="pibis">PIBIS</label>
              <input type="radio" name="bolsa" id="pibis" value="PIBIS" selected>

            </fieldset>
          -->
    <!--
          <fieldset>
            <legend>Anexos</legend>
            <label for="anex_rg">Foto do RG</label>
            <input 
              type="file" 
              name="anex_rg" id="anex_rg"
              required 
              accept="image/*, application/pdf, application/msword, .docx,
              application/vnd.openxmlformats-officedocument.wordprocessingml.document">
              
            <br>
            <label for="anex_cpf">Foto do CPF</label>
            <input 
              type="file" 
              name="anex_cpf" id="anex_cpf"
              required 
              accept="image/*, application/pdf, application/msword, .docx,
              application/vnd.openxmlformats-officedocument.wordprocessingml.document"> 
              
              <span class="tipos">Extensões aceitas [*.doc, *.docx, *.pdf, *.jpg, *.png]</span>
          </fieldset>
                -->
            <div class="btns">
              <button type="submit"   id="btnOk"  >Enviar</button>
              <button type="reset">Limpar</button>
            </div>
        </fieldset>
      </form>
    </div>
  </section>

