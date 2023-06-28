<?php

////////// Acces au fichier.json 
$filename = 'data.json';
$json_donnees = file_get_contents($filename);
$data = json_decode($json_donnees, true);
print_r($data);

///////// condition de verification
try {
    if ($json_donnees == true) {
        echo "Le fichier reussir a extraire ";
    } if ($data !== null){
        echo "Le fichier reussir a extraire le tab";
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
    $status = $worker["status"];


    $soldes = 0;

////// pour parcourir le tableau shifs
    foreach ($shifts as $periode) {
        if ($periode["user_id"] == $id) {

            $wo = $worker["status"];
            
            switch ($wo) {
                case "medic":
                    $soldes += 270;
                    break;
                case "interne":
                    $soldes += 126;
                    break;
                default:
                    break;
            }
        }
    }

    ////Ajoute le salaire de travailleur vers un tableau 
    $salaireE_list[$name]["soldes"] = $soldes;

    $i++;
}

// Affichage du tableau des salaires
foreach ($salaireE_list as $employee => $soldes) {
    echo "Employe : " . $employee . "<br>";
    echo "Salaire : " . $soldes["soldes"] . "<br><br>";
}

///// convertir une chaine json en un fichier output 
$salaireE_list = json_encode($salaireE_list);
$file = file_put_contents("output.json", $salaireE_list);



///////// condition de verification
try {
    if ($file !== false) {
        echo "Le fichier output.json a ete cree avec succes.";
    } else {
        throw new Exception("Erreur lors de lecriture dans le fichier.");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


?>
