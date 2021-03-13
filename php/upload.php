<?php

	/*
	 * PHP upload demo for Editor.md
     *
     * @FileName: upload.php
     * @Auther: Pandao
     * @E-mail: pandao@vip.qq.com
     * @CreateTime: 2015-02-13 23:20:04
     * @UpdateTime: 2015-02-14 14:52:50
     * Copyright@2015 Editor.md all right reserved.
	 */

    //header("Content-Type:application/json; charset=utf-8"); // Unsupport IE
    header("Content-Type:text/html; charset=utf-8");
    header("Access-Control-Allow-Origin: *");

    require("editormd.uploader.class.php");

    error_reporting(E_ALL & ~E_NOTICE);
	
	$path     = getcwd() . DIRECTORY_SEPARATOR;
	//$url      = dirname($_SERVER['PHP_SELF']) . '/';
	//$url = $_SERVER["REQUEST_SCHEME"] .'://'.$_SERVER['HTTP_HOST'] . '/';
	$url = $_SERVER["REQUEST_SCHEME"] .'://my.cdn.lolyzf.cn/';
	//按照月份进行记录
	$_time = date('Ym');
	//用户是否是免费用户 免费用户free 付费用户pay_token
    $savePath = $path . '../uploads/free/';
    // 创建images 目录
    if (!file_exists($savePath)) mkdir($savePath);
    $savePath = $savePath . $_time.DIRECTORY_SEPARATOR;

    // 创建月份 目录
    if (!file_exists($savePath)) mkdir($savePath);

    $saveURL  = $url . 'uploads/free/'.$_time.DIRECTORY_SEPARATOR;
	
	//var_dump($savePath);
	//var_dump($saveURL);

	$formats  = array(
		'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp')
	);

    $name = 'editormd-image-file';

    if (isset($_FILES[$name]))
    {        
        $imageUploader = new EditorMdUploader($savePath, $saveURL, $formats['image'],  1, 'H_i_s');  // Ymdhis表示按日期生成文件名，利用date()函数
        
        $imageUploader->config(array(
            'maxSize' => 1024,        // 允许上传的最大文件大小，以KB为单位，默认值为1024
            'cover'   => true         // 是否覆盖同名文件，默认为true
        ));
        
        if ($imageUploader->upload($name))
        {
            $imageUploader->message('上传成功！', 1);
        }
        else
        {
            $imageUploader->message('上传失败！', 0);
        }
    }
?>
