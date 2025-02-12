document.getElementById('toggle-btn').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('collapsed');
    });
/*
SIDEBARS &  
    SUBMENU
        FUNCTIONS
*/

function toggleSubMenu(event) {
  event.preventDefault(); // Prevent the default link behavior
  var subMenu = document.getElementById("payrollSubMenu");
  var toggleIcon = document.getElementById("toggleIcon");
  var sidebar = document.getElementById("sidebar");

  // Check if the sidebar is collapsed and expand it
  if (sidebar.classList.contains("collapsed")) {
      sidebar.classList.remove("collapsed");
      document.querySelector(".main-content").classList.remove("collapsed");
  }

  if (subMenu.style.display === "none" || subMenu.style.display === "") {
      subMenu.style.display = "block";
      toggleIcon.classList.remove("fa-chevron-right");
      toggleIcon.classList.add("fa-chevron-down");
      // Store submenu state in localStorage
      localStorage.setItem('submenuState', 'open');
  } else {
      subMenu.style.display = "none";
      toggleIcon.classList.remove("fa-chevron-down");
      toggleIcon.classList.add("fa-chevron-right");
      // Store submenu state in localStorage
      localStorage.setItem('submenuState', 'closed');
  }
}

// Function to handle navigation
// Function to handle navigation
function navigate(page) {
  document.querySelectorAll('.sidebar a').forEach(link => {
      link.classList.remove('active');
  });

  event.currentTarget.classList.add('active');

  const redirectUrl = `redirect.php?page=${encodeURIComponent(page)}`;

  fetch(redirectUrl)
      .then(response => response.text())
      .then(html => {
          const mainContent = document.getElementById('main-content');
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newContent = doc.querySelector('#main-content')?.innerHTML;

          if (newContent) {
              mainContent.innerHTML = newContent;
              window.scrollTo(0, 0);
              history.pushState({}, '', redirectUrl);
          } else {
              console.error('Error: Could not find #main-content in response');
          }
      })
      .catch(error => console.error('Error loading page:', error));
}


 // Function to check if current page is a submenu page
 function isSubmenuPage() {
  const submenuPages = [
      'sss_Report.php',
      'pag-ibig_Report.php',
      'philhealth_Report.php',
      'tax_Report.php',
      'top_sheet.php',
      'journal_entry.php'
  ];
  const currentPage = window.location.pathname.split('/').pop();
  return submenuPages.includes(currentPage);
}


 // Set active state and restore submenu state on page load
 document.addEventListener('DOMContentLoaded', () => {
  const currentPage = window.location.pathname.split('/').pop();
  const currentLink = document.querySelector(`.sidebar a[href*="${currentPage}"]`);
  if (currentLink) {
      currentLink.classList.add('active');
  }

  // Restore submenu state if on a submenu page or if previously opened
  const submenuState = localStorage.getItem('submenuState');
  const subMenu = document.getElementById("payrollSubMenu");
  const toggleIcon = document.getElementById("toggleIcon");

  if (isSubmenuPage() || submenuState === 'open') {
      subMenu.style.display = "block";
      toggleIcon.classList.remove("fa-chevron-right");
      toggleIcon.classList.add("fa-chevron-down");
  }
});


function confirmLogout() {
  Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, Logout"
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = "logout.php";
      }
  });
}