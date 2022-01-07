
function displayRegole(){
	var head=document.getElementsByClassName("nested");
	if(head[0].style.display=="block"){
		head[0].style.display="none";
		
	}
	else{
		head[0].style.display="block";
	}
}

function setLP(){
	
	if (document.querySelector("input[name='bersaglio']:checked")!=null){	//Controlla che il radio abbia una opzione selezionata
		var tgt=document.querySelector("input[name='bersaglio']:checked").value;
		var val=document.getElementById("imposta").value || 0;
		var temp1=document.getElementById("LP1");
		var temp2=document.getElementById("LP2");
		if(tgt==3){
			temp1.textContent=val;
			temp2.textContent=val;
		}
		else if(tgt==2){
			temp2.textContent=val;
		}
		else if(tgt==1){
			temp1.textContent=val;
		}
	}
}

function addLP(){
	if (document.querySelector("input[name='bersaglio']:checked")!=null){	//Controlla che il radio abbia una opzione selezionata
		var tgt=document.querySelector("input[name='bersaglio']:checked").value;
		var val=parseInt(document.getElementById("cambia").value || 0);
		var temp1=document.getElementById("LP1");
		var temp2=document.getElementById("LP2");
		if(tgt==3){
			var initval1=parseInt(temp1.innerHTML);		//calcola valore iniziale
			var finalval1=val+initval1;	//calcola valore finale
			var initval2=parseInt(temp2.innerHTML);
			var finalval2=val+initval2;
			
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var addam=parseInt(val/250);
			if (addam<1){addam=1;}
			var countUp=setInterval(function() {
				initval1+=addam;
				initval2+=addam;
				temp1.textContent=initval1;
				temp2.textContent=initval2;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp);
				temp1.textContent=finalval1; //imposta valore finali
				temp2.textContent=finalval2;
				clearInterval(stopCount);
			}, 1010);
			
			
		}
		else if(tgt==2){
			var initval=parseInt(temp2.innerHTML);
			var finalval=val+initval;
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var addam=parseInt(val/250);
			if (addam<1){addam=1;}
			var countUp=setInterval(function() {
				initval+=addam;
				temp2.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp); 
				temp2.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
		else if(tgt==1){
			var initval=parseInt(temp1.innerHTML);
			var finalval=val+initval;
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var addam=parseInt(val/250);
			if (addam<1){addam=1;}
			var countUp=setInterval(function() {
				initval+=addam;
				temp1.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp); 
				temp1.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
	}
}

function subLP(){
	if (document.querySelector("input[name='bersaglio']:checked")!=null){	//Controlla che il radio abbia una opzione selezionata
		var tgt=document.querySelector("input[name='bersaglio']:checked").value;
		var val=parseInt(document.getElementById("cambia").value || 0);
		var temp1=document.getElementById("LP1");
		var temp2=document.getElementById("LP2");
		if(tgt==3){
			var valdup=val;
			var initval1=parseInt(temp1.innerHTML);		//calcola valore iniziale
			var finalval1=initval1-val;	//calcola valore finale
			var initval2=parseInt(temp2.innerHTML);
			var finalval2=initval2-valdup;
			if (finalval1<0){
				finalval1=0;
				val=initval1;
			}
			if (finalval2<0){
				finalval2=0;
				valdup=initval2;
			}
			
			var incdelay1=1000/val;				//calcola ogni quanto aggiornare il contatore
			var incdelay2=1000/valdup;
			var subam1=parseInt(val/250);
			var subam2=parseInt(valdup/250);
			if (subam1<1){subam1=1;}
			if (subam2<1){subam2=1;}
			var countDown1=setInterval(function() {
				initval1-=subam1;
				temp1.textContent=initval1;
				;
			}, incdelay1);
			var countDown2=setInterval(function() {
				initval2-=subam2;
				temp2.textContent=initval2;
			}, incdelay2);
			var stopCount=setInterval(function(){
				clearInterval(countDown1);
				clearInterval(countDown2);
				temp1.textContent=finalval1; //imposta valore finale
				temp2.textContent=finalval2;
				clearInterval(stopCount);
			}, 1010);
			
			
		}
		else if(tgt==2){
			var initval=parseInt(temp2.innerHTML);
			var finalval=initval-val;
			if (finalval<0){
				finalval=0;
				val=initval;
			}
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var subam=parseInt(val/250);
			if (subam<1){subam=1;}
			var countUp=setInterval(function() {
				initval-=subam;
				temp2.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp); 
				temp2.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
		else if(tgt==1){
			var initval=parseInt(temp1.innerHTML);
			var finalval=initval-val;
			if (finalval<0){
				finalval=0;
				val=initval;
			}
			var incdelay=1000/val;		//calcola ogni quanto aggiornare il contatore
			var subam=parseInt(val/250);
			if (subam<1){subam=1;}
			var countUp=setInterval(function() {
				initval-=subam;
				temp1.textContent=initval;
			}, incdelay);
			var stopCount=setInterval(function(){
				clearInterval(countUp); 
				temp1.textContent=finalval; //imposta valore finale
				clearInterval(stopCount);
			}, 1010);
		}
	}
}