// Enhanced sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const overlay = document.getElementById('overlay');
  const mainContent = document.querySelector('.main-content');
  
  // Function to check window width
  function checkWidth() {
    if (window.innerWidth < 768) {
      sidebar.classList.add('collapsed');
      if (mainContent) {
        mainContent.style.marginLeft = '0';
      }
    }
  }
  
  // Toggle sidebar on button click
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      
      // On mobile, we also toggle the overlay
      if (window.innerWidth < 768) {
        overlay.classList.toggle('show');
      }
    });
  }
  
  // Hide sidebar when clicking on overlay (mobile only)
  if (overlay) {
    overlay.addEventListener('click', function() {
      sidebar.classList.add('collapsed');
      overlay.classList.remove('show');
    });
  }
  
  // Initial check
  checkWidth();
  
  // Check on resize
  window.addEventListener('resize', checkWidth);
});
