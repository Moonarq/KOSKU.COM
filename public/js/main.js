// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Header scroll effect
const header = document.querySelector('.header');
if (header) {
  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      header.style.background = 'rgba(255, 255, 255, 0.98)';
      header.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.15)';
    } else {
      header.style.background = 'rgba(255, 255, 255, 0.95)';
      header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
    }
  });
}

// Fade in animation on scroll
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, observerOptions);

document.querySelectorAll('.fade-in').forEach(el => {
  observer.observe(el);
});

// Search functionality
const searchBtn = document.querySelector('.search-btn');
const searchInput = document.querySelector('.search-box input');
if (searchBtn && searchInput) {
  searchBtn.addEventListener('click', () => {
    const searchTerm = searchInput.value;
    if (searchTerm.trim()) {
      alert(`Mencari kos: "${searchTerm}"\n\nFitur pencarian akan diimplementasikan di versi Laravel.`);
    } else {
      alert('Silakan masukkan kata kunci pencarian terlebih dahulu.');
    }
  });
}

// Property card hover effect
document.querySelectorAll('.property-card').forEach(card => {
  card.addEventListener('mouseenter', () => {
    card.style.transform = 'translateY(-10px) scale(1.02)';
  });

  card.addEventListener('mouseleave', () => {
    card.style.transform = 'translateY(0) scale(1)';
  });
});

// Feature card animation delay
document.querySelectorAll('.feature-card').forEach((card, index) => {
  card.style.animationDelay = `${index * 0.1}s`;
});

// Dynamic typing effect for hero title
function typeWriter(element, text, speed = 100) {
  let i = 0;
  element.innerHTML = '';

  function type() {
    if (i < text.length) {
      element.innerHTML += text.charAt(i);
      i++;
      setTimeout(type, speed);
    }
  }

  type();
}

window.addEventListener('load', () => {
  const heroTitle = document.querySelector('.hero h1');
  if (heroTitle) {
    setTimeout(() => {
      const originalText = heroTitle.textContent;
      typeWriter(heroTitle, originalText, 80);
    }, 1000);
  }
});

// Floating animation disabled - was causing unwanted visual glitch every 5 seconds
// const randomCard = cards[Math.floor(Math.random() * cards.length)];
// randomCard.style.animation = 'float 2s ease-in-out';

// Parallax effect for hero section
window.addEventListener('scroll', () => {
  const scrolled = window.pageYOffset;
  const parallaxElements = document.querySelectorAll('.floating');
  parallaxElements.forEach(element => {
    const speed = 0.5;
    element.style.transform = `translateY(${scrolled * speed}px)`;
  });
});

// Dropdown toggle menu
document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("dropdownToggle");
  const dropdownMenu = document.getElementById("dropdownMenu");

  if (!toggleBtn || !dropdownMenu) return;

  let isOpen = false;

  toggleBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    isOpen = !isOpen;
    dropdownMenu.classList.toggle("show", isOpen);
    toggleBtn.classList.toggle("open", isOpen);
  });

  dropdownMenu.addEventListener("mouseleave", function () {
    if (isOpen) {
      dropdownMenu.classList.remove("show");
      toggleBtn.classList.remove("open");
      isOpen = false;
    }
  });

  document.addEventListener("click", function (e) {
    if (isOpen && !dropdownMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
      dropdownMenu.classList.remove("show");
      toggleBtn.classList.remove("open");
      isOpen = false;
    }
  });
});

// --- NEW Carousel Button Functionality (robust, always works, with forced scroll CSS and debug) ---
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.properties-grid').forEach(grid => {
    grid.style.display = 'flex';
    grid.style.flexWrap = 'nowrap';
    grid.style.overflowX = 'auto';
    grid.style.scrollBehavior = 'smooth';
  });
  document.body.addEventListener('click', function(e) {
    const btn = e.target.closest('.carousel-btn, .carousel-btn-new');
    if (!btn) return;
    const isPrev = btn.classList.contains('prev-btn') || btn.classList.contains('prev-btn-new');
    const isNext = btn.classList.contains('next-btn') || btn.classList.contains('next-btn-new');
    if (!isPrev && !isNext) return;
    let sectionHeader = btn.closest('.section-header');
    let carouselContainer = null;
    if (sectionHeader) {
      let sibling = sectionHeader.nextElementSibling;
      while (sibling) {
        if (sibling.classList && sibling.classList.contains('carousel-container')) {
          carouselContainer = sibling;
          break;
        }
        sibling = sibling.nextElementSibling;
      }
    }
    if (!carouselContainer) {
      carouselContainer = btn.closest('.carousel-container');
    }
    if (!carouselContainer) {
      carouselContainer = document.querySelector('.carousel-container');
    }
    if (!carouselContainer) return;
    const propertiesGrid = carouselContainer.querySelector('.properties-grid');
    if (!propertiesGrid) return;
    const cards = Array.from(propertiesGrid.querySelectorAll('.property-card'));
    if (cards.length < 2) return;
    // Simpan index aktif di dataset
    let currentIdx = parseInt(propertiesGrid.dataset.carouselIdx || '0', 10);
    if (isNext) {
      currentIdx = Math.min(currentIdx + 1, cards.length - 1);
    } else if (isPrev) {
      currentIdx = Math.max(currentIdx - 1, 0);
    }
    propertiesGrid.dataset.carouselIdx = currentIdx;
    cards[currentIdx].scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
  });
});


