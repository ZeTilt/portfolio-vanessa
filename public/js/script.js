document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
  });

 
  const burgerBtn = document.querySelector('.burger');
const menu = document.getElementById('mobile-menu');
const icon = document.getElementById('burger-icon');

burgerBtn.addEventListener('click', () => {
  menu.classList.toggle('open');
  icon.textContent = menu.classList.contains('open') ? '✖' : '☰';
});


  console.log("Script chargé !");
});

// Version ajustée avec meilleure sensibilité au mouvement de souris
const slider = document.getElementById("slider");
const afterImage = document.getElementById("afterImage");
const handle = document.getElementById("handle");

let isRotated = false;

let isInside = false;

slider.addEventListener("mouseenter", () => {
  isInside = true;
});

slider.addEventListener("mouseleave", () => {
  isInside = false;
});

slider.addEventListener("mousemove", (e) => {
  if (!isInside) return; // Ne fait rien si la souris n'est pas dans la zone

  const rect = slider.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const percent = Math.max(0, Math.min(100, (x / rect.width) * 100));

  afterImage.style.clipPath = `inset(0 ${100 - percent}% 0 0)`;
  handle.style.left = `${percent}%`;

  if (percent >= 99 && !isRotated) {
    handle.style.transform = "translateX(-50%) rotate(180deg)";
    isRotated = true;
  } else if (percent <= 1 && isRotated) {
    handle.style.transform = "translateX(-50%) rotate(0deg)";
    isRotated = false;
  }
});

