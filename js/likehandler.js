function like(idm) {
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){
  if (this.readyState == 4 && this.status == 200){
    //cose da fare con la risposta del server
    var response = this.responseText;
    switch(response){
      case "true":
        //TODO : modifca bottone
        var aux = parseInt((document.getElementById(idm)).innerHTML);
        aux --;
        document.getElementById(idm).textContent=aux;
		document.getElementById(idm).className="notactv"
        break;
      case "false":
        //TODO : Modifica bottone
        var aux = parseInt((document.getElementById(idm)).innerHTML);
        aux ++;
        document.getElementById(idm).textContent=aux;
		document.getElementById(idm).className="actv"
        break;
      case "NL":
        break;
      case "dbErorr":
        break;
    }
  }
};
xmlhttp.open("GET","php/addlike.php?idm="+idm, true);
xmlhttp.send();
};

function report(idm) {
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){
  if (this.readyState == 4 && this.status == 200){
    //cose da fare con la risposta del server
    var response = this.responseText;
    switch(response){
      case "true":
        // TODO : modifca bottone
        break;
      case "false":
        // TODO : modifica bottone
        break;
      case "NL":
        break;
      case "dbErorr":
        break;
    }
  }
};
xmlhttp.open("GET","php/addreport.php?idm="+idm, true);
xmlhttp.send();
};
