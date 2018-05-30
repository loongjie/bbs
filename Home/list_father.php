<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/pagetools.inc.php';
session_start();
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	echo "<script>alert('参数提交错误！！！')</script>";
	header("Refresh:3;url='Index.php'");
}
$link=connect();
$query_father="select * from bbs_fathermodule where id={$_GET['id']}";
$res_father=execute($link, $query_father);
if(mysqli_num_rows($res_father)==0){
	echo "<script>alert('不好意思，父板块不存在！！！')</script>";
	header("Refresh:3;url='Index.php'");
}
//$result_father代表父板块的资源
$result_father=mysqli_fetch_assoc($res_father);

//查询出父板块下的子版块
$query_son="select * from bbs_sonmodule where father_id={$_GET['id']}";
$res_son=execute($link, $query_son);
$count=0;
$count_all=0;
$name=null;
//查询父板块下的子版块ID

$id_son='';
while($result_son=mysqli_fetch_assoc($res_son)){
	$id_son.=$result_son['id'].",";
	$query="select count(*) from bbs_content where module_id={$result_son['id']} and time> CURDATE()";
	$count+=num($link, $query);
	$query="select count(*) from bbs_content where module_id={$result_son['id']}";
	$count_all+=num($link, $query);
	$name.=$result_son['name']."<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</span>";
}
$id_son=trim($id_son,',');
if($id_son==''){
	$id_son='-1';
}

?>

<?php include '../Inc/header.php';?>

<link rel="stylesheet" type="text/css" href="Style/list_fether.css">

<div class="content_top">
  <a href="Index.php">首&nbsp;页</a>&gt; <?php echo "{$result_father['name']}"?>
</div>

<div class="bigbox">

	<div class="content_left">
	  <div class="coontent_main">
	      <p class="mian_fbk"><?php echo "{$result_father['name']}"?></p>
	      <p>今日：<?php echo "{$count}"?>   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 总帖：<?php echo "{$count_all}"?></p>
	      <p>子板块：<?php echo "{$name}"?></p>
		  <div class="pages_wrap">
		     <a href="Post.php" class="page_post">发&nbsp;帖</a>
		     <div class="pages">
		     <?php 
		     
		       $page=page($count_all,5);
		       echo $page['html'];
		       
		     ?>
		     </div>
		     <div style="clear:both;"></div>
		  </div>
	
		  <?php 
   
		  $query_content="select bbs_sonmodule.name AS son_name,bbs_sonmodule.id AS sid,bbs_content.id,bbs_content.user_id,bbs_content.title,user.photo,user.name,bbs_content.time,bbs_content.times 
		                  from bbs_content,bbs_sonmodule,user where bbs_content.module_id in ({$id_son})
		                  and user.id=bbs_content.user_id
		                  and bbs_content.module_id=bbs_sonmodule.id {$page['limit']}";
		  $res_content=execute($link, $query_content);
		    
		  while($result_sontent=mysqli_fetch_assoc($res_content)){
                   $result_sontent['title']=htmlspecialchars($result_sontent['title']);
                   $quetime="select reply_time from bbs_reply where content_id={$result_sontent['id']} order by id desc limit 1";
                   $restime=execute($link, $quetime);
                   $rowtime=mysqli_fetch_assoc($restime);
                   $time="";
                   if(mysqli_num_rows($restime)==0){
                   	$time="暂事没有回复";
                   }else{              
                   	$time=$rowtime['reply_time'];
                   }
                   
                   $quu="select count(*) from bbs_reply where content_id={$result_sontent['id']}";
                   $all=num($link, $quu);
		 ?> 	 
             <div class="post_content" >
                <a href="user.php?id=<?php echo "{$result_sontent['user_id']}"?>">
                   <img src=upload/<?php echo "{$result_sontent['photo']}"?> width=45 height=45 />
                </a> 		
				<div class="main">
				<div class="post_title"><a href="list_son.php?id=<?php echo "{$result_sontent['sid']}" ?>">[<?php echo"{$result_sontent['son_name']}"?>]</a>&nbsp;&nbsp;&nbsp;<a href="show.php?id=<?php echo"{$result_sontent['id']}"?>"><span><?php echo"{$result_sontent['title']}"?></span></a></div>
				<div class="poster">楼主：<?php echo"{$result_sontent['name']}"?>&nbsp;&nbsp;&nbsp;<?php echo"{$result_sontent['time']}"?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo "{$time}" ?></div>
				</div>
				<div class="browse">
				<p>浏览</p>
				<p><?php echo "{$result_sontent['times']}"?></p>
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























