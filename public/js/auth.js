$("#cpass").on("blur",function(){
	if($(this).val()!=$("#pass").val())
	{
		$("#register_btn").attr("disabled",true);
	}

	else
		$("#register_btn").attr("disabled",false);

});

$("#pass").on("blur",function(){
	if($(this).val()!=$("#cpass").val())
	{
		$("#register_btn").attr("disabled",true);
	}

	else
		$("#register_btn").attr("disabled",false);

});