function fillVehicleEditFields(lic, brand, model, id, vid){
   //   	
	$('#editVehicle').modal();
	////$("#did").value(id)
	
	$("#vehicle_edit_licensenum").val(lic);
	$("#vehicle_edit_brand").val(brand);
	$("#vehicle_edit_model").val(model);
	$("#vehicle_owner1_owners").val(id);
        $("#vehicle_edit_vid").val(vid);
	console.log(lic, brand, model, id, vid);
      
}