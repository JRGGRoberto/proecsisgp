<main>
  <h2 class="mt-0">Consulta qryADM</h2>
  
  <section>

    <form method="POST">

      <div class="row my-2">

        <div class="col">
          <textarea name="qry" id="qry" rows="8" cols="120">

          </textarea>
        </div>
 
        <div class="col-1 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm mr-2">Exec</button>
        </div>


      </div>

    </form>
    <pre>
    <?php echo $resultado; ?>
    </pre>
  </section>



</main>


