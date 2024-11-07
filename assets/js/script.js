// Data berita (contoh)
const latestNews = [
  {
    title: "Wisma R.A Kartini",
    summary: "Harga : 100rb/malam",
    image: "assets/img/kartini1.jpg",
    link: "kartini.html",
  },
  {
    title: "Wisma Cut Meutia",
    summary: "Harga : 100rb/malam",
    image: "assets/img/meutia1.jpg",
    link: "meutia.html",
  },
  {
    title: "Wisma Rasuna Said",
    summary: "Harga : 100rb/malam",
    image: "assets/img/rasuna1.jpg",
    link: "rasuna.html",
  },
  {
    title: "Wisma Dewi Sartika",
    summary: "Harga : 100rb/malam",
    image: "assets/img/sartika1.jpg",
    link: "sartika.html",
  },
  {
    title: "Wisma Cut Nyak Dien",
    summary: "Harga : 100rb/malam",
    image: "assets/img/dien1.jpg",
    link: "dien.html",
  },
];

// Fungsi untuk menambahkan berita ke grid
function addNewsToGrid() {
  const newsGrid = document.querySelector(".news-grid");
  latestNews.forEach((news) => {
    const article = document.createElement("article");
    article.innerHTML = `
            <img src="${news.image}" alt="${news.title}">
            <h3>${news.title}</h3>
            <p>${news.summary}</p>
            <a href="${news.link}" class="read-more">Info selengkapnya</a>
        `;
    newsGrid.appendChild(article);
  });
}

// Panggil fungsi saat halaman dimuat
window.addEventListener("load", addNewsToGrid);

// Fungsi untuk animasi scroll yang halus
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth",
    });
  });
});
