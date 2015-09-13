<?php namespace libs\SqliteBackup;

use Config, Carbon, File;

class SqliteBackup
{
	private $_backup_path = 'sqlite_backup';
	private $backup_text_file = 'sqlitebackup.txt';
	private $extn = '.sqlite';
	private $_configIniFile = 'backupdata.ini';
	public $recycle = 10;


	/*
	* @return bool
	*/
	private function _path()
	{
		return storage_path() .'/'. $this->_backup_path . '/';
	}

	public function backup()
	{

		if( $this->_isCurrentDbSqlite() ){
			$currentFile = $this->_getCurrentSqliteFile();
			$newName = $this->_generateUniqueTime();
			$path = $this->_path();
			$dest =  $path . $newName;

			if( ! File::exists($path) ){
				$result = File::makeDirectory($path);
			}

			$status = $this->_backupAndRenameFile($currentFile, $dest);

			//We right it into ini file
			$this->_doConfigIniFile( $newName );

			return $status;

		}else{
			dd("\nYour current Database is not sqlite. This backup manager is only for sqlite.\nPlease press back button at your browser.");
		}

	}

	public function restore($name='')
	{
		$backupdataArr = $this->_readConfigIni();

		if( empty($backupdataArr) ){
			dd('No sqlite backup found. Go back');
		}

		//Lets get the current name of the in us sqlite by the application
		$currentFile = $this->_getCurrentSqliteFile();

		$pathinfo = pathinfo($currentFile);

		$dirname  = $pathinfo['dirname'] . '/';
		$basename = $pathinfo['basename'];

		$name = ( $name === '' ) ? $this->getLastBackedUpFile( $backupdataArr ) : $name;

		if( ! File::exists( $this->_path().$name ) ){
			dd( 'Sqlite backup not found. Go back' );
		}

		//If it's found..
		return File::copy( $this->_path().$name, $dirname.$basename );
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
		$remain = $this->_configIniRecycle($put['sqlite']);

		//We update the ini file
		$this->_writeConfigIni($file, $remain);

		//dd($this->_readConfigIni());

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

	private function _configIniRecycle($arrays)
	{
		//Lets get total array counts
		$count = count($arrays);

		if( $count > $this->recycle ){

			$diff = $count - $this->recycle;

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