document.getElementById("dateAssing").valueAsDate = new Date();

function submitSolicAlterac()
{
  const name = document.getElementById('resultado');
  name.value = 'r';
  document.myform.submit();
}

function submitSave()
{
  const name = document.getElementById('resultado');
  name.value = 'e';
  document.myform.submit();
}

function submitAprova()
{
  const name = document.getElementById('resultado');
  name.value = 'a';
  document.myform.submit();
}