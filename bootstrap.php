<?php
	require_once 'config';
	require_once ROOTDIR.'/Core/BDPHPunit.php';
	
	BDPHPunit::test("/");
	BDPHPunit::show();
?>
