document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const sidebarLinks = document.querySelectorAll('.sidebar nav ul li a');

  if (!toggleBtn || !sidebar) return;

  // Load saved sidebar state
  const savedState = localStorage.getItem('sidebar-collapsed');
  const isMobile = window.innerWidth <= 768;

  if (savedState === 'true' && !isMobile) {
    sidebar.classList.add('collapsed');
    document.body.classList.add('sidebar-collapsed');
  }

  // Toggle sidebar
  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');

    const isCollapsed = sidebar.classList.contains('collapsed');
    localStorage.setItem('sidebar-collapsed', isCollapsed);

    if (isMobile) {
      overlay?.classList.toggle('active', !isCollapsed);
    }
  });

  // Overlay click (mobile only)
  overlay?.addEventListener('click', () => {
    sidebar.classList.add('collapsed');
    overlay.classList.remove('active');
    localStorage.setItem('sidebar-collapsed', true);
  });

  // Highlight current page
  const currentPage = window.location.pathname.split('/').pop();
  sidebarLinks.forEach(link => {
    const hrefPage = link.getAttribute('href').split('/').pop();
    if (hrefPage === currentPage) {
      link.classList.add('active');
    }
  });

  // Prevent sidebar icons from shifting on collapse
  sidebarLinks.forEach(link => {
    link.querySelector('i')?.classList.add('fixed-width');
  });
});
