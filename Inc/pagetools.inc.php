<?php 

/*
 * 1.输出limit限制条件
 *   limit (第几条开始，几条记录)
 * 2.输出html语句
 * 
 * 
 * array $data($limit,$html)
 * 
 * */

function page($count_all,$page_size=3,$shownumber_page=3,$page='page'){
	
	if($count_all==0){
		$data=array(
				'limit' => '',
				'html'  => ''
		);
		
		return $data;
	}
	
	//输出limit限制条件
	if(!isset($_GET[$page])||!is_numeric($_GET[$page])||$_GET[$page]<1){
		$_GET[$page]=1;
	}
	
	$page_all=ceil($count_all/$page_size);
	
	if($_GET[$page]>=$page_all){
		$_GET[$page]=$page_all;
	}
	
	$start=($_GET[$page]-1)*$page_size;
	$limit="limit $start,$page_size";
	
	
	//现在url地址是写死的，需要设置动态的url地址
	
	$current_url=$_SERVER['REQUEST_URI'];  //当前的url地址
	$url_array=parse_url($current_url);
	//当前的url的path部分与参数部分
	$current_path=$url_array['path'];
//	$current_query=$url_array['query'];
	$url='';
	if(isset($url_array['query'])){
		parse_str($url_array['query'],$arr_query);
		unset($arr_query[$page]);
		if(empty($arr_query)){
			$url="{$current_path}?{$page}=";
		}else{
			$other=http_build_query($arr_query);
			$url="{$current_path}?{$other}&{$page}=";
		}
	}else{
		$url="{$current_path}?{$page}=";
	}
	
	
	//根据要显示的页码数，输出html语句
	$html='';
	if($_GET[$page]>1){
		$pre=$_GET[$page]-1;
		$last="<a href='{$url}{$pre}'><<上一页</a>";
		//substr_replace($html, $last, 0,0);
		$html.=$last;
	}
	if($shownumber_page>=$page_all){
		for($i=1;$i<$page_all;$i++){
			if($i==$_GET[$page]){
				$html.="<span>{$i}</span>";
			}else{
				$html.="<a href='{$url}{$i}'>{$i} </a> ";
			}
			
		}
	}
	
	if($shownumber_page<$page_all){
		//知道最左边的页码数就可以了
		$num_left=floor(($shownumber_page-1)/2);
		$start=$_GET[$page]-$num_left;
		//左边的页码不能小与1
		if($start<1){
			$start=1;
		}
		//最右的页吗不能大于最大页码数
		$end=$start+$shownumber_page-1;
		if($end>$page_all){
			$start=$page_all-$shownumber_page+1;
		}
		//把要显示的页码显示出来
		for($i=0;$i<$shownumber_page;$i++){
			if($_GET[$page]==$start){
				$html.="<span>{$start}</span>";
			}else{
				$html.="<a href='{$url}{$start}'>{$start} </a>";
			}
			$start++;
		}
	}
	
	if($_GET[$page]!=$page_all){
		$next1=($_GET[$page]+1);
		$next="<a href='{$url}{$next1}'>下一页>></a>";
		$html.=$next;
	}
	

	
    
	$data=array(
		'limit' => $limit,
		'html'  => $html
	);
	
	return $data;
}

//$data=page(3,1);

//echo $data['limit'];
//echo $data['html'];


?>