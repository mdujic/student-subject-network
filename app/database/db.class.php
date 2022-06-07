<?php

require_once __SITE_PATH . '/vendor/autoload.php';

use GraphAware\Neo4j\OGM\EntityManager;

class DB_SQL
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
	{
		if( DB_SQL::$db === null )
	    {
	    	try
	    	{
	    		// Unesi ispravni HOSTNAME, DATABASE, USERNAME i PASSWORD
		    	DB_SQL::$db = new PDO( "mysql:host=rp2.studenti.math.hr;dbname=dujic;charset=utf8",'student','pass.mysql');
		    	DB_SQL::$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		    catch( PDOException $e ) { exit( 'PDO Error: ' . $e->getMessage() ); }
	    }
		return DB_SQL::$db;
	}
}


class DB_NEO4J
{
  private static $em = null;

  private function __construct() { }
	private function __clone() { }

  public static function getConnection()
	{
		if (DB_NEO4J::$em === null)
	  {
	    try
	    {
        	DB_NEO4J::$em = EntityManager::create(
			"http://neo4j:nbp@localhost:7474");
		}
		catch (Exception $e) { exit ("Error: " . $e->getMessage()); }
	  }
    return DB_NEO4J::$em;
  }
}

?>