/**
 * PS Rental - Booking Check Page JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
    // Initialize tabs
    initTabs()
  })
  
  /**
   * Initialize tabs
   */
  function initTabs() {
    const tabButtons = document.querySelectorAll(".tab-btn")
    const tabContents = document.querySelectorAll(".tab-content")
  
    if (!tabButtons.length || !tabContents.length) return
  
    // Tab button click handler
    tabButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const tabId = this.getAttribute("data-tab")
  
        // Remove active class from all buttons and contents
        tabButtons.forEach((btn) => btn.classList.remove("active"))
        tabContents.forEach((content) => content.classList.remove("active"))
  
        // Add active class to clicked button and corresponding content
        this.classList.add("active")
        document.getElementById(`${tabId}-tab`).classList.add("active")
      })
    })
  }
  
  /**
   * Format date
   * @param {string} dateString - Date string in YYYY-MM-DD format
   * @returns {string} Formatted date string
   */
  function formatDate(dateString) {
    const date = new Date(dateString)
    return date.toLocaleDateString("en-US", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    })
  }
  
  /**
   * Format currency
   * @param {number} amount - Amount to format
   * @param {string} currency - Currency code (default: 'IDR')
   * @returns {string} Formatted currency string
   */
  function formatCurrency(amount, currency = "IDR") {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: currency,
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    }).format(amount)
  }
  
  