
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
        <p><a href="../propostas/index.php" class="btn btn-primary btn-sm">Meus projetos/propostas</a></p>
        
        
        <p><a href="../propostas/projetos_all.php" class="btn btn-primary btn-sm">Todos os projetos/propostas</a></p>

        <?php echo $btnDashboard; ?>
       
      </div>
<!--      <div class="col">
        <?php // echo $infoMail;
        ?>

        <div class="alert alert-info col">
         <p>⚠️ Os <strong>módulos de relatórios</strong> encontram-se em manutenção.</p>  
        
        <a href="#" class="btn btn-warning  btn-sm float-right">Atenção</a>
    </div>-->

      </div>
    </div>
     <p style="text-align: center;  padding-top : 70px;"><sup>
        <img class="XNo5Ab" src="../imgs/logo_unespar.png" style="height:18px;width:18px" alt="" data-csIIId="12" data-atf="1">UNESPAR<br>
          <span><span style="color: #002661;">PRO</span><span style="color: #007F3D;">EC</span></span></sup>
        </p>
  </div>
</div>
