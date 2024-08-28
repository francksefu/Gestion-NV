<?php
require_once __DIR__ . '/connect.php';

  class Produit {
    
    public $produit;

    function __construct()
    {
      $this->produit = 'produit';
    }

    public function insert ($Nom, $ImageLink , $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP, $path)
    {
      global $pdo;
	  $sql = 'INSERT INTO Produit(Nom, ImageLink , PrixAchat, PrixVente, PrixVmin, QuantiteStock, QuantiteStockMin, DescriptionP, `path`) VALUES(?,?,?,?,?,?,?,?, ?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$Nom, $ImageLink , $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP, $path
	  ]);

	  return $pdo->lastInsertId();
    }

    public function update ($Nom, $ImageLink , $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP, $path, $idProduit)
    {
		global $pdo;
		
		if (empty($ImageLink)) {
      $produit = [
        $Nom, $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP, $idProduit
      ];
      $sql = 'UPDATE Produit
				SET Nom = ?, PrixAchat = ?, PrixVente = ?, PrixVmin = ?, QuantiteStock = ?, QuantiteStockMin = ?, DescriptionP = ?
				WHERE idProduit = ?';
    } else {
      $produit = [
        $Nom, $ImageLink , $PrixAchat, $PrixVente, $PrixVmin, $QuantiteStock, $QuantiteStockMin, $DescriptionP, $path, $idProduit
      ];
      $sql = 'UPDATE Produit
      SET Nom = ?, ImageLink = ? , PrixAchat = ?, PrixVente = ?, PrixVmin = ?, QuantiteStock = ?, QuantiteStockMin = ?, DescriptionP = ?, `path` = ?
      WHERE idProduit = ?';
    }
		
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($produit)) {
			return true;
		}
        return false;
    }

    public function delete ($idProduit)
    {
		global $pdo;
		
		$sql = 'DELETE FROM Produit
        WHERE idProduit = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$idProduit])) {
			return true;
		}
        return false;
    }

    public function read($idProduit = null)
    {
		global $pdo;
        if(empty((int) $idProduit)) {
            $sql = 'SELECT * FROM Produit order by Nom asc';
            $statement = $pdo->query($sql);
        } else {
            $sql = 'SELECT * FROM Produit WHERE idProduit = ? order by Nom asc';
            $statement = $pdo->prepare($sql);
            $statement->execute([$idProduit]);
        }

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // cette fonction permet de remettre la quantite ajoute lors de l ajout(entree produit), cas de supression de l entree produit
    public function ajouter_soustraire_entree_depot($idProduit, $quantiteEntree, $type)
    {
        global $pdo;
        $ancienneQuantiteStock = $this->read($idProduit)[0]['QuantiteStock'];
        $sql = 'UPDATE Produit
				SET QuantiteStock = ?
				WHERE idProduit = ?';
		
		$statement = $pdo->prepare($sql);
        if ($type == 'delete') {
            $newQuantity = $ancienneQuantiteStock - $quantiteEntree;
        } elseif($type =='add') {
            $newQuantity = $ancienneQuantiteStock + $quantiteEntree;
        }

		// execute the UPDATE statment
		if ($statement->execute([$newQuantity, $idProduit])) {
			return true;
		} 
        return false;
    }

  }