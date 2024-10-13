<?php
require_once __DIR__ . '/connect.php';

  class Sortie {

    public static function insert ($TypeD, $Montant, $il_pris_quoi, $DatesD)
    {
      global $pdo;
	  $sql = 'INSERT INTO Sortie($TypeD, $Montant, $il_pris_quoi, $DatesD) VALUES(?,?,?,?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$TypeD, $Montant, $il_pris_quoi, $DatesD
	  ]);

	  return $pdo->lastInsertId();
    }

    public static function update ($TypeD, $Montant, $il_pris_quoi, $DatesD, $idSortie)
    {
		global $pdo;
		$employe = [
			$TypeD, $Montant, $il_pris_quoi, $DatesD ,$idSortie
		];
		
		$sql = 'UPDATE Sortie
				SET TypeD = ?, Montant = ?, il_pris_quoi = ?, DatesD = ?
				WHERE idSortie = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($employe)) {
			return true;
		}
        return false;
    }

    public static function delete ($idSortie)
    {
		global $pdo;
		
		$sql = 'DELETE FROM Sortie
        WHERE idSortie = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$idSortie])) {
			return true;
		}
        return false;
    }

    public static function read()
    {
		global $pdo;
		$sql = 'SELECT * FROM Sortie ORDER BY idSortie DESC ';

		$statement = $pdo->query($sql);

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


  }