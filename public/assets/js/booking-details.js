/**
 * PS Rental - Booking Details Page JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
    // Initialize copy booking ID
    initCopyBookingId()
  })
  
  /**
   * Initialize copy booking ID functionality
   */
  function initCopyBookingId() {
    const bookingId = document.querySelector(".booking-id")
  
    if (!bookingId) return
  
    // Make booking ID clickable
    bookingId.style.cursor = "pointer"
    bookingId.title = "Click to copy booking ID"
  
    // Add click event listener
    bookingId.addEventListener("click", () => {
      // Extract booking ID number
      const idText = bookingId.textContent
      const idNumber = idText.replace("Booking #", "")
  
      // Copy to clipboard
      navigator.clipboard
        .writeText(idNumber)
        .then(() => {
          // Show success message
          const originalText = bookingId.textContent
          bookingId.textContent = "Copied!"
  
          // Reset text after 2 seconds
          setTimeout(() => {
            bookingId.textContent = originalText
          }, 2000)
        })
        .catch((err) => {
          console.error("Failed to copy booking ID: ", err)
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
  
  