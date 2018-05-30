<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/pagetools.inc.php';
session_start();

$link=connect();
$queryshow="select * from bbs_content where id={$_GET['id']}";
$reshow=execute($link, $queryshow);
$rowshow=mysqli_fetch_assoc($reshow);
$rowshow['title']=htmlspecialchars($rowshow['title']);
$rowshow['content']=nl2br($rowshow['content']);
if(!isset($_GET['id'])||! is_numeric($_GET['id'])||mysqli_num_rows($reshow)!=1){
	echo "<script>alert('参数提交错误，将返回首页')</script>";
	header("Refresh:3;url='index.php'");
}
$queread="update bbs_content set times=times+1 where id={$_GET['id']}";
execute($link, $queread);
$queson="select * from bbs_sonmodule where id={$rowshow['module_id']}";
$resson=execute($link, $queson);
$rowson=mysqli_fetch_assoc($resson);


$quefath="select * from bbs_fathermodule where id={$rowson['father_id']}";
$resfath=execute($link, $quefath);
$rowfath=mysqli_fetch_assoc($resfath);

$queuser="select * from user where id={$rowshow['user_id']}";
$resuser=execute($link, $queuser);
$rowuser=mysqli_fetch_assoc($resuser);

?>

<?php include '../Inc/header.php';?>

<link rel="stylesheet" type="text/css" href="Style/list_fether.css">
<link rel="stylesheet" type="text/css" href="Style/show.css">

<div class="content_top">
  <a href="Index.php">首&nbsp;页</a>&gt;<a href="list_father.php?id=<?php echo "{$rowfath['id']}"?>"><?php echo "{$rowfath['name']}"?></a>&gt;<a href="list_son.php?id=<?php echo "{$rowson['id']}"?>"><?php echo "{$rowson['name']}"?></a>&gt;<?php echo "{$rowshow['title']}"?>
</div>
<div class="show_yma">
  <?php 
  $quepy="select count(*) from bbs_reply where content_id={$_GET['id']}";
  $replyall=num($link, $quepy);
  $page_size=5;
  $data1=page($replyall,$page_size,5);
  echo $data1['html'];
  ?>
  <a href="reply.php?id=<?php echo "$_GET[id]"?>" class="show_reply">回复</a>
</div>
<?php 
   if(!isset($_GET['page'])||$_GET['page']==1){
?>
   	<div class="show_tz">
		<div class="touxiang">
		<a href="user.php?id=<?php echo "{$rowshow['user_id']}"?>"><img src=upload/<?php echo "{$rowuser['photo']}"?> style="width:150px;height:150px;" /></a><br />
		<span><?php echo "{$rowuser['name']}"?></span>
		   </div>
		   <div class="show_title">
		      <p class="cs"><?php echo "{$rowshow['title']}"?></p>
		      <p class="sl">阅读：<?php echo "{$rowshow['times']}"?>&nbsp;&nbsp;|&nbsp;&nbsp;回复： <?php echo "{$replyall}"?></p>
		   </div>
		   <div class="show_time">
		     <span class="show_time1">发布于：<?php echo "{$rowshow['time']}"?></span>
		     <span class="show_time2">楼主</span>
		   </div>
		   <div class="show_content">
		       <?php echo "{$rowshow['content']}"?>
		   </div>
		   <div style="clear:both;"></div>
	</div>
<?php 	
   }
?>

<?php 
$qrpy="select user.photo,user.name AS replyname,bbs_reply.quote_id,bbs_reply.user_id,bbs_reply.id,bbs_reply.reply_time,bbs_reply.reply_content from user,bbs_reply
		where user.id=bbs_reply.user_id and bbs_reply.content_id={$_GET['id']} order by bbs_reply.reply_time {$data1['limit']} ";
$rrpy=execute($link, $qrpy);
if(!empty($_GET['page'])){
	$i=($_GET['page']-1)*$page_size+1;
}

while($datarpy=mysqli_fetch_assoc($rrpy)){
      $datarpy['reply_content']=nl2br($datarpy['reply_content']);
?>
		<div class="show_tz">
			<div class="touxiang">
			<a href="user.php?id=<?php echo "{$datarpy['user_id']}"?>"><img src=upload/<?php echo "{$datarpy['photo']}"?> style="width:150px;height:150px;"><br /></a>
			<span><?php echo "{$datarpy['replyname']}"?></span>
			</div>
			<div class="show_time1111">
			<span class="show_time11">回复时间：<?php echo "{$datarpy['reply_time']}"?></span>
			<span class="show_time22"><?php echo $i++ ?>楼&nbsp;&nbsp;|&nbsp;&nbsp;<a href="quote.php?content_id=<?php echo $_GET['id']?>&reply_id=<?php echo "{$datarpy['id']}"?>">引用</a></span>
			</div>
			<div class="show_content">
			<?php 
			if($datarpy['quote_id']){
                 $query="select * from bbs_reply where content_id={$_GET['id']} and id={$datarpy['quote_id']}";
                 $rsss=execute($link, $query);
                 $rowww=mysqli_fetch_assoc($rsss);
                 
           ?>
		   <div class="yinyon"><?php echo "{$rowww['reply_content']}"?></div>
			<?php	
			}
			?>
			    
			<?php echo "{$datarpy['reply_content']}"?>
			</div>
			<div style="clear:both;"></div>
		</div>
<?php 		
}
?>










<?php include '../Inc/footer.php';?>