<?php 

/***
 * 
 *设置最大的上传文件大小  max_file_uploads = 20
 *
 *
 */
function upload($max_filesize){
	$phpini=ini_get('upload_max_filesize'); //配置的上传最大数2M
	$phpini_unit=strtoupper(substr($phpini, -1));  //获取单位 M  配置
	$phpini_number=substr($phpini, 0,-1); //获取数字   配置
	$multiple=get_multiple($phpini_unit);
	$phpini_getbyte=$phpini_number.$multiple;  //配置的 总字节数
	
	$max_filesize_unit=strtoupper(substr($max_filesize, -1));
	$max_filesize_number=substr($max_filesize_unit, 0,-1);
	$max_multiple=get_multiple($max_filesize_unit);
	$max_getbyte=$max_filesize_number*$max_multiple;
	
	if($phpini_getbyte<$max_getbyte){
		echo "上传文件大小不能大于配置文件的最大值";
	}
	

	
}

function get_multiple($unit){
	switch ($unit){
		case 'K':
			$multiple=1024;
			return $multiple;
		case 'M':
			$multiple=1024*1024*1024;
			return $multiple;
		case 'G':
			$multiple=1024*1024*1024;
			return $multiple;		
	}
}


upload("3M");



?>