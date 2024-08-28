<?php
require_once __DIR__ . '/../config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
	$pdo = new PDO($dsn, $user, $password);

	if ($pdo) {
		return true;
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}