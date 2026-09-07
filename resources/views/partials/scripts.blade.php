<script>
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('i');
    let darkMode = localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : true;

    function applyTheme() {
        document.documentElement.setAttribute('data-theme', darkMode ? 'dark' : 'light');
        if (themeIcon) themeIcon.className = darkMode ? 'fas fa-moon' : 'fas fa-sun';
        localStorage.setItem('theme', darkMode ? 'dark' : 'light');
    }
    applyTheme();

    themeToggle?.addEventListener('click', () => {
        darkMode = !darkMode;
        applyTheme();
    });

    // Mobile Menu
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    menuToggle?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('open');
        const icon = menuToggle.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        }
    });

    document.querySelectorAll('.mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu?.classList.remove('open');
            const icon = menuToggle?.querySelector('i');
            if (icon) {
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            }
        });
    });

    // Header Shadow
    const header = document.getElementById('header');
    window.addEventListener('scroll', () => {
        if (!header) return;
        if (window.scrollY > 50) header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.4)';
        else header.style.boxShadow = 'none';
    });

    // Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>