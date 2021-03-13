<?php



//print_r($_FILES);

$path     = getcwd() . DIRECTORY_SEPARATOR;
//$url      = dirname($_SERVER['PHP_SELF']) . '/';
$url = $_SERVER["REQUEST_SCHEME"] .'://my.cdn.lolyzf.cn/';
//$url = $_SERVER["REQUEST_SCHEME"] .'://'.$_SERVER['HTTP_HOST'] . '/';
//按照月份进行记录
$_time = date('Ym');
//用户是否是免费用户 免费用户free 付费用户pay_token
//$savePath = $path . '../../uploads/free/';
$savePath = $path . '../uploads/free/';
// 创建images 目录
if (!file_exists($savePath)) mkdir($savePath);
$savePath = $savePath . $_time.DIRECTORY_SEPARATOR;

// 创建月份 目录
if (!file_exists($savePath)) mkdir($savePath);

$saveURL  = $url . 'uploads/free/'.$_time.DIRECTORY_SEPARATOR;

$type=$_FILES['blob']['type'];

$success = 1; //默认上传成功
$message = ''; //错误信息
if($type = "png") {
	date_default_timezone_set('PRC');  //设置时区
                
    $date = date('H_i_s');
    $fileName = $date . "_" . mt_rand(10000, 99999).".png";
	$saveURL = $saveURL . $fileName;
	$location=$savePath.$fileName;
	
	if (!@move_uploaded_file($_FILES['blob']['tmp_name'], iconv("utf-8", "gbk", $location))){     
        $success = 0;	
		switch($_FILES['blob']["errors"])
		{
			
			case '0':
				$message = "文件上传成功";
				break;
			
			case '1':
				$message = "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
				break;
			
			case '2':
				$message = "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
				break;
			
			case '3':
				$message = "文件只有部分被上传";
				break;
			
			case '4':
				$message = "没有文件被上传";
				break;
			
			case '6':
				$message = "找不到临时目录";
				break;
			
			case '7':
				$message = "写文件到硬盘时出错";
				break;
			
			case '8':
				$message = "某个扩展停止了文件的上传";
				break;
			
			case '999':
			default:
				$message = "未知错误，请检查文件是否损坏、是否超大等原因。";
				break;
		}


	}
	
}


$array = array(
 'success' => $success,
 'message' => $message,
 'url' => $saveURL
);
            
 echo json_encode($array);

?>
