<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
session_start();

?>

<?php include '../Inc/header.php';?>
<link rel="stylesheet" type="text/css" href="Style/index.css">
<div class="box">
   <P class="fbk">热&nbsp;门&nbsp;动&nbsp;态</P>
   <div class="zbk">
   	<?php
   		$link=connect();
   		$query="select * from bbs_content order by times desc limit 6";
   		$re=execute($link,$query);
   		while($roww=mysqli_fetch_assoc($re)){
   	?>		
   			<div class="box_hot"><span style="color:red">hot&nbsp;&nbsp;&nbsp;</span><a href="show.php?id=<?php echo "{$roww['id']}"?>"><?php echo "{$roww['title']}" ?>(<?php echo "{$roww['times']}" ?>)</a></div>
   	<?php		
   		}
   	?>
   </div>
</div>

<?php 

$link=connect();
$query="select * from bbs_fathermodule";
$result=execute($link, $query);
while($row=mysqli_fetch_assoc($result)){
?>

   <div class="box">
	   <p class="fbk"><a href="list_father.php?id=<?php echo "{$row['id']}"?>"><?php echo "{$row['name']}"?></a></p>
		 
	   <?php
	   $link=connect(); 
	   $sql="select * from  bbs_sonmodule where father_id={$row['id']}";
	   $res=execute($link, $sql);
	   while ($row=mysqli_fetch_assoc($res)){
        $query="select count(*) from bbs_content where module_id={$row['id']} and time> CURDATE()"; 
        $count=num($link, $query);
        $que="select count(*) from bbs_content where module_id={$row['id']}";
        $count_all=num($link, $que);
$html=<<<A
         <div class="childBox new">
			<h2><a href="list_son.php?id={$row['id']}">{$row['name']}</a> <span>(今日{$count}更新)</span></h2>
			帖子：{$count_all}<br />
		 </div>
A;
  echo $html;
	   	 
	   }
	   ?>
	   
   </div>
<?php }?>



<?php include '../Inc/footer.php';?>