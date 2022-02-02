function like(idm) {
var idcount ="Like"+idm;
var idbutton="Button"+idm;
var button=document.getElementById(idbutton);

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){
  if (this.readyState == 4 && this.status == 200){
    //cose da fare con la risposta del server
    var response = this.responseText;
    switch(response){
      case "true":
        var aux = parseInt((document.getElementById(idcount)).innerHTML);
        aux --;
        document.getElementById(idcount).textContent=aux;
        button.className="notactv";
        button.ariaLabel="metti mi piace";
        break;
      case "false":
        var aux = parseInt((document.getElementById(idcount)).innerHTML);
        aux ++;
        document.getElementById(idcount).textContent=aux;
        button.className="actv";
        button.ariaLabel="togli mi piace";
        break;
      case "NL":
        break;
      case "dbErorr":
        break;
    }
  }
};
xmlhttp.open("GET","backend/addlike.php?idm="+idm, true);
xmlhttp.send();
};

function report(idm) {
var idreport="Report"+idm;
var report=document.getElementById(idreport);
var idbutton="ReportCount"+idm;
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){
  if (this.readyState == 4 && this.status == 200){
    //cose da fare con la risposta del server
    var response = this.responseText;
    switch(response){
      case "true":
	  var aux = parseInt((document.getElementById(idbutton)).innerHTML);
        aux --;
        document.getElementById(idbutton).textContent=aux;
        report.className="repnotactv";
        report.ariaLabel="segnala il post";
        break;
      case "false":
		aux = parseInt((document.getElementById(idbutton)).innerHTML);
        aux ++;
        document.getElementById(idbutton).textContent=aux;
        report.className="repactv";
        report.ariaLabel="rimuovi segnalazione";
        break;
      case "NL":
        break;
      case "dbErorr":
        break;
    }
  }
};
xmlhttp.open("GET","backend/addreport.php?idm="+idm, true);
xmlhttp.send();
};
