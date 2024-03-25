<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allows-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instanciation de la DB et connexion
$database = new connectDB();
$db = $database->connect();

//Instanciation du post
$post = new Post($db);

//Récupérer les données postées
$data = json_decode(file_get_contents("php://input"));

//Mettre l'id du post à supprimer
$post->id = $data->id;

//Supprimer le post
if ($post->delete()) {
    echo json_encode(
        array('message' => 'Post supprimé')
    );
} else {
    echo json_encode(
        array('message' => 'Post non supprimé')
    );
}
