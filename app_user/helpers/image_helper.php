<?php

function scale_image($image, $target, $thumbnail_width, $thumbnail_height)
{
	if(!empty($image)) # the image to be uploaded is a JPG I already checked this
	{
		$image_ext = pathinfo($image);	
		#print_r($image_ext);
		list($width_orig, $height_orig) = getimagesize($image);
		switch(strtolower($image_ext['extension'])){
			case 'jpg':
			case 'jpeg':
					$myImage = imagecreatefromjpeg($image);
				break;
			case 'png':
					$myImage = imagecreatefrompng($image);
				break;
			case 'gif':
					$myImage = imagecreatefromgif($image);
				break;	
		}
	
		$ratio_orig = $width_orig/$height_orig;
		#echo $ratio_orig;
		if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
			$new_height = $thumbnail_width/$ratio_orig;
			$new_width = $thumbnail_width;
		} else {
			$new_width = $thumbnail_height*$ratio_orig;
			$new_height = $thumbnail_height;
		}
	
		$x_mid = $new_width/2;  # horizontal middle
		$y_mid = $new_height/2; # vertical middle
	
		$process = imagecreatetruecolor(round($new_width), round($new_height)); 
		# this is needed for png with transparent background
		imagealphablending($process, false);
		imagesavealpha($process,true);
		# png with transparent bg
		imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
	
	
		$thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		imagealphablending($thumb, false);
		imagesavealpha($thumb,true);
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
	
	
		switch(strtolower($image_ext['extension'])){
			case 'jpg':
			case 'jpeg':
					imagejpeg($thumb,$target, 100);
				break;
			case 'png':
					imagepng($thumb,$target, 0);
				break;
			case 'gif':
					imagegif($thumb,$target, 100);
				break;	
		}
		imagedestroy($process);
		imagedestroy($myImage);	
	}
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */