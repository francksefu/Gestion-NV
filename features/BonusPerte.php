<?php
require_once __DIR__ . '/connect.php';

  class BonusPerte {

    public static function insert ($idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif)
    {
      global $pdo;
	  $sql = 'INSERT INTO BonusPerte(idProduit, QuantitePerdu, QuantiteGagne, DatesD, Motif) VALUES(?,?,?,?,?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif
	  ]);

	  return $pdo->lastInsertId();
    }

    public static function update ($idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif)
    {
		global $pdo;
		$employe = [
			$idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif
		];
		
		$sql = 'UPDATE BonusPerte
				SET idProduit = ?, QuantitePerdu = ?, QuantiteGagne = ?, DatesD = ?, Motif = ?
				WHERE idBonusPerte = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($employe)) {
			return true;
		}
        return false;
    }

    public static function delete ($id)
    {
		global $pdo;
		
		$sql = 'DELETE FROM BonusPerte
        WHERE idBonusPerte = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$id])) {
			return true;
		}
        return false;
    }

    public static function read()
    {
		global $pdo;
		$sql = 'SELECT * FROM BonusPerte ORDER BY idBonusPerte DESC ';

		$statement = $pdo->query($sql);

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


  }