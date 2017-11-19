$('body').ready(function(){
	
	
		$('#datetimepicker5').datetimepicker({
			pickTime: false
		});
		
		 $('input#switch-state').bootstrapSwitch();
		 $('input#switch-state-2').bootstrapSwitch();
		 $('input#switch-state-3').bootstrapSwitch();
		 $('input#switch-state-4').bootstrapSwitch();
		 
		 $('select[name="tipoEvento"]').change(function(){
			 console.log($(this).val());
			 if($(this).val() == 1){
				 $('#idYoutube').closest('.form-group').removeClass('hidden');
				 $('#link').closest('.form-group').removeClass('hidden');
			 }else{
				 $('#idYoutube').closest('.form-group').addClass('hidden');
				 $('#link').closest('.form-group').addClass('hidden');
			 }
		 });
	
	//console.log($('#datetimepicker5'));
});