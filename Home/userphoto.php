<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';
session_start();


$link=connect(); 
$query="select photo from user where id={$_GET['id']}";
$res=execute($link, $query);
$row=mysqli_fetch_assoc($res);
?>
<?php include '../Inc/header.php';?>

<div class="maina" style="width: 80%;margin:0 auto;">
    <h2 style="color:red;">更改头像</h2>
    <hr />
    <div>
       <h4>原头像:</h4>
       <img src=upload/<?php echo "{$row['photo']}"?> />
    </div>
    <div>
      <form action="upload.php?id={$_GET['id']}" method="post" enctype="multipart/form-data">
         <input type="hidden" name="MAX_FILE_SIZE" value="100000">
         <input style="cursor: pointer;" width="100" type="file" name="the_file"><br /><br />
         <input type="submit" class="submit" value="上传更换头像" />
      </form>
    </div>
</div>

<?php include '../Inc/footer.php';?>