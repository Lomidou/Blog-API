<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instanciation de la DB et connexion
$database = new connectDB();
$db = $database->connect();

//Instanciation du post du blog
$post = new Post($db);

//Récupère les posts
$result = $post->read();

//Obtenir le nombre de lignes
$num = $result->rowCount();

//Vérifier si des posts existent
if ($num > 0) {
    //Post array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_name' => $category_name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        );

        //Push à "data"
        array_push($posts_arr['data'], $post_item);
    }

    //Convertir en JSON et afficher le résultat
    echo json_encode($posts_arr);
} else {
    //Pas de posts
    echo json_encode(
        array('message' => 'Aucun post trouvé')
    );
}
