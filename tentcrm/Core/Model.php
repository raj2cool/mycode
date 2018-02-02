<?php
namespace Core;
use PDO;
abstract class Model
{
	protected static function getDB()
	{
		static $db=null;
		if($db===null)
		{
			$host='localhost';
			$dbname='tentcrm';
			$user='root';
			$password='';
		}
		try{
			$db=mysqli_connect($host,$user,$password);
			if (isset($db)) {
				mysqli_select_db($db,$dbname);
				return $db;
			}
		} catch(PDOEsxception $e) {
			echo $e->getMessage();
		}
	}
}