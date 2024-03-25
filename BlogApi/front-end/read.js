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
                <post class="text-center border-solid-2 text-white bg-sky-900 p-4 rounded-xl text-l flex justify-center w-[8%]">${post.category_name}</post>
                <h2 class="text-2xl text-slate-700 font-bold mt-[2%]">${post.title}</h2>
                <p class="mt-[2%] text-lg text-justify">${post.body}</p>
                <div class="flex flex-col">
                <p class="text-right text-[14px]">${post.author}</p>
                <p class="text-right text-[14px]">${post.created_at}</p>
                </div>
                <div class="flex w-full justify-center items-center">
                <a class="text-center border-solid-2 text-white bg-sky-900 rounded-xl p-4 m-4'" href="edit-post.html?id=${post.id}">Modifier</a>   
                <a href="delete-post.html?id=${post.id}" class="text-center border-solid-2 text-white bg-sky-900 rounded-xl p-4 m-4">Supprimer</a>
                </div>
                </div>
            `;
        postsContainer.appendChild(postElement);
      });

      // Extraire les informations de pagination de la réponse JSON
      const pagination = data.pagination;
      const totalPages = pagination.total_pages;
      const currentPage = pagination.current_page;

      // Générer les liens vers les pages précédentes et suivantes, ainsi que vers les pages intermédiaires si nécessaire
      let paginationHtml = '<div class="pagination">';

      if (currentPage > 1) {
        paginationHtml +=
          '<a href="?page=' + (currentPage - 1) + '">Précédent</a>';
      }

      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
          paginationHtml +=
            '<a class="text-center border-solid-2 text-white bg-sky-900 rounded-xl p-4 m-4"  href="?page=' +
            i +
            '">' +
            i +
            "</a>";
        } else {
          paginationHtml +=
            '<a class="text-center border-solid-2 text-white bg-sky-900 rounded-xl p-4 m-4"  href="?page=' +
            i +
            '">' +
            i +
            "</a>";
        }
      }

      if (currentPage < totalPages) {
        paginationHtml +=
          '<a class="text-center border-solid-2 text-white bg-sky-900 rounded-xl p-4 m-4" href="?page=' +
          (currentPage + 1) +
          '">Suivant</a>';
      }

      paginationHtml += "</div>";

      // Insérer les boutons de pagination dans votre page HTML
      document.getElementById("pagination-container").innerHTML =
        paginationHtml;
    })
    .catch((error) =>
      console.error("Erreur lors du chargement des articles:", error)
    );
}
