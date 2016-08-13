function($,W,D)
{
	var JQUERY4U={};
	
	JQUERY4U.UTIL =
	{
		setupFormValidation: function(){
			$("#formvalidate").validate({
				rules: {
					fname: {
						required: true
						minlength: 2
					},
					lname: {
						required: true
						minlength: 2
					},
					
					mname: {
						required: true
						minlenght: 2					
				},
				agree: "required"
				},
				messages: {
					fname: "Please enter your name.",
					lname: "Please enter your lname.",
					mname: "please enter your mname.",
					
				},
				submitHandler:function(form){
					form.submit();
					
				}
			}),
			
			$("#formvalidate").ready(function($){
				JQUERY4U.UTIL.setupFormValidation();
			}
		}
	}	
}