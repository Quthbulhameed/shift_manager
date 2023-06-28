<?php

////////// Acces au fichier.json 
$filename = 'data.json';
$json_donnees = file_get_contents($filename);
$data = json_decode($json_donnees, true);
print_r($data);

///////// condition de verification
try {
    if ($json_donnees == true) {
        echo "reussir a extrait \n";
    } if ($data !== null){
        echo "Le fichier reussir a extraire le tab\n";
    }
    else {
        throw new Exception("Erreur");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}




extract($data);
///Tableuau vide 
$salaireE_list = array();

$numWorkers = count($workers);
$i = 0;



////// pour parcourir le tableau workers
while ($i < $numWorkers) {
    $worker = $workers[$i];
    $id = $worker["id"];
    $name = $worker["first_name"];
    $price = $worker["price_per_shift"];

    $solde = 0;
    $Numcompte = 0;
    
    ////// pour parcourir le tableau shifs
    foreach ($shifts as $periode) {

        if ($periode["user_id"] == $id) {

            $solde = $price + $solde ;
            $Numcompte++;
        }
    }
    ////Ajoute vers le salaire de travailleur vers un tableau 
    $salaireE_list[$name] = [
        "solde" => $solde,
        "Numcompte" => $Numcompte
    ];

    $i++;
}


///// convertir une chaine json en un fichier output 
$salaireE_list = json_encode($salaireE_list);
$file = file_put_contents("output.json", $salaireE_list);

//////////condition de verification
try {
    if ($file == true) {
        echo "Le fichier output.json a ete cree avec succes.";
    } else {
        throw new Exception("Erreur lors de l'ecriture dans le fichier.");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


?>
