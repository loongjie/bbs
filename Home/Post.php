<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';
session_start();
$link=connect();

//登陆之后才可以发帖
if(!$flag=is_login($link)){
	echo "<script>alert('登陆之后方可发帖')</script>";
}

if(isset($_POST['submit'])){
	$link=connect();
	include_once '../Inc/PostCheck.php';
	$query="insert into bbs_content(module_id,title,content,time,user_id) values({$_POST['checkban']},'{$_POST['title']}','{$_POST['content']}',now(),{$flag})";
	$result=execute($link, $query); 
	if(mysqli_affected_rows($link)==1){
		echo "<script>alert('帖子发布成功！！！')</script>";
		header("Refresh:3;url='index.php'");
	}else{
		echo "<script>alert('帖子发布失败！！！')</script>";
	}
}




?>

<?php include '../Inc/header.php';?>

<link rel="stylesheet" type="text/css" href="Style/post.css">
<div class="post_header">
  <a href="Index.php">首页</a> &gt; 发布帖子
</div>

<div class="post_content">
   <form method="post">
      <select name="checkban">
        
         <?php 
         $query="select * from bbs_fathermodule";
         $res=execute($link, $query);
         while($row=mysqli_fetch_assoc($res)){
         	echo "<optgroup label='{$row['name']}'>";
         	$quer1y="select * from bbs_sonmodule where father_id='{$row['id']}'";
         	$re1sult=execute($link, $quer1y);
         	while($r1ow=mysqli_fetch_assoc($re1sult)){
                if(isset($_GET['son_id'])&& $_GET['son_id']==$r1ow['id'] ){
                	echo "<option selected='selected' value='{$r1ow['id']}'>{$r1ow['name']}</option>";
                }else{
                	echo "<option value='{$r1ow['id']}'>{$r1ow['name']}</option>";
                }
         		
         	}
         	echo "</optgroup>";
         }
         ?>
      </select>
      <input type="text" class="title" name="title" placeholder="请输入标题"/>
      <textarea name="content" class="content"></textarea>
      <input type="submit" name="submit" value="发布帖子" class="submit" />
      <div style="clear:both;"></div>
   </form>
</div>


<?php include '../Inc/footer.php';?>