<?php

	//Leave all this stuff as it is
	date_default_timezone_set('EST');
	include 'GIFEncoder.class.php';
	include 'php52-fix.php';
	$time = $_GET['time'];
	$future_date = new DateTime(date('r',strtotime($time)));
	$time_now = time();
	$now = new DateTime(date('r', $time_now));
	$frames = array();	
	$delays = array();


	// Your image link
	$image = imagecreatefrompng('images/namik2.png');

	$delay = 100;// milliseconds

	$font = array(
		'size'=>19, // Font size, in pts usually.
		'angle'=>0, // Angle of the text
		'x-offset'=>140, // The larger the number the further the distance from the left hand side, 0 to align to the left.
		'y-offset'=>600, // The vertical alignment, trial and error between 20 and 60.
		'file'=>'./Futura.ttc', // Font path
		'color'=>imagecolorallocate($image, 255, 255, 255), // RGB Colour of the text
	);
	for($i = 0; $i <= 60; $i++){
		
		$interval = date_diff($future_date, $now);
		
		if($future_date < $now){
			// Open the first source image and add the text.
			$image = imagecreatefrompng('images/namik2.png');
			;
			$text = $interval->format('00:00:00:00');
			imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
			ob_start();
			imagegif($image);
			$frames[]=ob_get_contents();
			$delays[]=$delay;
			$loops = 1;
			ob_end_clean();
			break;
		} else {
			// Open the first source image and add the text.
			$image = imagecreatefrompng('images/namik2.png');
			;
			$text = $interval->format(	'Holiday Party Countdown:
   Days  Hrs  Min  Sec
    %a     %H   %I    %S');
			imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
			ob_start();
			imagegif($image);
			$frames[]=ob_get_contents();
			$delays[]=$delay;
			$loops = 0;
			ob_end_clean();
		}

		$now->modify('+1 second');
	}

	//expire this image instantly
	header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', false );
	header( 'Pragma: no-cache' );
	$gif = new AnimatedGif($frames,$delays,$loops);
	$gif->display();