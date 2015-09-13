<?php

return [
	
	/*
	* This is the path where the backup would be saved. Usually locally save
	*/
	'backup_path'	=> Storage_path() . '/sqlite_backup/',

	/*
	* This is the config ini file created by the program
	* Used for the monitoring of the back.
	* Can be left to default name.
	* Note: This should be left if the first backup is done.
	*/
	'config_ini' => 'config.ini',

	/*
	* This is the maximum number of backup files.
	* If there's an extra file it would auto clean
	* the oldest.
	* If set to 0. It would disable recycling
	*/
	'washer'	=>	5,

];