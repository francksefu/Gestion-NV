<?php
require_once __DIR__ . '/connect.php';

  class BonusPerte {

    public static function insert ($idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif)
    {
      global $pdo, $produit;
	  $sql = 'INSERT INTO BonusPerte(idProduit, QuantitePerdu, QuantiteGagne, DatesD, Motif) VALUES(?,?,?,?,?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif
	  ]);

      if ($pdo->lastInsertId()) {
        Produit::increaseProductInStock($idProduit, $QuantiteGagne);
        Produit::decreaseProductInStock($idProduit, $QuantitePerdu);
        return true;
      }
      return false;
    }

    public static function update ($idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif, $idBonusPerte)
    {
		global $pdo, $produit;
		$employe = [
			$idProduit, $QuantitePerdu, $QuantiteGagne, $DatesD, $Motif, $idBonusPerte
		];
        //remettre les anciennes quantite avant la modification
        $oldBonusPerte = self::read($idBonusPerte);
        Produit::increaseProductInStock($oldBonusPerte[0]['idProduit'], $oldBonusPerte[0]['QuantitePerdu']);
        Produit::decreaseProductInStock($oldBonusPerte[0]['idProduit'], $oldBonusPerte[0]['QuantiteGagne']);
		
		$sql = 'UPDATE BonusPerte
				SET idProduit = ?, QuantitePerdu = ?, QuantiteGagne = ?, DatesD = ?, Motif = ?
				WHERE idBonusPerte = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($employe)) {
            Produit::increaseProductInStock($idProduit, $QuantiteGagne);
            Produit::decreaseProductInStock($idProduit, $QuantitePerdu);
			return true;
		}
        return false;
    }

    public static function delete ($id)
    {
		global $pdo;
        $oldBonusPerte = self::read($id);
        Produit::increaseProductInStock($oldBonusPerte[0]['idProduit'], $oldBonusPerte[0]['QuantitePerdu']);
        Produit::decreaseProductInStock($oldBonusPerte[0]['idProduit'], $oldBonusPerte[0]['QuantiteGagne']);
		$sql = 'DELETE FROM BonusPerte
        WHERE idBonusPerte = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$id])) {
			return true;
		}
        return false;
    }

    public static function read($idBonusPerte = null)
    {
		global $pdo;
        if(empty((int) $idBonusPerte)) {
            $sql = 'SELECT * FROM BonusPerte order by idBonusPerte desc';
            $statement = $pdo->query($sql);
        } else {
            $sql = 'SELECT * FROM BonusPerte WHERE idBonusPerte = ? order by idBonusPerte desc';
            $statement = $pdo->prepare($sql);
            $statement->execute([$idBonusPerte]);
        }

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    

  }