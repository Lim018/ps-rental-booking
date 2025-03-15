/**
 * PS Rental - Validate Booking Page JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
    // Initialize tabs
    initTabs()
  
    // Initialize QR scanner
    initQRScanner()
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
  
        // Stop QR scanner when switching tabs
        if (tabId !== "scan" && window.scanner) {
          window.scanner.stop()
        } else if (tabId === "scan" && window.scanner) {
          window.scanner.start()
        }
      })
    })
  }
  
  /**
   * Initialize QR scanner
   */
  function initQRScanner() {
    const qrReader = document.getElementById("qr-reader")
    const qrResults = document.getElementById("qr-reader-results")
  
    if (!qrReader || !qrResults) return
  
    // Check if HTML5 QR Scanner library is loaded
    if (typeof Html5QrcodeScanner === "undefined") {
      // Load the library dynamically
      const script = document.createElement("script")
      script.src = "https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"
      script.onload = setupScanner
      document.head.appendChild(script)
    } else {
      setupScanner()
    }
  
    function setupScanner() {
      // Create QR scanner
      try {
        window.scanner = new Html5QrcodeScanner("qr-reader", {
          fps: 10,
          qrbox: 250,
        })
  
        // Start scanner
        window.scanner.render(onScanSuccess, onScanError)
      } catch (error) {
        console.error("Error initializing QR scanner:", error)
        qrResults.innerHTML = `<div class="alert alert-danger">
                  <p>Failed to initialize QR Scanner. Please check the console for errors.</p>
              </div>`
      }
  
      // Success callback
      function onScanSuccess(decodedText, decodedResult) {
        // Stop scanner
        window.scanner.pause()
  
        // Display result
        qrResults.innerHTML = `<div class="alert alert-success">
                  <p>QR Code detected!</p>
                  <p>Booking ID: ${decodedText}</p>
                  <p>Redirecting to validation page...</p>
              </div>`
  
        // Redirect to validation page with booking ID
        setTimeout(() => {
          window.location.href = `/admin/validate-booking?booking_id=${decodedText}`
        }, 1500)
      }
  
      // Error callback
      function onScanError(error) {
        // Handle scan error
        console.warn(`QR scan error: ${error}`)
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
  
  