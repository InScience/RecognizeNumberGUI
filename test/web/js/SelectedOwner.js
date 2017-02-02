function CheckSelectedOwner(){
var e = document.getElementById("vehicle_owner_owners");
var strUser = e.options[e.selectedIndex].value;
console.log(strUser);
}