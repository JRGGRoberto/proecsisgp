<?php
use \App\Session\Login;
Login::requireLogin();
$user = Login::getUsuarioLogado();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<main>

  <h2 class="mt-3"><?=TITLE?></h2>
  <a class="card-link" href="../ajuda/?help=perfil" aria-expanded="true"><span class="badge badge-warning float-right" hidden>Ajuda</span></a>
  <hr>

  <form method="post" id="formprof">
    
    <div class="row">
                          
      <div class="col-8">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" class="form-control" name="nome" maxlength="60"  value="<?=$obProfessor->nome?>" readonly>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label hidden >Titulação</label>
          <input  hidden type="text" class="form-control" value=""  readonly>

        </div>
      </div>

    </div>


    <div class="row">
      <div class="col-2">
        <div class="form-group">
          <label for="ca">Campus</label>
          <input type="text" class="form-control" value="<?=$obProfessor->campus?>" readonly>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group">
          <label for="ce">Centro</label>
          <input type="text" class="form-control" value="<?=$obProfessor->codcentro?>" readonly>
        </div> 
      </div>

      <div class="col-7">
        <div class="form-group">
          <label for="co">Colegiado</label>
          <input type="text" class="form-control" value="<?=$obProfessor->colegiado?>" readonly>
        </div> 
      </div>
      
    </div>


    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <label for="ca1">Titulacao</label>
          <input type="text" class="form-control" value="<?=$obProfessor->titulacao?>" readonly>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group">
          <label for="ce1">Data de obtenção do título 	</label>
          <input type="date" name="dt_obtn_tit" class="form-control" value="<?=date_format(new DateTime( $vinculo->dt_obtn_tit ), 'Y-m-d'); ?>"  <?= $readonly ?> >
          
        </div> 
      </div>
      

      <div class="col">
        <div class="form-group">
          <label for="ca1">Tempo de docência nos componentes curriculares</label>
          <input type="text" class="form-control" name="tempo_cc" value="<?=$vinculo->tempo_cc?>" maxlength="20"  <?= $readonly ?>>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-7">
        <div class="form-group">
          <label >Área de concurso </label>
          <input type="text" class="form-control" name="area_concurso" value="<?=$vinculo->area_concurso?>" maxlength="100" <?= $readonly ?>>
        </div>
      </div>



      <div class="col">
        <div class="form-group">
          <label >Tempo efetivo de docência no ensino superior na UNESPAR</label>
          <input type="text" class="form-control" name="tempo_esu" value="<?=$vinculo->tempo_esu?>" maxlength="20" <?= $readonly ?>>
        </div>
      </div>
    </div>
    <div class="form-group">
        <label >Regime de trabalho</label>
        <select name="rt" id="rt" class="form-control" required="" <?= $readonly ?> >
          <option>Selecione</option>
          <option value="TIDE" <?= $vinculo->rt == 'TIDE' ? 'selected' : '' ?> >TIDE</option>
          <option value="40"   <?= $vinculo->rt == 40     ? 'selected' : '' ?> >40</option>
          <option value="24"   <?= $vinculo->rt == 24     ? 'selected' : '' ?> >24</option>
          <option value="20"   <?= $vinculo->rt == 20     ? 'selected' : '' ?> >20</option>
          <option value="10"   <?= $vinculo->rt == 10     ? 'selected' : '' ?> >10</option>
        </select>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button>
      <button type="reset" class="btn btn-success">Limpar</button>
    </div>

  </form>
</main>
