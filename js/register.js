function checkValid(){
	var ok=true;
	var pass=document.forms["regForm"]["password"].value;
	var passConf=document.forms["regForm"]["passwordRe"].value;
	var mail=document.forms["regForm"]["email"].value;
	var mailCheck=mail.search(/^([\w\-\+\.]+)@([\w\-\+\.]+).([\w\-\+\.]+)$/);
	if (pass!=passConf){
		ok=false;
		var temp=document.getElementById("wrongConf");
		temp.innerHTML="Attenzione: le due <span lang=\"en\">password</span> devono essere uguali";
	}
	else{
		var temp=document.getElementById("wrongConf");
		temp.innerHTML="";
	}
	if (mailCheck!=0){
		ok=false;
		var temp=document.getElementById("invEmail");
		temp.innerHTML="Attenzione: l'indirizzo <span lang=\"en\">mail</span> inserito non è valido";
	}
	else{
		var temp=document.getElementById("invEmail");
		temp.innerHTML="";
	}
	return ok;
}