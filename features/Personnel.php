<?php
require_once __DIR__ . '/connect.php';

  class Personnel {

    public static function insert ($NomP, $Telephone, $SalaireDeBase, $Poste, $PasswordP)
    {
      global $pdo;
	  $sql = 'INSERT INTO DataPersonnel(NomP, Telephone, SalaireDeBase, Poste, PasswordP) VALUES(?,?,?,?,?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$NomP, $Telephone, $SalaireDeBase, $Poste, $PasswordP
	  ]);

	  return $pdo->lastInsertId();
    }

    public static function update ($NomP, $Telephone, $SalaireDeBase, $Poste, $PasswordP, $idDataPersonnel)
    {
		global $pdo;
		$employe = [
			$NomP, $Telephone, $SalaireDeBase, $Poste, $PasswordP, $idDataPersonnel
		];
		
		$sql = 'UPDATE DataPersonnel
				SET NomP = ?, Telephone = ?, SalaireDeBase = ?, Poste = ?, PasswordP = ?
				WHERE idDataPersonnel = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($employe)) {
			return true;
		}
        return false;
    }

    public static function delete ($idDataPersonnel)
    {
		global $pdo;
		
		$sql = 'DELETE FROM DataPersonnel
        WHERE idDataPersonnel = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$idDataPersonnel])) {
			return true;
		}
        return false;
    }

    public static function read()
    {
		global $pdo;
		$sql = 'SELECT * FROM DataPersonnel ORDER BY NomP ASC ';

		$statement = $pdo->query($sql);

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


  }