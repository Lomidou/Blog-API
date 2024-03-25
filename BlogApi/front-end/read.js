document.addEventListener("DOMContentLoaded", function () {
  fetchPosts();
});

function fetchPosts() {
  fetch("../back-end/views/post/read.php")
    .then((response) => response.json())
    .then((data) => {
      const postsContainer = document.getElementById("posts-container");
      data.data.forEach((post) => {
        const postElement = document.createElement("div");
        postElement.innerHTML = `
                <div class="mb-[5%]">
                <h2 class="text-2xl text-slate-700 font-bold">${post.title}</h2>
                <p>${post.body}</p>
                <p>${post.created_at}</p>
                <p>${post.author}</p>
                <post>${post.category_name}</post>
                <a class="text-center" href="edit-post.html?id=${post.id}">Modifier</a>   
                <button class="text-center" onclick="deletePost(${post.id})">Supprimer</button>
                </div>
            `;
        postsContainer.appendChild(postElement);
      });
    })
    .catch((error) =>
      console.error("Erreur lors du chargement des articles:", error)
    );
}

function deletePost(id) {
  fetch("../back-end/views/post/read.php", {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id: id }),
  })
    .then((response) => response.json())
    .then((data) => {
      alert(data.message);
      fetchPosts();
    })
    .catch((error) =>
      console.error("Erreur lors de la suppression du post:", error)
    );
}
