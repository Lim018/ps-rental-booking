/**
 * PS Rental - User Bookings Page JavaScript
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
  
        // Save active tab to localStorage
        localStorage.setItem("activeBookingTab", tabId)
      })
    })
  
    // Check if there's a saved active tab in localStorage
    const savedTab = localStorage.getItem("activeBookingTab")
  
    if (savedTab) {
      // Activate saved tab
      const savedTabButton = document.querySelector(`.tab-btn[data-tab="${savedTab}"]`)
      const savedTabContent = document.getElementById(`${savedTab}-tab`)
  
      if (savedTabButton && savedTabContent) {
        tabButtons.forEach((btn) => btn.classList.remove("active"))
        tabContents.forEach((content) => content.classList.remove("active"))
  
        savedTabButton.classList.add("active")
        savedTabContent.classList.add("active")
      }
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
   * Calculate time remaining until booking
   * @param {string} dateString - Date string in YYYY-MM-DD format
   * @param {string} timeString - Time string in HH:MM - HH:MM format
   * @returns {string} Time remaining string
   */
  function getTimeRemaining(dateString, timeString) {
    const bookingDate = new Date(dateString)
    const startTime = timeString.split(" - ")[0]
    const [hours, minutes] = startTime.split(":")
  
    bookingDate.setHours(Number.parseInt(hours))
    bookingDate.setMinutes(Number.parseInt(minutes))
  
    const now = new Date()
    const diffMs = bookingDate - now
  
    if (diffMs <= 0) {
      return "Booking time has passed"
    }
  
    const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24))
    const diffHours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
    const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60))
  
    if (diffDays > 0) {
      return `${diffDays} day${diffDays > 1 ? "s" : ""} ${diffHours} hour${diffHours > 1 ? "s" : ""} remaining`
    } else if (diffHours > 0) {
      return `${diffHours} hour${diffHours > 1 ? "s" : ""} ${diffMinutes} minute${diffMinutes > 1 ? "s" : ""} remaining`
    } else {
      return `${diffMinutes} minute${diffMinutes > 1 ? "s" : ""} remaining`
    }
  }
  
  // Add time remaining to upcoming bookings
  document.addEventListener("DOMContentLoaded", () => {
    const upcomingBookings = document.querySelectorAll("#upcoming-tab .booking-card")
  
    upcomingBookings.forEach((booking) => {
      const dateElement = booking.querySelector(".booking-date")
      const timeElement = booking.querySelector(".booking-time")
  
      if (dateElement && timeElement) {
        const dateString = dateElement.getAttribute("data-date")
        const timeString = timeElement.textContent
  
        if (dateString && timeString) {
          const timeRemaining = getTimeRemaining(dateString, timeString)
  
          const remainingElement = document.createElement("div")
          remainingElement.className = "booking-time-remaining"
          remainingElement.textContent = timeRemaining
  
          timeElement.parentNode.appendChild(remainingElement)
        }
      }
    })
  })
  
  