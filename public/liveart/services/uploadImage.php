<?php
	error_reporting(E_ERROR | E_PARSE);
	header("Access-Control-Allow-Origin: *");
	
	$absolute_path = "files/uploads/";
	$relative_path = "../files/uploads/";
	if (!is_dir($relative_path)) {
            mkdir($relative_path, 777, true);
	}

	//regular upload
	if (isset($_FILES["image"])) {
		$file = $_FILES["image"];		
		if(is_image($file)){
			$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
			$name = basename($file["name"], ".".$ext);
			$name = date("Ymd-His")."_".uniqid().".".$ext;	
			move_uploaded_file($file["tmp_name"], $relative_path.$name);
			$response["url"] = $absolute_path.$name;
		}else{
			$response = array('error' => array(
				'message' => 'Incorrect image type!'
			));
		};
		
		echo json_encode($response);
	};

	//upload by url
	if (isset($_POST['fileurl'])) {
		$response = array("url"=>"","error"=>false,"msg"=>"");
		if(is_image($_POST['fileurl'])){
			$url = $_POST['fileurl'];
			$name = basename($url);
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			$name = basename($name, ".".$ext);
			$name = date("Ymd-His")."_".uniqid().".".$ext;
			
			$upload = file_put_contents($relative_path.$name, file_get_contents($url));
			if ($upload) {
				$response["url"] = $absolute_path.$name;
			}else{
				$response = array('error' => array(
					'message' => 'Can\'t upload image from the URL'
				));
			}
		}else{
			$response = array('error' => array(
				'message' => 'Incorrect image type!'
			));
		};

		echo json_encode($response);
		
	};
	
	function is_image($file){
		if ($file["type"] == "image/svg+xml") {
			return true;
		}
		$path = $file["tmp_name"];
		$info = getimagesize($path);
		$image_type = $info[2];
		return in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP));
	}
	
	/* Image types - http://php.net/manual/en/image.constants.php
	
	[IMAGETYPE_GIF]
	[IMAGETYPE_JPEG] 
	[IMAGETYPE_PNG] 
	[IMAGETYPE_SWF] 
	[IMAGETYPE_PSD] 
	[IMAGETYPE_BMP] 
	[IMAGETYPE_TIFF_II] 
	[IMAGETYPE_TIFF_MM] 
	[IMAGETYPE_JPC]
	[IMAGETYPE_JP2] 
	[IMAGETYPE_JPX] 
	[IMAGETYPE_JB2]  
	[IMAGETYPE_SWC] 
	[IMAGETYPE_IFF] 
	[IMAGETYPE_WBMP]  
	[IMAGETYPE_JPEG2000]  
	[IMAGETYPE_XBM] 
	[IMAGETYPE_ICO] 
	[IMAGETYPE_UNKNOWN]  
	[IMAGETYPE_COUNT] 
	
	*/
?>
