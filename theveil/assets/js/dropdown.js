// Control del dropdown de accesorios
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.dropdown');
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdownContent = document.querySelector('.dropdown-content-grid');
    
    let closeTimeout;
    let isMouseInDropdown = false;
  
    function showDropdown() {
      clearTimeout(closeTimeout);
      dropdownContent.style.display = 'flex';
      setTimeout(() => {
        dropdownContent.style.opacity = '1';
        dropdownContent.style.visibility = 'visible';
      }, 10);
      isMouseInDropdown = true;
    }
  
    function hideDropdown() {
      closeTimeout = setTimeout(function() {
        if (!isMouseInDropdown) {
          dropdownContent.style.opacity = '0';
          dropdownContent.style.visibility = 'hidden';
          setTimeout(() => {
            dropdownContent.style.display = 'none';
          }, 300);
        }
      }, 300);
    }
  
    // Event listeners
    if (dropdownToggle) {
      dropdownToggle.addEventListener('mouseenter', showDropdown);
      dropdownToggle.addEventListener('mouseleave', function() {
        isMouseInDropdown = false;
        hideDropdown();
      });
    }
  
    if (dropdown) {
      dropdown.addEventListener('mouseenter', function() {
        isMouseInDropdown = true;
        showDropdown();
      });
  
      dropdown.addEventListener('mouseleave', function() {
        isMouseInDropdown = false;
        hideDropdown();
      });
    }
  
    if (dropdownContent) {
      dropdownContent.addEventListener('mouseenter', function() {
        isMouseInDropdown = true;
        clearTimeout(closeTimeout);
      });
  
      dropdownContent.addEventListener('mouseleave', function() {
        isMouseInDropdown = false;
        hideDropdown();
      });
    }
  
    // Cerrar al hacer click fuera
    document.addEventListener('click', function(event) {
      if (dropdown && !dropdown.contains(event.target)) {
        dropdownContent.style.opacity = '0';
        dropdownContent.style.visibility = 'hidden';
        setTimeout(() => {
          dropdownContent.style.display = 'none';
        }, 300);
        isMouseInDropdown = false;
      }
    });
  });