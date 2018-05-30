$(function(){



$(".loginname").blur(function(){
	checkname();
});

$(".loginpsw").blur(function(){
	checkpsw();
});

$(".loginvcode").blur(function(){
	checkvcode();
});



function checkname(){
	var check=false;
	var loginname=$(".loginname").val();
	if(!loginname){
		$(".loginname").next().html("*用户名不能为空").css("color","red");
	}else if(loginname.length>32){
		$(".loginname").next().html("*用户名长度不能超过32").css("color","red");
	}else{
		$.ajax({
			type:"POST",
			async: false,
			data:{loginname:loginname},
			url:"../Inc/loginVlidata.php",
			dataType:"json",
			success:function(data){
				if(data.status==1){
					$(".loginname").next().html(data.msg).css("color","red");
					check=true;
				}else{
					$(".loginname").next().html(data.msg).css("color","red");
				}
			}
		});
	}
	return check;
}

function checkpsw(){
	var check=false;
	var loginpsw=$(".loginpsw").val();
	var loginname=$(".loginname").val();
	if(!loginpsw){
		$(".loginpsw").next().html("*密码不能为空").css("color","red");
	}else if(loginpsw.length<6){
		$(".loginpsw").next().html("*密码不能小于6位").css("color","red");
	}else{
		$.ajax({
			type:"POST",
			async: false,
			data:{loginname:loginname,loginpsw:loginpsw},
			dataType:"json",
			url:"../Inc/loginpswVlidata.php",
			success:function(data){
				if(data.status==1){
					$(".loginpsw").next().html(data.msg).css("color","red");
				}else{
					$(".loginpsw").next().html(data.msg).css("color","red");
					check=true;
				}
			}
		});
	}
	return check;
}


function checkvcode(){
	var check=false;
	var vcode=$(".loginvcode").val();

	if(!vcode){
		$(".loginvcode").next().html("*验证码不能为空").css("color","red");
	}else{
		$.ajax({
			type:"POST",
			async: false,
			data:{vcode:vcode},
			url:"../Inc/vcodeCheck.php",
			dataType:"json",
			success:function(data){
			if(data.status==1){
				$(".loginvcode").next().html(data.msg).css("color","red");
				check=true;
			}else{
				$(".loginvcode").next().html(data.msg).css("color","red");
			}
			}
		});
	}
	return check;
}

$(".loginform").submit(function(){
	if(!(checkname() && checkpsw() && checkvcode())){
		return false;
	}
});












});