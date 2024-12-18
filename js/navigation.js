document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.querySelector('.nav-links');

    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }

    // Mobile Menü Funktionalität
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const closeMenu = document.querySelector('.close-menu');
    
    if (menuToggle && mobileMenu && closeMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        closeMenu.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Smooth Scrolling für Anker-Links
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Nur für interne Links
            if (href.startsWith('#')) {
                e.preventDefault();
                const targetId = href.replace('#', '');
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Schließe das mobile Menü, wenn es offen ist
                    if (mobileMenu && mobileMenu.classList.contains('active')) {
                        mobileMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            }
        });
    });

    // Aktive Navigation markieren
    function setActiveNavItem() {
        const sections = document.querySelectorAll('section[id]');
        const navItems = document.querySelectorAll('.nav-links a');
        
        let currentSection = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (window.pageYOffset >= sectionTop - 200) {
                currentSection = section.getAttribute('id');
            }
        });
        
        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href').includes(currentSection)) {
                item.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', setActiveNavItem);
    setActiveNavItem();
});
