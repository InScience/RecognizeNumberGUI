function EditSelectedOwner(){
var e = document.getElementById("vehicle_owner1_owners");
var strUser = e.options[e.selectedIndex].value;
console.log(strUser);


 $("#vehicle_edit_did").val(strUser);
 $("#vehicle_edit_save").click();
}