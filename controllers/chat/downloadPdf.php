<?php

$file = urldecode($_GET['file']);
header("Content-type:application/pdf");
// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename='{$file}'");
// The PDF source is in original.pdf
readfile("../../assets/sharedDoc/{$file}");

?>