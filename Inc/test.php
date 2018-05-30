<?php



session_start();

require 'vcode.inc.php';

$_vc=new ValidateCode();

$_vc->doimg();
$_SESSION['authnum_session'] = $_vc->getCode();//验证码保存到SESSION中



?>