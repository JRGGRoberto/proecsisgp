$(document).ready(function () {
  /* --variables para llamar a los select por el id */
  let area1 = document.getElementById('area1')
  let provincia = document.getElementById('provincia')
  let distrito = document.getElementById('distrito')


  
  let a1 = document.getElementById('area1');
  a1.addEventListener("click", () => {
    cargarArea1()
    
  })
  



  function cargarArea1() {
      alert('ABCe');
      $.ajax({
          url: 'select.php',
          type: 'GET',
          success: function(response) {
              const area1s = JSON.parse(response);
              let template = '<option class="form-control" selected disabled>-- Seleccione --</option>'
  
              area1s.forEach(area1 => {
                  template += `<option class="form-control" value="${area1.id}">${area1.nome}</option>`;
              })

              $a1.innerHTML = template;
          }
      })
  }
  




  function cargarProvincias(sendDatos) {
      $.ajax({
          url: 'select.php',
          type: 'POST',
          data: sendDatos,
          success: function(response) {
              const respuestas = JSON.parse(response);
              let template = '<option class="form-control" selected disabled>-- Seleccione --</option>'
  
              respuestas.forEach(respuesta => {
                  template += `<option class="form-control" value="${respuesta.codProvincia}">${respuesta.nomProvincia}</option>`;
              })

              $provincia.innerHTML = template;
          }
      })
  }

  $a1.addEventListener('change', () => {
      alert('BB');
      const codarea1 = $area1.value

      const sendDatos = {
          'id': codarea1
      }
      
      cargarProvincias(sendDatos)

      $distrito.innerHTML = ''
  })

  function cargarDistritos(sendDatos) {
      $.ajax({
          url: 'select.php',
          type: 'POST',
          data: sendDatos,
          success: function(response) {
              const respuestas = JSON.parse(response);
              let template = '<option class="form-control" selected disabled>-- Seleccione --</option>'
  
              respuestas.forEach(respuesta => {
                  template += `<option class="form-control" value="${respuesta.codDistrito}">${respuesta.nomDistrito}</option>`;
              })

              $distrito.innerHTML = template;
          }
      })
  }
  $provincia.addEventListener('change', () => {
      const codProvincia = $provincia.value

      const sendDatos = {
          'codigoProv': codProvincia
      }
      
      cargarDistritos(sendDatos)
  })
})