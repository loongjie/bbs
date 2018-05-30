<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/pagetools.inc.php';
session_start();
$link=connect();
//查询子版块
$query_son="select * from bbs_sonmodule where id={$_GET['id']}";
$result_son=execute($link, $query_son);

if(!isset($_GET['id'])||mysqli_num_rows($result_son)!=1){
	echo "<script>alert('子版块不存在')</script>";
	header("Refresh:3;url='index.php'");
}
$res_listson=mysqli_fetch_assoc($result_son);

//查询父板块
$query_listfather="select * from bbs_fathermodule where id={$res_listson['father_id']}";
$result_listfather=execute($link, $query_listfather);
$res_listfather=mysqli_fetch_assoc($result_listfather);

//查询帖子

$query_listcontent="select count(*) from bbs_content where module_id={$_GET['id']}";
$query_listcontentnow="select count(*) from bbs_content where module_id={$_GET['id']} and time> CURDATE()";
$cccnow=execute($link, $query_listcontentnow);
$ccc=execute($link, $query_listcontent);
$call=mysqli_fetch_row($ccc);
$callnow=mysqli_fetch_row($cccnow);

?>

<?php include '../Inc/header.php';?>

<link rel="stylesheet" type="text/css" href="Style/list_fether.css">

<div class="content_top">
  <a href="Index.php">首&nbsp;页</a>&gt; <a href="list_father.php?id=<?php echo "{$res_listfather['id']}"?>"><?php echo "{$res_listfather['name']}"?></a> 
  &gt; <a href="list_son.php?id=<?php echo "{$res_listson['id']}"?>"><?php echo "{$res_listson['name']}"?> </a>
</div>

<div class="bigbox">

	<div class="content_left">
	  <div class="coontent_main">
	      <p class="mian_fbk"><?php echo "{$res_listson['name']}"?></p>
	      <p>今日：<?php echo "{$callnow[0]}" ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 总帖：<?php echo "{$call[0]}" ?></p>
	      <p>版主：暂无版主</p>
	      <p>enjoy the wonderful time now~~~~</p>
		  <div class="pages_wrap">
		     <a href="Post.php?son_id=<?php echo "{$res_listson['id']}"?>" class="page_post">发&nbsp;帖</a>
		     <div class="pages">
		     <?php 
		     
		       $page=page($call[0],5);
		       echo $page['html'];
		       
		     ?>
		     </div>
		     <div style="clear:both;"></div>
		  </div>
	
		  <?php 
   
		  $query_content1="select * from bbs_content where module_id={$_GET['id']} {$page['limit']}";
		  $res_content1=execute($link, $query_content1);
		  
		  
		  while($result_sontent1=mysqli_fetch_assoc($res_content1)){
		  	
                  $result_sontent1['title']=htmlspecialchars($result_sontent1['title']);
                  $queryname="select * from user where id={$result_sontent1['user_id']}";
                  $rrname=execute($link, $queryname);
                  //$dname=mysqli_affected_rows($link);
                  $dname=mysqli_fetch_assoc($rrname);

                  $quetime="select reply_time from bbs_reply where content_id={$result_sontent1['id']} order by id desc limit 1";
                  $restime=execute($link, $quetime);
                  $rowtime=mysqli_fetch_assoc($restime);
                  $time="";
                  if(mysqli_num_rows($restime)==0){
                  	$time="暂事没有回复";
                  }else{
                  	$time=$rowtime['reply_time'];
                  }
                   
                  $quu="select count(*) from bbs_reply where content_id={$result_sontent1['id']}";
                  $all=num($link, $quu);
		 ?> 	 
             <div class="post_content" >
                <a href="user.php?id=<?php echo "{$result_sontent1['user_id']}"?>"><img src=upload/<?php echo "{$dname['photo']}"?> width=45 height=45 /></a>				
				<div class="main">
				<div class="post_title"><a href="list_son.php?id=<?php echo "{$res_listson['id']}"?>">[<?php echo "{$res_listson['name']}"?>]</a>&nbsp;&nbsp;&nbsp;<a href="show.php?id=<?php echo"{$result_sontent1['id']}"?>"><span><?php echo"{$result_sontent1['title']}"?></span></a></div>
				<div class="poster">楼主：<?php echo"{$dname['name']}"?>&nbsp;&nbsp;&nbsp;<?php echo"{$result_sontent1['time']}"?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo "{$time}" ?></div>
				</div>
				<div class="browse">
				<p>浏览</p>
				<p><?php echo "{$result_sontent1['times']}"?></p>
				</div>
				<div class="browse">
				<p>回复</p>
				<p><?php echo "{$all}"?></p>
				</div>
			</div>

<?php 
		   }		 
?>	  <div style="clear:both;"></div>
	  </div>
	</div>
	
	<div class="content_right">
	
	  <div class="aa_title">板块列表</div> 
	  <ul>
	  <?php 
	    $query="select * from bbs_fathermodule";
	    $res=execute($link, $query);
	    while ($result=mysqli_fetch_assoc($res)) {
      ?>
	    	<li class="firstul">
				<a href="list_father.php?id=<?php echo "{$result['id']}"?>" style="font-weight: bold"><?php echo "{$result['name']}"?></a>
				<ul>
				<?php 
				$query="select * from bbs_sonmodule where father_id={$result['id']}";
				$ress=execute($link, $query);
				while($resultt=mysqli_fetch_assoc($ress)){
                ?>
                <li class="small"><a href="list_son.php?id=<?php echo "{$resultt['id']}"?>"><?php echo "{$resultt['name']}"?></a></li>
               <?php  	
				}
				?>
				
				</ul>
			</li>
	<?php 	
	    }   
	  ?>
	     
	  </ul>
	</div>

</div>

<?php include '../Inc/footer.php';?>

