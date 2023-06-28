<?php

$filename = 'data.json';
$json_donnees = file_get_contents($filename);
$data = json_decode($json_donnees, true);

print_r($data);

try {
    if ($json_donnees == true) {
        echo "Le fichier a été extrait avec succès.";
    }
    if ($data !== null) {
        echo "Le tableau a été extrait avec succès.";
    } else {
        throw new Exception("Erreur");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

extract($data);

$salaireE_list = array();

$numWorkers = count($workers);
$i = 0;
while ($i < $numWorkers) {
    $worker = $workers[$i];
    $id = $worker["id"];
    $name = $worker["first_name"];
    $status = $worker["status"];

    $salary = 0;

    foreach ($shifts as $shift) {
        if ($shift["user_id"] == $id) {
            $wo = $worker["status"];
            $shiftId = $shift["id"];

            switch ($wo) {
                case "medic":
                    $rate = 270;
                    break;
                case "interne":
                    $rate = 126;
                    break;
                case "interim":
                    $rate = 480;
                    break;
                default:
                    $rate = 0;
                    break;
            }

            switch ($shiftId) {
                case 6:
                    $salary += $rate * 2;
                    break;
                case 7:
                    $salary += $rate * 2; // Double tarif pour les quarts de travail du 6e et 7e jour
                    break;
                default:
                    $salary += $rate; // Tarif normal pour les autres jours de la semaine
                    break;
            }
        }
    }

    if ($status == "interim") {
        $commission = 80;
        $salary -= $commission;
    } else {
        $commission = $salary * 0.05;
        $salary -= $commission;
    }

    $salaireE_list[$name . ' (' . $status . ')'] = $salary;

    $i++;
}

// Affichage du tableau des salaires
foreach ($salaireE_list as $employee => $salary) {
    echo "Employé : " . $employee . "<br>";
    echo "Salaire : " . $salary . "<br><br>";
}

// Convertir le tableau des salaires en une chaîne JSON
$salaireE_list = json_encode($salaireE_list);

$file = file_put_contents("output.json", $salaireE_list);

try {
    if ($file !== false) {
        echo "Le fichier output.json a été créé avec succès.";
    } else {
        throw new Exception("Erreur lors de l'écriture dans le fichier.");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


?>
