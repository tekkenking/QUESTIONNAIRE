<?php namespace libs\SqliteBackup\SqliteBackupFacade;

use Illuminate\Support\Facades\Facade;

class SqliteBackup extends Facade{

	protected static function getFacadeAccessor(){
		return 'sqlitebackup';
	}
}