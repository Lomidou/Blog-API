document.addEventListener("DOMContentLoaded", function () {
  const postForm = document.getElementById("post-form");
  postForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêcher le formulaire d'être soumis normalement

    // Récupérer les valeurs des champs du formulaire
    const title = document.getElementById("title").value;
    const body = document.getElementById("content").value;
    const author = document.getElementById("author").value;
    // Correction : Utilisation de querySelector pour sélectionner le bouton radio de la catégorie
    const category_id = document.querySelector(
      'input[name="category_id"]:checked'
    ).value;

    // Construire un objet JSON avec les données du formulaire
    const postData = {
      title: title,
      body: body,
      author: author,
      category_id: category_id,
    };

    // Envoyer les données du formulaire au script PHP en tant que JSON
    fetch("../back-end/views/post/create.php", {
      method: "POST",
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
        postForm.reset();
      })
      .catch((error) => {
        console.error("Erreur lors de la soumission du formulaire:", error);
        // Affichez un message d'erreur ou effectuez une autre action appropriée
      });
  });
});
