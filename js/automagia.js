document.addEventListener("DOMContentLoaded", function(){
	var str="<button id=\"disBut\" aria-label=\"Mostra pagine regole\" title=\"Mostra pagine regole\" onclick=\"displayRegole()\">Regole ▼</button>";
	var obj=document.getElementById('disBut');
	if (obj.outerHTML){
		obj.outerHTML=str;
	}
});


function displayRegole(){
	var head=document.getElementsByClassName("nested");
	if(head[0].style.display=="block"){
		head[0].style.display="none";
		
	}
	else{
		head[0].style.display="block";
	}
}

function modT(trgt, val){
	if (trgt==1){
		if (val>0){
			var temp=parseInt((document.getElementById("T1")).innerHTML);
			temp+=val;
			document.getElementById("T1").textContent=temp;
		}
		else if (parseInt((document.getElementById("T1")).innerHTML)!=0){
			var temp=parseInt((document.getElementById("T1")).innerHTML);
			temp+=val;
			document.getElementById("T1").textContent=temp;
		}		
	}
	else{
		if (val>0){
			var temp=parseInt((document.getElementById("T2")).innerHTML);
			temp+=val;
			document.getElementById("T2").textContent=temp;
		}
		else if (parseInt((document.getElementById("T2")).innerHTML)!=0){
			var temp=parseInt((document.getElementById("T2")).innerHTML);
			temp+=val;
			document.getElementById("T2").textContent=temp;
		}		
	}
		
}

function setLP(trgt){
		var temp;
		var val;
		if(trgt==2){
			temp=document.getElementById("LP2");
			val=document.getElementById("imposta2").value || 0;
		}
		else{
			val=document.getElementById("imposta1").value || 0;
			temp=document.getElementById("LP1");
		}
		//addCheck per value
		temp.textContent=val;
}

function addLP(trgt){
		if(trgt==2){
			var val=parseInt(document.getElementById("cambia2").value || 0);
			var temp=document.getElementById("LP2");
			var initval=parseInt(temp.innerHTML);
			var finalval=val+initval;
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var addam=parseInt(val/250);
			if (addam<1){addam=1;}
			var countUp=setInterval(function() {
				initval+=addam;
				temp.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp); 
				temp.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
		else{
			var val=parseInt(document.getElementById("cambia1").value || 0);
			var temp=document.getElementById("LP1");
			var initval=parseInt(temp.innerHTML);
			var finalval=val+initval;
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var addam=parseInt(val/250);
			if (addam<1){addam=1;}
			var countUp=setInterval(function() {
				initval+=addam;
				temp.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp); 
				temp.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
}

function subLP(trgt){
		if(trgt==2){
			var val=parseInt(document.getElementById("cambia2").value);
			//imposta check e racchiudi il resto dentro
			var temp=document.getElementById("LP2");
			var initval=parseInt(temp.innerHTML);
			var finalval=initval-val;
			if (finalval<0){
				finalval=0;
				val=initval;
			}
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var subam=parseInt(val/250);
			if (subam<1){subam=1;}
			var countDown=setInterval(function() {
				initval-=subam;
				temp.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countDown); 
				temp.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
		else{
			var val=parseInt(document.getElementById("cambia1").value);
			var temp=document.getElementById("LP1");
			var initval=parseInt(temp.innerHTML);
			var finalval=initval-val;
			if (finalval<0){
				finalval=0;
				val=initval;
			}
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var subam=parseInt(val/250);
			if (subam<1){subam=1;}
			var countDown=setInterval(function() {
				initval-=subam;
				temp.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countDown); 
				temp.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
}

function rst(){
	document.getElementById("LP1").textContent=8000;
	document.getElementById("LP2").textContent=8000;
	document.getElementById("T1").textContent=0;
	document.getElementById("T2").textContent=0;
}

function d2(){
	var roll=Math.floor((Math.random()*2)+1);
	if (roll==1)
		document.getElementById("d2").textContent='Testa';
	else
		document.getElementById("d2").textContent='Croce';
}

function d6(){
	var roll=Math.floor((Math.random()*6)+1);
	document.getElementById("d6").textContent=roll;
}