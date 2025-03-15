/**
 * PS Rental - Global JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile menu
    initMobileMenu();
    
    // Initialize dropdowns
    initDropdowns();
    
    // Initialize flash messages
    initFlashMessages();
});

/**
 * Initialize mobile menu
 */
function initMobileMenu() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenuToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            
            // Toggle aria-expanded attribute
            const expanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true' || false;
            mobileMenuToggle.setAttribute('aria-expanded', !expanded);
        });
    }
}

/**
 * Initialize dropdowns
 */
function initDropdowns() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdown = this.closest('.dropdown');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown.active').forEach(activeDropdown => {
                if (activeDropdown !== dropdown) {
                    activeDropdown.classList.remove('active');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('active');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown.active').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
}

/**
 * Initialize flash messages
 */
function initFlashMessages() {
    const flashMessages = document.querySelectorAll('.flash-message');
    
    flashMessages.forEach(message => {
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                message.style.display = 'none';
            }, 500);
        }, 5000);
    });
}

/**
 * Format currency
 * @param {number} amount - Amount to format
 * @param {string} currency - Currency code (default: 'IDR')
 * @returns {string} Formatted currency string
 */
function formatCurrency(amount, currency = 'IDR') {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

/**
 * Check if date is a weekend
 * @param {Date} date - Date to check
 * @returns {boolean} True if weekend, false otherwise
 */
function isWeekend(date) {
    const day = date.getDay();
    return day === 0 || day === 6; // 0 is Sunday, 6 is Saturday
}

/**
 * Calculate price with weekend surcharge
 * @param {number} basePrice - Base price
 * @param {Date} date - Date to check for weekend
 * @returns {Object} Object with basePrice, weekendSurcharge, and totalPrice
 */
function calculatePrice(basePrice, date) {
    const weekendSurcharge = isWeekend(date) ? basePrice * 0.2 : 0;
    const totalPrice = basePrice + weekendSurcharge;
    
    return {
        basePrice,
        weekendSurcharge,
        totalPrice
    };
}

/**
 * Validate form
 * @param {HTMLFormElement} form - Form to validate
 * @returns {boolean} True if valid, false otherwise
 */
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    // Remove all existing error messages
    form.querySelectorAll('.form-error').forEach(error => {
        error.remove();
    });
    
    // Reset all fields
    form.querySelectorAll('.form-control').forEach(field => {
        field.classList.remove('error');
    });
    
    // Validate each required field
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error');
            
            // Add error message
            const errorMessage = field.getAttribute('data-error-message') || 'This field is required';
            const errorElement = document.createElement('div');
            errorElement.className = 'form-error';
            errorElement.textContent = errorMessage;
            
            field.parentNode.appendChild(errorElement);
        }
    });
    
    // Validate email fields
    form.querySelectorAll('input[type="email"]').forEach(field => {
        if (field.value.trim() && !validateEmail(field.value)) {
            isValid = false;
            field.classList.add('error');
            
            // Add error message
            const errorMessage = field.getAttribute('data-error-message') || 'Please enter a valid email address';
            const errorElement = document.createElement('div');
            errorElement.className = 'form-error';
            errorElement.textContent = errorMessage;
            
            field.parentNode.appendChild(errorElement);
        }
    });
    
    return isValid;
}

/**
 * Validate email
 * @param {string} email - Email to validate
 * @returns {boolean} True if valid, false otherwise
 */
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
