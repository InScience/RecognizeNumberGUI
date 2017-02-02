var $checkboxes = $(':checkbox');
$checkboxes.on('change', function(){
  $('.txt').toggle( $checkboxes.filter(':checked').length > 0 );
});