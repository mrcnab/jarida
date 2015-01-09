jQuery(document).ready(function($){
	
	$("#name").blur(validateName);
	$("#email").blur(validateEmail);
	$("#website").blur(validateWebsite);
	$("#message").blur(validateMessage);

	$("#contact").submit(function(){
		if(validateName() && validateEmail() && validateWebsite() && validateMessage()){
			return true;
		}else{
			return false;
		}
	});
	
	$("#reply").submit(function(){
		if(validateName() && validateEmail() && validateWebsite() && validateMessage()){
			return true;
		}else{
			return false;
		}
	});
	
	function validateName(){
		var a = $("#name").val();
		var b = $("#name").attr('aria-required');
		if(b && !a){
			$("#name").animate({"border-color":"#ffbfbf"},200);
			$("#name").animate({"background-color":"#ffe7e7"},200);
			return false;
		}
		else{
			$("#name").animate({"border-color":"#e0e0e0"},200);
			$("#name").animate({"background-color":"#fff"},200);
			return true;
		}
	}
	
	function validateEmail(){
		var a = $("#email").val();
		var b = $("#email").attr('aria-required');
		var filter = /^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/;
		if(b && !filter.test(a)){
			$("#email").animate({"border-color":"#ffbfbf"},200);
			$("#email").animate({"background-color":"#ffe7e7"},200);
			return false;
		}
		else{
			$("#email").animate({"border-color":"#e0e0e0"},200);
			$("#email").animate({"background-color":"#fff"},200);
			return true;
		}
	}
	
	function validateWebsite(){
		var a = $("#website").val();
		var b = $("#website").attr('aria-required');
		var filter = /^((https?|ftp)\:\/\/)?([a-z0-9]{1,})([a-z0-9-.]*)\.([a-z]{2,4})$/;
		if((!a && b) || (a && !filter.test(a))){
			$("#website").animate({"border-color":"#ffbfbf"},200);
			$("#website").animate({"background-color":"#ffe7e7"},200);
			return false;
		}
		else{
			$("#website").animate({"border-color":"#e0e0e0"},200);
			$("#website").animate({"background-color":"#fff"},200);
			return true;
		}
	}

	function validateMessage(){
		var a = $("#message").val();
		if(!a){
			$("#message").animate({"border-color":"#ffbfbf"},200);
			$("#message").animate({"background-color":"#ffe7e7"},200);
			return false;
		}else{			
			$("#message").animate({"border-color":"#e0e0e0"},200);
			$("#message").animate({"background-color":"#fff"},200);
			return true;
		}
	}
	
});