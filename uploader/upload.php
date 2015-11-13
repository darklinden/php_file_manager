<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>上传文件</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="card">
<?PHP

require_once './oss_php_sdk_20150819/sdk.class.php';
require_once './oss_php_sdk_20150819/util/oss_util.class.php';

	$folder = "/Library/WebServer/Documents/test";
	$file = $_GET["file"];
	
	if ($file) {
	
		$file_path = $folder . "/" . $file;
		
		if (is_file($file_path)) {
			$endpoint = "oss.aliyuncs.com";
			$accessKeyId = "";
			$accesKeySecret = "";
			$bucket = "";
			$oss = new ALIOSS($accessKeyId, $accesKeySecret, $endpoint);

			$object = "-/" . $file;

			$options = array();
			$res = $oss->upload_file_by_file($bucket, $object, $file_path, $options);
		
			if ($res->isOk()){
				echo "<p class=\"text\">上传文件 \"http://-/" . $file . "\" 成功！</p>";
			}
			else {
				echo "<p class=\"text\">上传 \"http://-/" . $file . "\" 失败！</p>";
			}		
		}
		else {
			echo "<p class=\"text\">文件\"" . $file_path . "\"未找到！</p>";
		}
	}
	else {
		echo "<p class=\"text\">参数错误！</p>";
	}
		
?>
</div>
</body>
</html>
