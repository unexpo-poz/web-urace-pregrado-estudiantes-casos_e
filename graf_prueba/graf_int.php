<?php
session_start();
$tabx= array();
$ideal = array();
$ideal[2] = array(75/5,90/5,85/5,85/5,55/5,25/5,25/5,10/5,40/5,45/5);
$ideal[3] = array(75/5,75/5,85/5,85/5,50/5,30/5,25/5,15/5,40/5,40/5);
$ideal[4] = array(80/5,90/5,85/5,90/5,50/5,25/5,25/5,10/5,40/5,40/5);
$ideal[5] = array(75/5,70/5,85/5,85/5,40/5,30/5,25/5,20/5,40/5,50/5);
$ideal[6] = array(80/5,75/5,85/5,85/5,60/5,25/5,25/5,15/5,50/5,60/5);

$esp=$_SESSION['esp'];


for($i=0; $i<10; $i++)
	{
		$tabx[$i]=$_SESSION['xi'.$i];
	}
	
$im = @imagecreatefromjpeg ("graf_int.jpg");
@header("Content-type: image/png");
$myImage = @imagecreatetruecolor(640, 480)
    or die("Cannot Initialize new GD image stream");
$blue = @imagecolorallocate($myImage, 0, 0, 255);
$red = @imagecolorallocate($myImage, 255, 0, 0);
for($i=0; $i<10; $i++)
	{
		$y=($i*24)+27;
		$x=($tabx[$i]*32)+136;
		$xid=($ideal[$esp][$i]*32)+136;
		@imagefilledellipse ($im,$x,$y,15,15,$red);
		@imagefilledellipse ($im,$xid,$y,15,15,$blue);
		if($i!=0)
			{
				imageBoldLine($im, $x0, $y0, $x, $y, $red);
				imageBoldLine($im, $x0id, $y0, $xid, $y, $blue);
			}
		$x0=$x;
		$x0id=$xid;
		$y0=$y;		
	}

imagepng($im);
imagedestroy($im);

function imageBoldLine($resource, $x1, $y1, $x2, $y2, $Color, $BoldNess=5, $func='imageLine')
{
    $x1 -= ($buf=ceil(($BoldNess-1) /2));
    $x2 -= $buf;
    for($i=0;$i < $BoldNess;++$i)
        @$func($resource, $x1 +$i, $y1, $x2 +$i, $y2, $Color);
}

?>