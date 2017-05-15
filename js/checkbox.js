window.onload = toggleSelect(); 

function check()
{
    
  var isChecked = document.getElementById("cbInvoicesAdd").checked;
  document.getElementById("formInvoicesAdd").disabled = !isChecked;
}