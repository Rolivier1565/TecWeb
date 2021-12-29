function displayRegole(){
	var temp=document.getElementsByClassName("nested");
	if(temp[0].style.display=="block"){
		temp[0].style.display="none";
	}
	else{
		temp[0].style.display="block";
	}
}