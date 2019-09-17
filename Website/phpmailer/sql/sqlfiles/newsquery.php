<?php

	require'connect/credentials.php';
	
	
	try {
	$db = new PDO($newsdb,$user,$password);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db->exec("SET NAMES 'utf8'");
	
	}
	catch (Exception $e)
	{
		echo "Could not connect to the database";
		exit;	
	}
	
	try{
		
		$results = $db->query("SELECT * FROM news");
		
		
		}
	catch(Exception $e){
		echo "data could not be retrieved from the database". $e;
		exit;
		
		}
		
		$newsdetails = $results->fetchAll(PDO::FETCH_ASSOC);
		
		//close connection
		$db=null;

?>