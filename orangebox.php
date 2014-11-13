<?php
$my_img = imagecreate( 530, 100 );
$background = imagecolorallocate( $my_img, 237, 134, 0 );


imagepng( $my_img, "orangeimage.png" );

imagedestroy( $my_img );
?>