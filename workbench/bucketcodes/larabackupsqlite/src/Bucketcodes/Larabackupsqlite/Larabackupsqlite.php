<?php namespace Bucketcodes\Larabackupsqlite;

use Config, Carbon, File;
use Illuminate\Config\Repository;

class Larabackupsqlite
{
	private $_backup_path;
	private $_configIniFile;
	private $_washer;
	private static $osVersion;

	public function __construct(Repository $config)
	{
		$this->_backup_path = $config->get('larabackupsqlite::backup_path');
		$this->_configIniFile = $config->get('larabackupsqlite::config_ini');
		$this->_washer = $config->get('larabackupsqlite::washer');
	}


	/*
	* @return bool
	*/
	private function _path()
	{
		return $this->_backup_path;
	}

	private function _isBackupPath( $path )
	{
		//We get the drive letter
		$drive = (preg_match('/^[A-Z]:/i', $path = pathinfo($path)['dirname'])) ? $path[0] : null;

		//Then we check if the letter exists as a directory
		$returned = File::exists( $drive .':\\');

		if( ! $returned ){
			dd('Back up path [ '. $path .' ] can not be found');
			return false;
		}
	}

	public function backup()
	{

		if( ! $this->_isCurrentDbSqlite() ){
			dd("\nYour current Database is not sqlite. This backup manager is only for sqlite.\nPlease press back button at your browser.");
			return false;
		}

		$path = $this->_path();

		//Can the backup path Drive letter be found?
		//Else alt the progress of the operation
		$this->_isBackupPath( $path );

		$currentFile = $this->_getCurrentSqliteFile();
		$newName = $this->_generateUniqueTime();
		$dest =  $path . $newName;

		if( ! File::exists($path) ){
			$result = File::makeDirectory($path);
		}

		$status = $this->_backupAndRenameFile($currentFile, $dest);

		//We right it into ini file
		$this->_doConfigIniFile( $newName );

		return $status;

	}

	public function restore($name='')
	{
		$backupdataArr = $this->_readConfigIni();

		if( empty($backupdataArr) ){
			dd('No sqlite backup found. Go back');
		}

		//Lets get the current name of the sqlite in use by the application
		$currentFile = $this->_getCurrentSqliteFile();

		$pathinfo = pathinfo($currentFile);

		$dirname  = $pathinfo['dirname'] . '/';
		$basename = $pathinfo['basename'];

		$name = ( $name === '' ) ? $this->getLastBackedUpFile( $backupdataArr ) : $name;

		$path = $this->_path();

		//Can the backup path Drive letter be found?
		//Else alt the progress of the operation
		$this->_isBackupPath( $path );

		if( ! File::exists( $path.$name ) ){
			dd( 'Sqlite backup not found. Go back' );
		}

		//If it's found..
		return File::copy( $path.$name, $dirname.$basename );
	}

	public function getLastBackedUpFile( $backupdataArr )
	{
		return array_pop($backupdataArr['sqlite']);
	}

	private function _generateUniqueTime()
	{
		return Carbon::now()->format('Ymdhis');
	}

	private function _doConfigIniFile($newName)
	{
		//We check if the file exists else we create it
		$file = $this->_configIniFilePath();
		if( ! File::exists($file) ){
			File::put($file, '');
		}

		//We check if file is empty or not
		$put = $this->_isConfigIniFileEmpty();

		//We assign newly created sqlite backup name
		$put['sqlite'][] = $newName;

		/*We do some recycling if the total numbers of array is more than the recycling value*/
		$remain = ( $this->_washer > 0 ) 
					? $this->_configIniWasher($put['sqlite']) 
					: $put['sqlite'];

		//We update the ini file
		$this->_writeConfigIni($file, $remain);

		return true;
	}

	/*
	* @ return true if empty else return Array of the ini file
	*/
	private function _isConfigIniFileEmpty()
	{
		$arrays = $this->_readConfigIni();

		if ( empty($arrays) ) {
			$arrays['sqlite'] = [];
		}

		return $arrays;
	}

	private function _configIniFilePath()
	{
		return $this->_path() . $this->_configIniFile;
	}

	private function _readConfigIni()
	{
		$file = $this->_configIniFilePath();
		return parse_ini_file($file);
	}

	private function _writeConfigIni($file, $array, $i = 0)
	{
		$str="";
		foreach ($array as $k => $v){
			if (is_array($v)){
			  $str.=str_repeat(" ",$i*2)."[$k]".PHP_EOL; 
			  $str.=$this->_writeConfigIni("",$v, $i+1);
			}else{
			  $str.=str_repeat(" ",$i*2)."sqlite[] = $v".PHP_EOL; 
			}
		}

		if($file){
		    return File::put($file, $str);
		 } else {
		    return $str;
		 }
	}

	private function _configIniWasher($arrays)
	{
		//Lets get total array counts
		$count = count($arrays);

		if( $count > $this->_washer ){

			$diff = $count - $this->_washer;

			for( $i = 0; $i < $diff; $i++ )
			{	
				$files[] = $this->_path() . $arrays[$i];
				unset( $arrays[$i] );
			}

			File::delete($files);
		}

		return $arrays;
	}

	private function _backupAndRenameFile($currentFile, $dest)
	{
		return ( ! File::copy($currentFile, $dest) ) ? false : true;
	}

	private function _getCurrentSqliteFile()
	{
		return Config::get('database.connections.sqlite.database');
	}

	private function _isCurrentDbSqlite()
	{
		$db = Config::get('database.default');

		return ( strtolower($db) === 'sqlite' ) ? true : false;
	}

}