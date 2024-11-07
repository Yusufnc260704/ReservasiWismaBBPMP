// Modal image viewer
const images = document.querySelectorAll(".image-grid img");
const modal = document.getElementById("modal");
const modalImg = document.getElementById("modal-img");
const closeBtn = document.querySelector(".close");

images.forEach((image) => {
  image.addEventListener("click", () => {
    modal.style.display = "flex";
    modalImg.src = image.src;
  });
});

closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});
