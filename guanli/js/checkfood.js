function selectBox(selectType){
var checkboxis = document.getElementsByName("delid[]");
if(selectType == "reverse"){
	for (var i=0; i<checkboxis.length; i++){
		//alert(checkboxis[i].checked);
		checkboxis[i].checked = !checkboxis[i].checked;
	}
}
else if(selectType == "all")
{
	for (var i=0; i<checkboxis.length; i++){
		//alert(checkboxis[i].checked);
		checkboxis[i].checked = true;
	}
}
}