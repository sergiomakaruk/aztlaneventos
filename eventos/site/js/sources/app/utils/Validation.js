var Validation = {};

Validation.validate = function(form,callback){
	log(window.location);
form.find('.loading-form').hide();
form.submit (function(event) {
	event.preventDefault();
    if (form.valid())
    {
    	form.find('button').hide();
    	form.find('.loading-form').show();
    	callback(form.serializeObject());
    }
    event.preventDefault(); // stop form from redirecting to java servlet page
});
 var inputs = form.find('[validate]');
 
 if(window.location.host != 'localhost'){
	 var i;
	 inputs.each(function(){
		 i = $(this);
		 i.removeAttr('value');
		 i.val('');		 
	 });	 
 }
 
 var i,rule,r,msgs;
 r = {};
 msgs = {};
 inputs.each(function(){
	 i = $(this);	 
	 rule = {};	
	 rule.required = true;		 
	 if(i.attr('chars'))rule.minlength = i.attr('chars');
	 if(i.attr('validate')=='email')rule.email = true;
	 r[i.attr('name')] = rule;
	 if(i.attr('msg') !="")msgs[i.attr('name')] = i.attr('msg');
	 else  msgs[i.attr('name')] = "Este campo es requerido";
	
 });

	var obj = {
			//errorClass:'has-error',
	        // Specify the validation rules
	        rules: r,
	        // Specify the validation error messages
	        messages: msgs,
	        highlight: function(element) {
	            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	          },
	          success: function(element) {
	            element
	            .text('OK!').addClass('valid')
	            .closest('.form-group').removeClass('has-error').addClass('has-success');	           
	          }
	    }
	    
	    return obj;
}