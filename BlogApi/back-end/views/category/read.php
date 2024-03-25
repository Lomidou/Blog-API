<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instanciation de la DB et connexion
$database = new connectDB();
$db = $database->connect();

//Instanciation de la catégorie
$category = new Category($db);

//Récupérer les catégories
$result = $category->read();

//Obtenir le nombre de lignes
$num = $result->rowCount();

//Vérifier si des catégories existent
if ($num > 0) {
    //Catégorie array
    $categories_arr = array();
    $categories_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => $name,
        );

        //Push à "data"
        array_push($categories_arr['data'], $category_item);
    }

    //Convertir en JSON et afficher le résultat
    echo json_encode($categories_arr);
} else {
    //Pas de catégories
    echo json_encode(
        array('message' => 'Aucune catégorie trouvée')
    );
}
