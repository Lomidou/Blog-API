document.addEventListener("DOMContentLoaded", function () {
  const editPostForm = document.getElementById("edit-post-form");

  editPostForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêcher le formulaire d'être soumis normalement

    // Récupérer les valeurs des champs du formulaire

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const title = document.getElementById("title").value;
    const author = document.getElementById("author").value;
    const body = document.getElementById("body").value;
    const category_id =
      document.querySelector('input[name="category_id"]:checked').value || null;

    // Construire un objet JSON avec les données du formulaire
    const postData = {
      id: id,
      title: title,
      author: author,
      body: body,
      category_id: category_id,
    };

    // Envoyer les données du formulaire au script PHP en tant que JSON
    fetch("../back-end/views/post/update.php", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(postData), // Convertir l'objet en JSON
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors de la soumission du formulaire");
        }
        return response.json();
      })
      .then((data) => {
        alert(data.message);
        editPostForm.reset();
      })
      .catch((error) => {
        console.error("Erreur lors de la soumission du formulaire:", error);
        // Affichez un message d'erreur ou effectuez une autre action appropriée
      });
  });
});
