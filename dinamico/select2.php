<!DOCTYPE html>
<html>
<body>
  <label for="estados">Estados</label>
  <select id="estados" required> 
  </select>

  <label for="cidades">Cidades</label>
  <select id="cidades" required >
  </select>


  <label for="ca">ca</label>
  <select id="ca" required >
  </select>

  <p id="demo"></p>

<script>
const ca = document.getElementById("ca");

jsona =  '[{"id":"1","nome":"Centro de Artes","updated_at":null,"user":null},{"id":"2","nome":"Centro de Ci\u00eancias da Sa\u00fade ","updated_at":null,"user":null},{"id":"3","nome":"Centro de Ci\u00eancias Exatas e Biol\u00f3gicas","updated_at":null,"user":null},{"id":"4","nome":"Centro de Ci\u00eancias Humanas e da Educa\u00e7\u00e3o","updated_at":null,"user":null},{"id":"5","nome":"Centro de Ci\u00eancias Humanas, Biol\u00f3gicas e da Educa\u00e7\u00e3o","updated_at":null,"user":null},{"id":"6","nome":"Centro de Ci\u00eancias Humanas, Educa\u00e7\u00e3o e Sa\u00fade","updated_at":null,"user":null},{"id":"7","nome":"Centro de Ci\u00eancias Sociais Aplicadas","updated_at":null,"user":null},{"id":"8","nome":"Centro de Exatas e Biol\u00f3gicas","updated_at":null,"user":null},{"id":"9","nome":"Centro de M\u00fasica ","updated_at":null,"user":null},{"id":"10","nome":"Centro de M\u00fasica e Musicoterapia","updated_at":null,"user":null}]';

//ca.innerHTML += `<option value=1">Teste1</option>`


const myArr = JSON.parse(jsona);
document.getElementById("demo").innerHTML = myArr[0].nome;


myArr.forEach(e=> {
  estados.innerHTML += `<option value="${e["id"]}">${e["nome"]}</option>`
 
});



</script>
  <script src="ccc.js"></script>


</body>
</html>