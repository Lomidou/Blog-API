<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instanciation de la DB et connexion
$database = new connectDB();
$db = $database->connect();

//Instanciation du post
$post = new Post($db);

//Obtenir l'id du post
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Lire le post unique
$post->read_single();

//Créer un tableau
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'created_at' => $post->created_at,
    'updated_at' => $post->updated_at,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
);

//Convertir en JSON et afficher le résultat
print_r(json_encode($post_arr));
