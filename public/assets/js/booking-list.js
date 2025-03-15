/**
 * PS Rental - Booking List Page JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
    // Initialize filters
    initFilters()
  })
  
  /**
   * Initialize filters
   */
  function initFilters() {
    const statusFilter = document.getElementById("status-filter")
    const dateFilter = document.getElementById("date-filter")
    const serviceFilter = document.getElementById("service-filter")
    const applyFiltersBtn = document.getElementById("apply-filters")
    const resetFiltersBtn = document.getElementById("reset-filters")
  
    if (!statusFilter || !dateFilter || !serviceFilter || !applyFiltersBtn || !resetFiltersBtn) return
  
    // Apply filters button click handler
    applyFiltersBtn.addEventListener("click", () => {
      const status = statusFilter.value
      const date = dateFilter.value
      const service = serviceFilter.value
  
      // Build query string
      const queryParams = []
  
      if (status) {
        queryParams.push(`status=${status}`)
      }
  
      if (date) {
        queryParams.push(`date=${date}`)
      }
  
      if (service) {
        queryParams.push(`service=${service}`)
      }
  
      // Redirect to filtered URL
      const queryString = queryParams.length > 0 ? `?${queryParams.join("&")}` : ""
      window.location.href = `${window.location.pathname}${queryString}`
    })
  
    // Reset filters button click handler
    resetFiltersBtn.addEventListener("click", () => {
      statusFilter.value = ""
      dateFilter.value = ""
      serviceFilter.value = ""
  
      // Redirect to base URL
      window.location.href = window.location.pathname
    })
  
    // Set initial filter values from URL parameters
    const urlParams = new URLSearchParams(window.location.search)
  
    if (urlParams.has("status")) {
      statusFilter.value = urlParams.get("status")
    }
  
    if (urlParams.has("date")) {
      dateFilter.value = urlParams.get("date")
    }
  
    if (urlParams.has("service")) {
      serviceFilter.value = urlParams.get("service")
    }
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
  
  /**
   * Add data labels to booking columns for mobile view
   */
  function addDataLabels() {
    const bookingItems = document.querySelectorAll(".booking-item")
  
    bookingItems.forEach((item) => {
      const columns = item.querySelectorAll(".booking-column")
  
      columns.forEach((column) => {
        if (column.classList.contains("booking-id")) {
          column.setAttribute("data-label", "ID")
        } else if (column.classList.contains("booking-date")) {
          column.setAttribute("data-label", "Date & Time")
        } else if (column.classList.contains("booking-service")) {
          column.setAttribute("data-label", "Service")
        } else if (column.classList.contains("booking-customer")) {
          column.setAttribute("data-label", "Customer")
        } else if (column.classList.contains("booking-price")) {
          column.setAttribute("data-label", "Price")
        } else if (column.classList.contains("booking-status")) {
          column.setAttribute("data-label", "Status")
        }
      })
    })
  }
  
  // Call addDataLabels on page load and window resize
  document.addEventListener("DOMContentLoaded", addDataLabels)
  window.addEventListener("resize", addDataLabels)
  
  