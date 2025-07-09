
<?php
$id = $user['id'];
$tipoPorA = $user['tipo'] == 'prof' ? 'professor' : 'agente';
$link = '../'.$tipoPorA.'/editar.php?id='.$id;

$infoMail = '';

$email = $user['email'];
$conta = explode('@', $email);
if ($conta[1] == 'unespar.edu.br') {
    $infoMail = '
    <div class="alert alert-info col">
        <p>Para conectar no sistema, agora você pode utilizar a senha do seu email.</p>
        <p>Conta: <strong>'.$email.'</strong></p>
        <p>Utilizando desta forma o sistema unificado de autenticação <strong>UNESPAR</strong></p>
        <p style="text-align:right;">Se quiser alterar a senha ↓</p>
        <a href="https://senha.unespar.edu.br/" class="btn btn-primary btn-sm float-right">Alterar senha</a>
    </div>
    ';
} else {
    $infoMail = '
    <div class="alert alert-warning col">
        <p><strong>Atenção!</strong></p>
        <p>Sua conta de conexão não pertence ao domínio <strong>unespar.edu.br</strong></p>
        <p>Conta: <strong>'.$email.'</strong></p>
        <a href="'.$link.'" ><img src="../imgs/chmail.png" alt="Como alterar"></a>

        <p>Favor altere-a para o seu email institucional: suaconta<strong>@unespar.edu.br</strong></p>
        <p>Caso não tenha solicite ao pessoal do TI do seu campus.</p>
        <p>Esta atitude atende a 
          <strong><a href="https://www.unespar.edu.br/a_reitoria/atos-oficiais/reitoria/resolucoes/2019/resolucao-006-2019-aprova-regulamento-uso-email-institucional.pdf" target="_blank">Resolução 006/2016</a> - Reitoria/UNESPAR - Sessão IV - Art. 17 Parágrafo único</strong> 
        </p>
    </div>
    ';
}

?>
<div class="container mt-3">
  
  <h3 class="mt-3">Informações</h3>
  
  <div class="container p-3 my-3 bg-white text-dark" style="padding : 25px">
    <div class="row">
      <div class="col-6">
        <p><a href="../projetos/index.php" class="btn btn-primary btn-sm">Meus projetos/propostas</a></p>
        
        
      
       
      </div>
      <div class="col">
        <?php echo $infoMail; ?>

      </div>
    </div>
     <p style="text-align: center;  padding-top : 70px;"><sup>
        <img class="XNo5Ab" src="data:image/png;base64,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" style="height:18px;width:18px" alt="" data-csiid="12" data-atf="1">UNESPAR<br>
          <span><span style="color: #002661;">PRO</span><span style="color: #007F3D;">EC</span></span></sup>
        </p>
  </div>
</div>
