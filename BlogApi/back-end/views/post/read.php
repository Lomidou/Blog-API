<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instanciation de la DB et connexion
$database = new connectDB();
$db = $database->connect();

// Instanciation du post du blog
$post = new Post($db);

// Récupération des paramètres de pagination depuis l'URL de la requête
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10; // Par défaut, 10 posts par page

// Calcul de l'offset en fonction de la page demandée
$offset = ($page - 1) * $limit;

// Récupération des posts avec offset et limit
$result = $post->read($limit, $offset);

// Obtenir le nombre total de lignes (utile pour la pagination)
$total_rows = $post->count(); // Méthode count() à implémenter dans votre modèle Post

// Obtenir le nombre de lignes récupérées
$num = $result->rowCount();

// Vérifier si des posts existent
if ($num > 0) {
    // Post array
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

        // Ajouter à "data"
        array_push($posts_arr['data'], $post_item);
    }

    // Créer un tableau pour les informations de pagination
    $pagination = array(
        'total_rows' => $total_rows,
        'total_pages' => ceil($total_rows / $limit), // Calculer le nombre total de pages
        'current_page' => $page,
        'limit' => $limit
    );

    // Ajouter les informations de pagination à la réponse
    $posts_arr['pagination'] = $pagination;

    // Convertir en JSON et afficher le résultat
    echo json_encode($posts_arr);
} else {
    // Pas de posts
    echo json_encode(
        array('message' => 'Aucun post trouvé')
    );
}
