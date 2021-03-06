<?php	
	error_reporting(E_ERROR | E_PARSE | E_NOTICE | E_WARNING);
	require_once('lib/init.php');
	//header("Access-Control-Allow-Origin: *");


	$guid = $_GET['design_id'];
	$design_folder_path = "../files/".$guid."/";
	$LAJS_folder_path = "../";
	$sources = "sources/";
	$files_to_zip = array();
	$log = "";

	//read saved design
	$file = file_get_contents($design_folder_path."design.json");
	if (get_magic_quotes_gpc()) {
		$design = stripslashes($file);
	} else {
        $design = $file;
	}
	$json = json_decode($design);


	// page body
	echo ('<!doctype html><html><body>');
	echo ('<link href="../assets/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet"/>');
	echo "<style>body {padding: 10px;} div.location > svg {position: relative !important;} div.location {height: 590px;float:left;width:590px;}</style>";
	//print guid
	echo ('<h1>Details for order #'.$guid.':</h1>');
	
	//print product name and color
	if (isset($json->data->product->name)) {
	    echo('<h4>Product: '.$json->data->product->name);
	    if (isset ($json->data->product->colorName)) {
	       echo(" (" . $json->data->product->colorName . ")" );
	    }
	    echo('</h4>');
	}

	$svg = "";
	//iterating design locations
	foreach($json->data->locations as $loc) {
		// Remove anything which isn't a word, whitespace, number
		// or any of the following caracters -_~,;:[]().
		$locname = preg_replace("([^\w\d\-_~,;:\[\]\(\).])", '', $loc->name);
		echo "<div class='location'>";
		echo "<div><b>Location: ".$loc->name."</b><br/>(<a href='".$design_folder_path."design_".$locname.".svg'>svg file</a>, <a href='".$design_folder_path."design_".$locname.".png'>gererated png</a>)</div>";
		
		/**
		*		SVG PARSING PART
		* 		1. read svg content
		*		2. update links to external images
		*		3. update viewBox (if needed)
		*		4. write svg file (and generated png)
		*		5. show file
		*/

		//1. read svg content
		$svg = $loc->svg;

		//matching pattern like xlink:href="url/files.ext" and href="url/files.ext" (MacOS Safari 8)
		$attrib = 'xlink:href';
		$attrib2 = 'href';
		$attribs = "(".preg_quote($attrib)."|".preg_quote($attrib2).")";
		$regexp = '/' . $attribs . '=([\'"]([^#].*?)["\'])/is';	
		
		//form list of all external images - $external_images_list
		preg_match_all($regexp, $svg, $external_images_list, PREG_PATTERN_ORDER);
		
		//create folder for external images (if not exist)
		if (!file_exists($design_folder_path.$sources)) {
			if (!mkdir($design_folder_path.$sources, 0777)) {
			    $log .= 'Failed to create folder $sources :('.'<br />';
			} else {
				$log .=  'Created directory '.$sources.'<br />';
			}
		}
		
		//2. update links to external images
		//iterating all external images
		for($i = 0; $i < count($external_images_list[3]); $i++) {
			//$external_images_list[3] - array of attr values, e.g. 'url/files.ext' (without xlink:href and quotes)
			$image_url_orig = $external_images_list[3][$i];
			//Skip css files
			if (strrpos($image_url_orig, ".css") == strlen($image_url_orig) - 4) 
				continue;
			
			//add link prefix to relative files (LAJS folder) - gallery images
			if (strpos($image_url_orig, "http") !== 0 ) {
				$image_url_full = $LAJS_folder_path.$image_url_orig;
			} else {
				//copy images with absolute url
				$image_url_full = $image_url_orig;
			}
		        $image_file_name = basename($image_url_orig);
		        
			if (strpos($image_file_name, 'getTextZ') !== false) {
				$image_file_name = 'getTextZ_'.uniqid().'.png';
				$image_url_full = str_replace("&amp;", "&", $image_url_full);
				$image_url_full = str_replace(" ", "%20", $image_url_full);
			}
			
			$image_url_destination = $design_folder_path.$sources.$image_file_name;
		        //copy all external images to $sources
			if (strlen($image_url_orig)) {
				if(!copy($image_url_full, $image_url_destination))
				{
				    $errors= error_get_last();
				    $log .=  "<b>COPY ERROR:</b> ".$errors['type'];
				    $log .=  "<br />\n".$errors['message'].'<br />';
				    //replace url to one from LAJS folder
				    $svg = str_replace($image_url_orig, $image_url_full, $svg);
				} else {
					//replace image url to one from $sources folder
				    $log .=  "<a href='$image_url_destination'>$image_url_orig</a> copied to $sources (".filesize($image_url_destination)."b)".'<br />';
				    $svg = str_replace($image_url_orig, $sources.$image_file_name.'" attr="u', $svg);
				    array_push($files_to_zip, $sources.$image_file_name);
				}
			}
		}
		
		//default svg dimensions
		$svgWidth = 587;
		$svgHeight = 543;
		$svgBox = [0, 0, $svgWidth, $svgHeight];
		//3. update viewBox based on editable area (if present. if not present - use default one)
		if (isset($loc->editableArea) && strlen($loc->editableArea) > 0) {
			//convert (string)$svg to (simpleXML)
			$xml = simplexml_load_string( $svg );
			
			$svgBox = explode(" ", $loc->editableArea);

			//update new svg dimensions
			$svgWidth = $svgBox[2] - $svgBox[0];
			$svgHeight = $svgBox[3] - $svgBox[1];
				
			//set new x,y attrs (for proper AI CS5 render) - but fails inkscape to png convertion with default options
			$xml['x'] = $svgBox[0];
			$xml['y'] = $svgBox[1];
			
			$xml['width'] = $svgWidth;
			$xml['height'] = $svgHeight;
			$xml['viewBox'] = $svgBox[0] . " " . $svgBox[1] . " " . $svgWidth . " " . $svgHeight;

			//convert (simpleXML)$xml back to string
			$svg = $xml->asXML();
		}

		//4. write files
		$filename = "design_".$locname.".svg";
		$fname_png = "design_".$locname.".png";
		$filename_full = $design_folder_path.$filename;
		//if (!file_exists($filename_full)) {
			$f = fopen($filename_full, "w");
			fwrite($f, $svg);
			fclose($f);
			array_push($files_to_zip, $filename);
			//exec("convert ".$filename_full." ".$design_folder_path.$fname_png); //ImageMagic
			exec("inkscape -e ".$design_folder_path.$fname_png." ".$filename_full." -a 0:0:".$svgWidth.":".$svgHeight);
		//}

		//5. load saved file with correct dimensions
		echo "<object type='image/svg+xml' data='".$filename_full."' width='".$svgWidth."' height='".$svgHeight."'></object>";
		
		/**
		*		END OF SVG PARSING PART
		*/

		echo "</div>";
	}

	$zip = new ZipArchive();
	$zip_filename = $design_folder_path.$guid.".zip";

	if ($zip->open($zip_filename, ZipArchive::CREATE)!==TRUE) {
	    exit("cannot open <$zip_filename>\n");
	}

	for($i = 0; $i < count($files_to_zip); ++$i) {
		$zip->addFile($design_folder_path.$files_to_zip[$i], $files_to_zip[$i]);
	}
	
	echo '<div class="well well-small" style="clear: both; margin: 20px 50px; 10px 50px;">';
	$log .= "Zip filename: " . $guid . ".zip" . " numfiles: " . $zip->numFiles . " status: " . $zip->status . "\n";
	$zip->close();
	
	echo "<a href='$zip_filename'><h4><i class='icon-download-alt'></i>download zip package</h4></a>";
	echo '<small>'.$log.'</small>';
	echo '<div/>';

	echo ('</body></html>');	
?>
