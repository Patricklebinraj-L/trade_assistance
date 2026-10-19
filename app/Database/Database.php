<?php
declare(strict_types=1);
final class Database {private static ?PDO $pdo=null;public static function connection():PDO{if(self::$pdo)return self::$pdo;if(!extension_loaded('pdo_mysql'))throw new RuntimeException('PHP pdo_mysql extension is required.');$dsn='mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET;self::$pdo=new PDO($dsn,(string)DB_USER,(string)DB_PASSWORD,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);return self::$pdo;}}
