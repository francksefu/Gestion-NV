<?php
require_once __DIR__ . '/connect.php';
require_once __DIR__ . '/Produit.php';

  class Vente {
    
    public $vente;

    function __construct()
    {
      $this->vente = 'vente';
    }

    public static function insert ($idProduit, $idClient, $QuantiteVendu, $PU, $PT, $DatesVente, $Operation, $Dette, $TotalFacture, $MontantPaye, $idPersonnel)
    {
      global $pdo;
	  $sql = 'INSERT INTO Ventes(idProduit, idClient, QuantiteVendu, PU, PT, DatesVente, Operation, Dette, TotalFacture, MontantPaye, idPersonnel) VALUES(?,?,?,?,?,?,?,?,?,?,?)';

	  $statement = $pdo->prepare($sql);
	  
      if ($statement->execute([$idProduit, $idClient, $QuantiteVendu, $PU, $PT, $DatesVente, $Operation, $Dette, $TotalFacture, $MontantPaye, $idPersonnel])) {
        Produit::decreaseProductInStock($idProduit, $QuantiteVendu, 'delete');
        return true;
      }
      return false;
    }

    public static function insert_multiple($array)
    {
        foreach($array as $arr) {
            if (! (self::insert($arr['idProduit'], $arr['idClient'], $arr['QuantiteVendu'], $arr['PU'], $arr['PT'], $arr['DatesVente'], $arr['Operation'], $arr['Dette'], $arr['DatesVente'], $arr['TotalFacture'], $arr['MontantPaye'], $arr['idPersonnel']))) {
                return false;
            }
        }
        return true;
    }

    public static function update ($Operation, $array)
    {
        if(self::delete($Operation)) {
            self::insert_multiple($array);
            return true;
        }
		return false;
    }

    public static function delete ($Operation)
    {
		global $pdo;
		$takeLinesOfVentesToDelete = self::read($Operation);
        if (! empty($takeLinesOfVentesToDelete)) {
            foreach($takeLinesOfVentesToDelete as $array) {
                Produit::increaseProductInStock($array['idProduit'], $array['QuantiteVendu']);
            }
            $sql = 'DELETE FROM Ventes
            WHERE Operation = ?';
            
            $statement = $pdo->prepare($sql);

            // execute the DELETE statment
            if ($statement->execute([$Operation])) {
                return true;
            }
            return false;
        } else {
            return false;
        }
		
    }

    public static function read($Operation = null)
    {
        global $pdo;
        if(! empty($Operation)) {
            $sql = 'SELECT * FROM Ventes WHERE Operation = ? ORDER BY idVentes DESC';
            $statement = $pdo->prepare($sql);
            if ($statement->execute([$Operation])) {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            $sql = 'SELECT * FROM Ventes GROUP BY Operation ORDER BY idVentes DESC LIMIT 900';

            $statement = $pdo->query($sql);

            // get all publishers
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
		
        return false;
    }

   /* public static function read_group_by_facture($type, $date1 = '', $date2 = '')
{
    global $pdo;
    $array_to_return = [];
    if(! empty($type) && empty($date1) && empty($date2)) {
        $sql_1 = 'SELECT Nfacture FROM entree_sortie_depot WHERE `type` = ? GROUP BY Nfacture ORDER BY Nfacture DESC LIMIT 900';
        $statement_1 = $pdo->prepare($sql_1);
        $stmt = $statement_1->execute([$type]);
    } elseif(! empty($type) && ! empty($date1) && empty($date2)) {
        $sql_1 = 'SELECT Nfacture FROM entree_sortie_depot WHERE `type` = ? and `date` = ? GROUP BY Nfacture ORDER BY Nfacture DESC ';
        $statement_1 = $pdo->prepare($sql_1);
        $stmt = $statement_1->execute([$type, $date1]);
    } elseif (! empty($type) && ! empty($date1) && ! empty($date2)) {
        $sql_1 = 'SELECT Nfacture FROM entree_sortie_depot WHERE `type` = ? and `date` between ? and ? GROUP BY Nfacture ORDER BY Nfacture DESC ';
        $statement_1 = $pdo->prepare($sql_1);
        $stmt = $statement_1->execute([$type,$date1, $date2]);
    }
    
    
    
    //$statement_1 = $pdo->prepare($sql_1);
    
    if ($stmt) {
        $data_group_by = $statement_1->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($data_group_by as $data) {
            $data_content = $this->read($data['Nfacture']);
            $array_to_return[] = [
                'note' => $data_content[0]['note'],
                'Date' => $data_content[0]['date'],
                'heure' => $data_content[0]['heure'],
                'Nfacture' => $data['Nfacture'],
                'type' => $data_content[0]['type'],
                'data_content' => $data_content
            ];
        }
        
        return $array_to_return;
    }
    
    return []; // Optionally, return an empty array if the execution fails
}


   /* public function read($Operation = null, $idProduit = null, $date1 = null, $date2 = null)
    {
		global $pdo;
		if ($Operation) {
			$sql = 'SELECT * FROM Ventes WHERE Operation = ? ORDER BY idVentes DESC';
            $statement = $pdo->prepare($sql);
            if ($statement->execute([$Operation])) {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
            return false;
		} elseif($idProduit && empty($date1) && empty($date2)) {
            $sql = 'SELECT * FROM Ventes WHERE (idProduit = ?)';
            $statement = $pdo->prepare($sql);
            if ($statement->execute([$idProduit])) {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
            return false;
        } else {
            $sql = 'SELECT * FROM Ventes ORDER BY idVentes DESC LIMIT 5000';
            $statement = $pdo->query($sql);
        }
		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

	/*public function querySurUneDate($date)
	{
		global $pdo;
		$sql = 'SELECT * FROM entree_sortie_depot WHERE `Date` = ? order by idSortie desc';

		$stmt = $pdo->prepare($sql);

		// Execute the statement
		$stmt->execute([$date]);

		// Fetch all results
		return $stmt->fetchAll();
	}

	public function querySurDeuxDate($date1, $date2)
	{
		global $pdo;
		$sql = 'SELECT * FROM entree_sortie_depot WHERE `Date` between ? and ? order by idSortie desc';

		$stmt = $pdo->prepare($sql);

		// Execute the statement
		$stmt->execute([$date1, $date2]);

		// Fetch all results
		return $stmt->fetchAll();
	}

    public function read_inventaire_produit($type, $date1 = null, $date2 = null)
    {
        $array_to_return = [];
        $produit = new Produit();
        $produits = $produit->read();
        foreach($produits as $par_produit) {
            $entree_sortie = $this->read(null, $par_produit['idProduit'], $type, $date1, $date2);
            $quantite_total = array_reduce(
                $entree_sortie,
                function ($prev, $item) {
                    return $prev + $item['quantite'];
                }
            );
            if(empty($quantite_total)) {
                $quantite_total = 0;
            }
            $array_to_return[] = ['nom' => $par_produit['nom'], "quantite_total" => $quantite_total, 'quantiteStock' => $par_produit['quantiteStock'], 'unite_mesure' => $par_produit['unite_mesure']];
        }
		return $array_to_return;
    }*/
  }