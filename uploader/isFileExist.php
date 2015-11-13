<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>查询文件</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>


<?PHP

require_once './oss_php_sdk_20150819/sdk.class.php';
require_once './oss_php_sdk_20150819/util/oss_util.class.php';

	$file = $_GET["file"];
	
	if ($file) {
	
		$endpoint = "oss.aliyuncs.com";
		$accessKeyId = "";
		$accesKeySecret = "";
		$bucket = "";

		$oss = new ALIOSS($accessKeyId, $accesKeySecret, $endpoint);

		$options = array();
		$res = $oss->get_object_meta($bucket, "/" . $file, $options);

		if ($res->isOk()){
			echo "文件 ". "http://-/" . $file . " 已存在！";
		}
		else {
			echo "文件 ". "http://-/" . $file . " 不存在！";
		}
	}
	else {
		echo "<p>参数错误！</p>";
	}
		
?>

</body>
</html>
