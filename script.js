// Obsługa menu mobilnego
const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        // Przełączanie nawigacji
        nav.classList.toggle('nav-active');

        // Animacja linków
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
            }
        });

        // Animacja ikony burgera
        burger.classList.toggle('toggle');
    });
}

navSlide();

// Animacje podczas przewijania (Intersection Observer)
const faders = document.querySelectorAll('.fade-in');

const appearOptions = {
    threshold: 0.2, // Element musi być widoczny w 20% żeby animacja ruszyła
    rootMargin: "0px 0px -50px 0px"
};

const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
    entries.forEach(entry => {
        if (!entry.isIntersecting) {
            return;
        } else {
            entry.target.classList.add('visible');
            appearOnScroll.unobserve(entry.target);
        }
    });
}, appearOptions);

faders.forEach(fader => {
    appearOnScroll.observe(fader);
});

// Prosta obsługa formularza (tylko alert, bo brak backendu)
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Dziękujemy za wiadomość! Skontaktujemy się wkrótce.');
    this.reset();
});