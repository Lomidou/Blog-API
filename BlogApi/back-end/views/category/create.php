<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allows-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instanciation de la DB et connexion
$database = new connectDB();
$db = $database->connect();

//Instanciation de la catégorie
$category = new Category($db);

//Récupérer les données postées
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

//Créer la catégorie
if ($category->create()) {
    echo json_encode(
        array('message' => 'Catégorie créée')
    );
} else {
    echo json_encode(
        array('message' => 'Catégorie non créée')
    );
}
