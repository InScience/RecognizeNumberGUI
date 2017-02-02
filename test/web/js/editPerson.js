function filleditFields(vardas, pavarde, tel, adresas, id){
   //      		
	$('#editPerson').modal()
	////$("#did").value(id)
	$("#person_edit_name").val(vardas);
	$("#person_edit_surname").val(pavarde);
	$('#person_edit_phonenumber').val(tel);
	$("#person_edit_adress").val(adresas);
	$("#person_edit_did").val(id);
	console.log(vardas, pavarde, tel, adresas, id);
      
}