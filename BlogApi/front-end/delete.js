document.addEventListener("DOMContentLoaded", function () {
  const deletePostButton = document.getElementById("delete-post");

  deletePostButton.addEventListener("click", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get("id");

    // Appeler la fonction pour supprimer le post
    deletePost(postId);
  });
});

function deletePost(id) {
  fetch("../back-end/views/post/delete.php", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: id }),
  })
    .then((response) => response.json())
    .then((data) => {
      // Afficher le message de suppression
      alert(data.message);

      // Recharger les posts après la suppression
      fetchPosts();

      // Rediriger vers la page d'accueil
      header("Location: index.html");
    })
    .catch((error) =>
      console.error("Erreur lors de la suppression du post:", error)
    );
}
