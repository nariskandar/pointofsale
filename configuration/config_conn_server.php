<?php

	$servernameServer = "multisolusi.com";
	$usernameServer   = "basic";
	$passwordServer   = "indonesia123";
	$dbnameServer     = "basic";
	
		$koneksiServer = mysqli_connect($servernameServer, $usernameServer, $passwordServer);
		$dbServer  	   = mysqli_select_db($koneksiServer, $dbnameServer);
	
		// global $connServer;
		$connServer = mysqli_connect($servernameServer, $usernameServer, $passwordServer, $dbnameServer);
	
		if(!$connServer){
			die("Connection failed: " . mysqli_connect_error());
		}