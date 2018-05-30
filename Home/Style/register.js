$(function(){


$("#username").blur(function(){
	checkname();
});

$("#psw").blur(function(){
	checkpsw();
});

$("#mpsw").blur(function(){
	checkmpsw();
})

$("#vcode").blur(function(){
	checkvcode();
})


function checkname(){
	var check=false;
	var username=$.trim($("#username").val());
	var cname=$("#username");

	if(typeof(username)=="undefined" || !username){
		cname.next().html("*用户名不能为空").css("color","red");
	}else if((username.length)>32){
		cname.next().html("*用户名长度不能超过32").css("color","red");
	}else{
		$.ajax({
		type:"POST",
		async: false,
		data:{username:username},
		url:"../Inc/nameCheck.php",
		dataType:"json",
		success:function(data){
			if(data.status==1){
				cname.next().html(data.msg).css("color","red");
			}else{
				cname.next().html(data.msg).css("color","red");	
				check=true;		
			}
		}
	});
	}
	return check;
}


function checkpsw(){
	var check=false;
	var psw=$.trim($("#psw").val());
	var cpsw=$("#psw");
	if(typeof(psw)=="undefined" || !psw){
		cpsw.next().html("*密码不能为空").css("color","red");
		
	}else if(psw.length<6){
		cpsw.next().html("*密码不能小于6位").css("color","red");
	}else{
		cpsw.next().html("*ok").css("color","red");
		check=true;
	}

	return check;
}


function checkmpsw(){
	var check=false;
	var mpsw=$.trim($("#mpsw").val());
	var cmpsw=$("#mpsw");
	var psw=$.trim($("#psw").val());

	if(typeof(mpsw)=="undefined" || !mpsw){
		cmpsw.next().html("*密码不能为空").css("color","red");
	}else if(psw!=mpsw){
		cmpsw.next().html("*两次密码不一致").css("color","red");
	}else{
		cmpsw.next().html("*ok").css("color","red");
		check=true;
	}
	return check;
}



function checkvcode(){
	var check=false;
	var vcode=$.trim($("#vcode").val());
	var cvode=$("#vcode");

	if(typeof(vcode)=="undefined" || !vcode){
		cvode.next().html("验证码不能为空").css("color","red");
	}
	$.ajax({
		type:"POST",
		async: false,
		data:{vcode:vcode},
		url:"../Inc/vcodeCheck.php",
		dataType:"json",
		success:function(data){
			if(data.status==1){
				cvode.next().html(data.msg).css("color","red");
				check=true;
			}else{
				cvode.next().html(data.msg).css("color","red");
				check=true;
			}
		}
	});
	return check;
}

	
$("#form").submit(function(){
	if(!(checkname() && checkpsw() && checkmpsw() && checkvcode())){
		return false;
	}
});



});