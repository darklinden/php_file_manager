<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>打包文件自动上传阿里云</title>
<link rel="stylesheet" href="../styles.css">
</head>
<body>


<?PHP

	date_default_timezone_set('PRC');

	echo "<div class=\"card\">\n";
	echo "<p><label class=\"text\">打包文件自动上传阿里云</label></p>";
	echo "<p><label class=\"text\">文件上传时会耗费较长时间，请耐心等待！</label></p>";
	echo "<p><label class=\"text\">文件上传时会耗费较长时间，请耐心等待！</label></p>";
	echo "<p><label class=\"text\">文件上传时会耗费较长时间，请耐心等待！</label></p>";
	echo "</div>";
	
	$del = $_GET["del"];
	
	if ($del) {
		unlink("../test/" . $del);
		header("Location: index.php");
	}
	
	echo "<div class=\"card\">\n";
    echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<p><label class=\"text\" for=\"file\">文件名:</label></p>";
	echo "<p><input class=\"text\" type=\"file\" name=\"file\" id=\"file\" /></p>";
	echo "<p><input class=\"text\" type=\"submit\" name=\"submit\" value=\"上传测试文件夹\" /></p>";
	echo "</form>";
	
	if ($_FILES["file"]) {
	
		if ($_FILES["file"]["error"] > 0)
		{
			echo "<p class=\"titlealert\">文件错误: " . $_FILES["file"]["error"] . "</p>";
		}
		else {
			if (file_exists($channelFolder . $_FILES["file"]["name"]))
			{
				echo $_FILES["file"]["name"] . " 文件已存在！ ";
			}
			else
			{
				$desFile = "../test/". $_FILES["file"]["name"];
				move_uploaded_file($_FILES["file"]["tmp_name"], $desFile);
				chmod($desFile, 0777);
			}
		}
	}
	echo "</div>";
		
    // output file list in HTML TABLE format
    function getFileList($dir) {
        // array to hold return value
        $retval = array();
        // add trailing slash if missing
        if (substr($dir, -1) != "/") $dir .= "/";
        
        // open pointer to directory and read list of files
        $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
        
        while(false !== ($entry = $d->read())) {
            // skip hidden files
            if($entry[0] == ".") continue;
            if(is_dir("$dir$entry")) {
                $retval[] = array(
                                  "name" => "$dir$entry/",
                                  "type" => filetype("$dir$entry"),
                                  "size" => 0,
                                  "lastmod" => filemtime("$dir$entry")
                                  );
            } elseif(is_readable("$dir$entry")) {
                $retval[] = array(
                                  "name" => "$dir$entry",
                                  "type" => mime_content_type("$dir$entry"),
                                  "size" => filesize("$dir$entry"),
                                  "lastmod" => filemtime("$dir$entry")
                                  );
            }
        }
        
        $d->close();
        return $retval;
    }
    
    $files = getFileList("../test/");
    
    function sortFileByDate($a, $b) {
		$da = date("Y-m-d H:i:s", $a['lastmod']);
		$db = date("Y-m-d H:i:s", $b['lastmod']);
		
		if ($da > $db) {
			return -1;
		}
		else {
			return 1;
		}
	}

	usort($files, "sortFileByDate");
	
    foreach ($files as $file) {
	    if (basename($file['name']) == "index.php") continue;
        echo "<div class=\"card\">\n";
        echo "<p class=\"text\"><a href=\"{$file['name']}\">", basename($file['name']),"</a></p>\n";
        echo "<p class=\"text\"><button onclick=\"checkAli('".basename($file['name'])."')\">文件是否存在阿里云</button><button onclick=\"uploadAli('".basename($file['name'])."')\">上传文件到阿里云</button></p>";
        echo "<p class=\"text\">最后修改时间: ", date("Y-m-d H:i:s", $file['lastmod']),"<button onclick=\"deleteFile('".basename($file['name'])."')\">删除文件</button></p>";
        echo "</div>";
    }
    
?>
    
<script>

function deleteFile(path) {

	if (window.confirm('你确定要删除 [' + path + '] 吗？')) {
	window.location.replace("index.php?&del=" + path);
		return true;
	}
}

function checkAli(path) {
	window.open("isFileExist.php?&file=" + path);
}

function uploadAli(path) {

	if (window.confirm('你确定要上传 [' + path + '] 吗？')) {
		window.open("upload.php?&file=" + path);
		return true;
	}
}

</script>

</body>
</html>
