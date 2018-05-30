<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';
include_once '../Inc/pagetools.inc.php';
session_start();
$link=connect();
if(!$userid=is_login($link)){
	echo "<script>alert('你还没登录！')</script>";
}
if(!isset($_GET['id'])|| !is_numeric($_GET['id']) ){
	echo "<script>alert('参数提交不合法')</script>";
}
$query="select * from user where id={$_GET['id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
	echo "<script>alert('用户不存在')</script>";
}
$userrow=mysqli_fetch_assoc($result);
?>

<?php include '../Inc/header.php';?>
<link rel="stylesheet" type="text/css" href="Style/user.css">

<p class="user_top"><a href="Index.php">首&nbsp;&nbsp;页</a>&gt;<?php echo "{$userrow['name']}"?>的个人主页</p>
<div class="bigbigbox">
<?php 
$queryall="select count(*) from bbs_content where user_id={$_GET['id']}";
$all=num($link, $queryall);
$data=page($all,5);
?>
<div class="pageuser"><?php echo "{$data['html']}"?></div>
<div class="users">
<?php 
$querycon="select * from bbs_content where user_id={$_GET['id']} {$data['limit']}";
$rescon=execute($link, $querycon);
while($rowcon=mysqli_fetch_assoc($rescon)){
    $quetime="select reply_time from bbs_reply where content_id={$rowcon['id']} order by id desc limit 1";
    $rtime=execute($link, $quetime);
    $rowtime=mysqli_fetch_assoc($rtime);
    $time="";
    if($rowtime['reply_time']){
		$time=$rowtime['reply_time']; 	
    }else{
    	$time="暂时没有回复";
    }
    
    $qutimes="select count(*) from bbs_reply where content_id={$rowcon['id']}";
    $times=num($link, $qutimes);
?>

<div class="user_main">
	    <img src=upload/<?php echo "{$userrow['photo']}"?> />
	    <div class="user_title">
	       <p class="p1"><a href="show.php?id=<?php echo "{$rowcon['id']}"?>"><?php echo "{$rowcon['title']}"?></a></p>
	       <p>
	       <?php 
	        if($userid==$rowcon['user_id']){
           ?>
	        	<a href="../Inc/delete.php?id=<?php echo "{$rowcon['id']}"?>">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;
	       <?php 	
	        }
	       ?>
	       最后回复：<?php echo "{$time}"?>
	       </p>
	    </div>
	    <div class="a">
	        <p>浏览</p>
	        <p><?php echo "{$rowcon['times']}"?></p>
	    </div>
	    <div class="a">
	        <p>回复</p>
	        <p><?php echo "{$times}"?></p>
	    </div>
    </div>
    <div style="clear: both;"></div>
<?php 	
}
?>
    
</div>
<div class="user_photo">
  <a href="userphoto.php?id=<?php echo "{$userrow['id']}"?>"><img src=upload/<?php echo "{$userrow['photo']}"?> /></a><br/>
  <p><?php echo "{$userrow['name']}"?></p>
</div>
</div>
<?php include '../Inc/footer.php';?>