function AddSelectedOwner(){
var e = document.getElementById("vehicle_owner_owners");
var strUser = e.options[e.selectedIndex].value;
console.log(strUser);


 $("#vehicle_did").val(strUser);
 $("#vehicle_save").click();
}