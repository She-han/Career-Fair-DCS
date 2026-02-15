import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Make GSAP available globally
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: false,
    mirror: true,
    offset: 100,
    delay: 0,
    anchorPlacement: 'top-bottom',
});

// Refresh AOS on page load
window.addEventListener('load', () => {
    AOS.refresh();
    initGSAPAnimations();
});

// Initialize GSAP Animations
function initGSAPAnimations() {
    // Hero text animation
    gsap.from('.hero-title', {
        duration: 1.2,
        y: 50,
        opacity: 0,
        ease: 'power4.out',
        delay: 0.2
    });

    // CTA buttons animation
    gsap.from('.cta-button', {
        duration: 0.8,
        y: 30,
        opacity: 0,
        stagger: 0.2,
        ease: 'back.out(1.7)',
        delay: 0.8
    });

    // Carousel cards animation with ScrollTrigger
    gsap.utils.toArray('.carousel-slide').forEach((card, index) => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: 'top 90%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.6,
            y: 50,
            opacity: 0,
            delay: index * 0.1,
            ease: 'power2.out'
        });
    });

    // Feature cards with scale and rotate
    gsap.utils.toArray('.feature-card').forEach((card, index) => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.8,
            scale: 0.8,
            rotation: 10,
            opacity: 0,
            delay: index * 0.15,
            ease: 'back.out(1.5)'
        });
    });

    // Stats counter animation
    gsap.utils.toArray('.stat-number').forEach((stat) => {
        const target = parseInt(stat.textContent);
        gsap.from(stat, {
            scrollTrigger: {
                trigger: stat,
                start: 'top 80%',
                toggleActions: 'play none none none'
            },
            textContent: 0,
            duration: 2,
            snap: { textContent: 1 },
            ease: 'power1.inOut',
            onUpdate: function() {
                stat.textContent = Math.ceil(this.targets()[0].textContent);
            }
        });
    });

    // Parallax effect on background blobs
    gsap.utils.toArray('.animate-blob').forEach((blob, index) => {
        gsap.to(blob, {
            scrollTrigger: {
                trigger: blob,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1
            },
            y: (index % 2 === 0) ? -100 : 100,
            ease: 'none'
        });
    });
}

// Register Alpine plugins
Alpine.plugin(collapse);

// Make Alpine available globally
window.Alpine = Alpine;
Alpine.start();

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                gsap.to(window, {
                    duration: 1,
                    scrollTo: href,
                    ease: 'power2.inOut'
                });
            }
        });
    });
});

// Enhanced parallax effect on scroll
let ticking = false;
window.addEventListener('scroll', () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            const scrolled = window.pageYOffset;
            
            // Parallax for hero elements
            const parallaxElements = document.querySelectorAll('.parallax');
            parallaxElements.forEach(el => {
                const speed = el.dataset.speed || 0.5;
                el.style.transform = `translateY(${scrolled * speed}px)`;
            });

            ticking = false;
        });
        ticking = true;
    }
});

// Log successful initialization
console.log('✨ Career Fair DCS - Enhanced with GSAP, AOS & Advanced Animations');

