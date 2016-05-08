<?php
	require('core/functions.php');
	require('finder/mainclass.php');
	if($core->showFiles){
		require('common/header.php');
		require('finder/index.php');
		require('common/footer.php');
	}