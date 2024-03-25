<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instanciation de la DB et connexion 
$database = new connectDB();
$db = $database->connect();

//Instanciation du post du blog
$post = new Post($db);

//Récuperer les données postées
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

//Créer le post
if ($post->create()) {
    echo json_encode(
        array('message' => 'Post créé')
    );
} else {
    echo json_encode(
        array('message' => 'Post non créé')
    );
}
