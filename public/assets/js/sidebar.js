document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const sidebarLinks = document.querySelectorAll('.sidebar nav ul li a');
  
    if (!toggleBtn || !sidebar) return; // Safeguard
  
    // 👉 Load saved sidebar state on page load
    const savedState = localStorage.getItem('sidebar-collapsed');
    if (savedState === 'true') {
      sidebar.classList.add('collapsed');
    }
  
    // 👉 Toggle only when hamburger is clicked
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      const isCollapsed = sidebar.classList.contains('collapsed');
      localStorage.setItem('sidebar-collapsed', isCollapsed);
  
      // Show overlay only in mobile
      if (window.innerWidth <= 768) {
        overlay?.classList.toggle('active', !isCollapsed);
      }
    });
  
    // 👉 On overlay click (mobile only): close sidebar
    overlay?.addEventListener('click', () => {
      sidebar.classList.add('collapsed');
      overlay.classList.remove('active');
      localStorage.setItem('sidebar-collapsed', true);
    });
  
    // 👉 Highlight active page only
    const currentPage = window.location.pathname.split('/').pop();
    sidebarLinks.forEach(link => {
      const hrefPage = link.getAttribute('href').split('/').pop();
      if (hrefPage === currentPage) {
        link.classList.add('active');
      }
    });
  });
  