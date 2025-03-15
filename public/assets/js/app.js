/**
 * PS Rental - Main JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
    // Initialize components
    initializeTooltips()
    initializeDropdowns()
    initializeModals()
    initializeCalendar()
    initializeServiceSelection()
    initializeTimeSlotSelection()
    initializeAnimations()
  
    // Handle form submissions
    setupFormValidation()
  })
  
  /**
   * Initialize tooltips
   */
  function initializeTooltips() {
    const tooltips = document.querySelectorAll("[data-tooltip]")
  
    tooltips.forEach((tooltip) => {
      tooltip.addEventListener("mouseenter", function () {
        const tooltipText = this.getAttribute("data-tooltip")
        const tooltipEl = document.createElement("div")
  
        tooltipEl.className = "absolute bg-gray-800 text-white text-xs rounded py-1 px-2 z-50"
        tooltipEl.innerHTML = tooltipText
        tooltipEl.style.bottom = "calc(100% + 5px)"
        tooltipEl.style.left = "50%"
        tooltipEl.style.transform = "translateX(-50%)"
  
        this.style.position = "relative"
        this.appendChild(tooltipEl)
      })
  
      tooltip.addEventListener("mouseleave", function () {
        const tooltipEl = this.querySelector(".absolute")
        if (tooltipEl) {
          tooltipEl.remove()
        }
      })
    })
  }
  
  /**
   * Initialize dropdowns
   */
  function initializeDropdowns() {
    const dropdowns = document.querySelectorAll("[data-dropdown]")
  
    dropdowns.forEach((dropdown) => {
      const trigger = dropdown.querySelector("[data-dropdown-trigger]")
      const content = dropdown.querySelector("[data-dropdown-content]")
  
      if (trigger && content) {
        trigger.addEventListener("click", (e) => {
          e.preventDefault()
          content.classList.toggle("hidden")
        })
  
        document.addEventListener("click", (e) => {
          if (!dropdown.contains(e.target)) {
            content.classList.add("hidden")
          }
        })
      }
    })
  }
  
  /**
   * Initialize modals
   */
  function initializeModals() {
    const modalTriggers = document.querySelectorAll("[data-modal-trigger]")
  
    modalTriggers.forEach((trigger) => {
      const modalId = trigger.getAttribute("data-modal-trigger")
      const modal = document.getElementById(modalId)
  
      if (modal) {
        const closeButtons = modal.querySelectorAll("[data-modal-close]")
  
        trigger.addEventListener("click", (e) => {
          e.preventDefault()
          modal.classList.remove("hidden")
          document.body.classList.add("overflow-hidden")
  
          // Fade in animation
          setTimeout(() => {
            modal.querySelector(".modal-content").classList.add("opacity-100")
            modal.querySelector(".modal-content").classList.remove("opacity-0", "translate-y-4")
          }, 10)
        })
  
        closeButtons.forEach((button) => {
          button.addEventListener("click", () => {
            modal.querySelector(".modal-content").classList.remove("opacity-100")
            modal.querySelector(".modal-content").classList.add("opacity-0", "translate-y-4")
  
            setTimeout(() => {
              modal.classList.add("hidden")
              document.body.classList.remove("overflow-hidden")
            }, 300)
          })
        })
  
        modal.addEventListener("click", (e) => {
          if (e.target === modal) {
            modal.querySelector(".modal-content").classList.remove("opacity-100")
            modal.querySelector(".modal-content").classList.add("opacity-0", "translate-y-4")
  
            setTimeout(() => {
              modal.classList.add("hidden")
              document.body.classList.remove("overflow-hidden")
            }, 300)
          }
        })
      }
    })
  }
  
  /**
   * Initialize calendar for booking
   */
  function initializeCalendar() {
    const calendarContainer = document.getElementById("booking-calendar")
  
    if (!calendarContainer) return
  
    const today = new Date()
    const currentMonth = today.getMonth()
    const currentYear = today.getFullYear()
  
    let selectedDate = null
  
    // Generate calendar
    generateCalendar(currentMonth, currentYear)
  
    // Previous month button
    const prevMonthBtn = document.getElementById("prev-month")
    if (prevMonthBtn) {
      prevMonthBtn.addEventListener("click", () => {
        let month = Number.parseInt(calendarContainer.getAttribute("data-month"))
        let year = Number.parseInt(calendarContainer.getAttribute("data-year"))
  
        month--
        if (month < 0) {
          month = 11
          year--
        }
  
        generateCalendar(month, year)
      })
    }
  
    // Next month button
    const nextMonthBtn = document.getElementById("next-month")
    if (nextMonthBtn) {
      nextMonthBtn.addEventListener("click", () => {
        let month = Number.parseInt(calendarContainer.getAttribute("data-month"))
        let year = Number.parseInt(calendarContainer.getAttribute("data-year"))
  
        month++
        if (month > 11) {
          month = 0
          year++
        }
  
        generateCalendar(month, year)
      })
    }
  
    // Generate calendar function
    function generateCalendar(month, year) {
      calendarContainer.setAttribute("data-month", month)
      calendarContainer.setAttribute("data-year", year)
  
      const monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ]
      const daysInMonth = new Date(year, month + 1, 0).getDate()
      const firstDay = new Date(year, month, 1).getDay()
  
      // Update month and year display
      const monthYearDisplay = document.getElementById("month-year-display")
      if (monthYearDisplay) {
        monthYearDisplay.textContent = `${monthNames[month]} ${year}`
      }
  
      // Clear previous calendar
      calendarContainer.innerHTML = ""
  
      // Create day headers
      const dayHeaders = document.createElement("div")
      dayHeaders.className = "grid grid-cols-7 gap-1 mb-2"
  
      const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
      days.forEach((day) => {
        const dayHeader = document.createElement("div")
        dayHeader.className = "text-center text-sm font-medium text-gray-500"
        dayHeader.textContent = day
        dayHeaders.appendChild(dayHeader)
      })
  
      calendarContainer.appendChild(dayHeaders)
  
      // Create calendar grid
      const calendarGrid = document.createElement("div")
      calendarGrid.className = "grid grid-cols-7 gap-1"
  
      // Add empty cells for days before the first day of the month
      for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div")
        emptyCell.className = "h-10 w-10"
        calendarGrid.appendChild(emptyCell)
      }
  
      // Add days of the month
      for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day)
        const dayCell = document.createElement("div")
        dayCell.className = "calendar-day"
  
        // Disable past dates
        if (date < new Date(today.getFullYear(), today.getMonth(), today.getDate())) {
          dayCell.classList.add("disabled")
        } else {
          dayCell.addEventListener("click", () => {
            if (dayCell.classList.contains("disabled")) return
  
            // Remove selected class from all days
            document.querySelectorAll(".calendar-day.selected").forEach((el) => {
              el.classList.remove("selected")
            })
  
            // Add selected class to clicked day
            dayCell.classList.add("selected")
  
            // Update selected date
            selectedDate = new Date(year, month, day)
  
            // Update hidden input
            const dateInput = document.getElementById("booking_date")
            if (dateInput) {
              dateInput.value = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`
  
              // Trigger change event
              const event = new Event("change")
              dateInput.dispatchEvent(event)
            }
  
            // Check if weekend and update price if needed
            updatePriceWithWeekendSurcharge(date)
          })
        }
  
        dayCell.textContent = day
        calendarGrid.appendChild(dayCell)
      }
  
      calendarContainer.appendChild(calendarGrid)
    }
  
    // Update price with weekend surcharge
    function updatePriceWithWeekendSurcharge(date) {
      const isWeekend = date.getDay() === 0 || date.getDay() === 6 // Sunday or Saturday
      const serviceRadios = document.querySelectorAll('input[name="service_id"]')
      const selectedService = Array.from(serviceRadios).find((radio) => radio.checked)
  
      if (!selectedService) return
  
      const basePrice = Number.parseFloat(selectedService.getAttribute("data-price") || 0)
      const weekendSurchargeRate = 0.2 // 20%
      const weekendSurcharge = isWeekend ? basePrice * weekendSurchargeRate : 0
      const totalPrice = basePrice + weekendSurcharge
  
      // Update price display
      const basePriceEl = document.getElementById("base-price")
      const weekendSurchargeEl = document.getElementById("weekend-surcharge")
      const totalPriceEl = document.getElementById("total-price")
      const weekendSurchargeContainer = document.getElementById("weekend-surcharge-container")
  
      if (basePriceEl) {
        basePriceEl.textContent = `Rp ${basePrice.toLocaleString()}`
      }
  
      if (weekendSurchargeEl) {
        weekendSurchargeEl.textContent = `Rp ${weekendSurcharge.toLocaleString()}`
      }
  
      if (weekendSurchargeContainer) {
        if (isWeekend) {
          weekendSurchargeContainer.classList.remove("hidden")
        } else {
          weekendSurchargeContainer.classList.add("hidden")
        }
      }
  
      if (totalPriceEl) {
        totalPriceEl.textContent = `Rp ${totalPrice.toLocaleString()}`
      }
  
      // Update hidden inputs
      const basePriceInput = document.getElementById("base_price")
      const weekendSurchargeInput = document.getElementById("weekend_surcharge")
      const totalPriceInput = document.getElementById("total_price")
  
      if (basePriceInput) basePriceInput.value = basePrice
      if (weekendSurchargeInput) weekendSurchargeInput.value = weekendSurcharge
      if (totalPriceInput) totalPriceInput.value = totalPrice
    }
  }
  
  /**
   * Initialize service selection
   */
  function initializeServiceSelection() {
    const serviceRadios = document.querySelectorAll('input[name="service_id"]')
    const dateInput = document.getElementById("booking_date")
  
    serviceRadios.forEach((radio) => {
      radio.addEventListener("change", () => {
        if (dateInput && dateInput.value) {
          const date = new Date(dateInput.value)
          updatePriceWithWeekendSurcharge(date)
        }
      })
    })
  
    // Update price with weekend surcharge
    function updatePriceWithWeekendSurcharge(date) {
      const isWeekend = date.getDay() === 0 || date.getDay() === 6 // Sunday or Saturday
      const selectedService = Array.from(serviceRadios).find((radio) => radio.checked)
  
      if (!selectedService) return
  
      const basePrice = Number.parseFloat(selectedService.getAttribute("data-price") || 0)
      const weekendSurchargeRate = 0.2 // 20%
      const weekendSurcharge = isWeekend ? basePrice * weekendSurchargeRate : 0
      const totalPrice = basePrice + weekendSurcharge
  
      // Update price display
      const basePriceEl = document.getElementById("base-price")
      const weekendSurchargeEl = document.getElementById("weekend-surcharge")
      const totalPriceEl = document.getElementById("total-price")
      const weekendSurchargeContainer = document.getElementById("weekend-surcharge-container")
  
      if (basePriceEl) {
        basePriceEl.textContent = `Rp ${basePrice.toLocaleString()}`
      }
  
      if (weekendSurchargeEl) {
        weekendSurchargeEl.textContent = `Rp ${weekendSurcharge.toLocaleString()}`
      }
  
      if (weekendSurchargeContainer) {
        if (isWeekend) {
          weekendSurchargeContainer.classList.remove("hidden")
        } else {
          weekendSurchargeContainer.classList.add("hidden")
        }
      }
  
      if (totalPriceEl) {
        totalPriceEl.textContent = `Rp ${totalPrice.toLocaleString()}`
      }
  
      // Update hidden inputs
      const basePriceInput = document.getElementById("base_price")
      const weekendSurchargeInput = document.getElementById("weekend_surcharge")
      const totalPriceInput = document.getElementById("total_price")
  
      if (basePriceInput) basePriceInput.value = basePrice
      if (weekendSurchargeInput) weekendSurchargeInput.value = weekendSurcharge
      if (totalPriceInput) totalPriceInput.value = totalPrice
    }
  }
  
  /**
   * Initialize time slot selection
   */
  function initializeTimeSlotSelection() {
    const timeSlots = document.querySelectorAll('input[name="session_time"]')
  
    timeSlots.forEach((slot) => {
      slot.addEventListener("change", () => {
        // Remove selected class from all time slots
        document.querySelectorAll(".time-slot.selected").forEach((el) => {
          el.classList.remove("selected", "bg-indigo-100", "border-indigo-500")
          el.classList.add("border-gray-200")
        })
  
        // Add selected class to clicked time slot
        const slotContainer = slot.closest(".time-slot")
        if (slotContainer) {
          slotContainer.classList.add("selected", "bg-indigo-100", "border-indigo-500")
          slotContainer.classList.remove("border-gray-200")
        }
      })
    })
  }
  
  /**
   * Initialize animations
   */
  function initializeAnimations() {
    // Fade in elements with data-animate="fade-in" attribute
    const fadeElements = document.querySelectorAll('[data-animate="fade-in"]')
  
    fadeElements.forEach((element, index) => {
      setTimeout(() => {
        element.classList.add("opacity-100")
        element.classList.remove("opacity-0")
      }, 100 * index)
    })
  
    // Slide in elements with data-animate="slide-in" attribute
    const slideElements = document.querySelectorAll('[data-animate="slide-in"]')
  
    slideElements.forEach((element, index) => {
      setTimeout(() => {
        element.classList.add("translate-y-0", "opacity-100")
        element.classList.remove("translate-y-4", "opacity-0")
      }, 100 * index)
    })
  
    // Animate counter elements
    const counterElements = document.querySelectorAll("[data-counter]")
  
    counterElements.forEach((element) => {
      const target = Number.parseInt(element.getAttribute("data-counter"))
      const duration = Number.parseInt(element.getAttribute("data-duration") || "2000")
      const increment = target / (duration / 16)
      let current = 0
  
      const updateCounter = () => {
        current += increment
        if (current < target) {
          element.textContent = Math.round(current).toLocaleString()
          requestAnimationFrame(updateCounter)
        } else {
          element.textContent = target.toLocaleString()
        }
      }
  
      // Start animation when element is in viewport
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            updateCounter()
            observer.unobserve(element)
          }
        })
      })
  
      observer.observe(element)
    })
  }
  
  /**
   * Setup form validation
   */
  function setupFormValidation() {
    const forms = document.querySelectorAll("form[data-validate]")
  
    forms.forEach((form) => {
      form.addEventListener("submit", (e) => {
        let isValid = true
        const requiredFields = form.querySelectorAll("[required]")
  
        requiredFields.forEach((field) => {
          if (!field.value.trim()) {
            isValid = false
  
            // Add error class
            field.classList.add("border-red-500")
  
            // Show error message
            const errorMessage = field.getAttribute("data-error-message") || "This field is required"
            let errorElement = field.parentNode.querySelector(".error-message")
  
            if (!errorElement) {
              errorElement = document.createElement("p")
              errorElement.className = "text-red-500 text-xs mt-1 error-message"
              field.parentNode.appendChild(errorElement)
            }
  
            errorElement.textContent = errorMessage
          } else {
            // Remove error class
            field.classList.remove("border-red-500")
  
            // Remove error message
            const errorElement = field.parentNode.querySelector(".error-message")
            if (errorElement) {
              errorElement.remove()
            }
          }
        })
  
        if (!isValid) {
          e.preventDefault()
  
          // Scroll to first error
          const firstError = form.querySelector(".border-red-500")
          if (firstError) {
            firstError.scrollIntoView({ behavior: "smooth", block: "center" })
            firstError.focus()
          }
        }
      })
  
      // Live validation on input
      const fields = form.querySelectorAll("input, select, textarea")
  
      fields.forEach((field) => {
        field.addEventListener("blur", () => {
          if (field.hasAttribute("required") && !field.value.trim()) {
            // Add error class
            field.classList.add("border-red-500")
  
            // Show error message
            const errorMessage = field.getAttribute("data-error-message") || "This field is required"
            let errorElement = field.parentNode.querySelector(".error-message")
  
            if (!errorElement) {
              errorElement = document.createElement("p")
              errorElement.className = "text-red-500 text-xs mt-1 error-message"
              field.parentNode.appendChild(errorElement)
            }
  
            errorElement.textContent = errorMessage
          } else {
            // Remove error class
            field.classList.remove("border-red-500")
  
            // Remove error message
            const errorElement = field.parentNode.querySelector(".error-message")
            if (errorElement) {
              errorElement.remove()
            }
          }
        })
      })
    })
  }
  
  