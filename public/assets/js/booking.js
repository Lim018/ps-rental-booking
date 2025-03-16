/**
 * PS Rental - Booking Page JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
  // Initialize booking steps
  initBookingSteps();

  // Initialize calendar
  initCalendar();

  // Initialize service selection
  initServiceSelection();

  // Initialize time slot selection
  initTimeSlotSelection();

  // Initialize form validation
  initFormValidation();
});

/**
* Initialize booking steps
*/
function initBookingSteps() {
  const nextButtons = document.querySelectorAll(".btn-next");
  const prevButtons = document.querySelectorAll(".btn-prev");
  const steps = document.querySelectorAll(".booking-step");
  const formSections = document.querySelectorAll(".form-section");

  let currentStep = 1;

  // Show only the first form section initially
  formSections.forEach((section, index) => {
      if (index !== 0) {
          section.style.display = "none";
      }
  });

  // Update steps display
  function updateSteps() {
      steps.forEach((step, index) => {
          const stepNumber = index + 1;

          if (stepNumber < currentStep) {
              step.classList.add("completed");
              step.classList.remove("active");
          } else if (stepNumber === currentStep) {
              step.classList.add("active");
              step.classList.remove("completed");
          } else {
              step.classList.remove("active", "completed");
          }
      });

      // Show/hide form sections
      formSections.forEach((section, index) => {
          if (index === currentStep - 1) {
              section.style.display = "block";
          } else {
              section.style.display = "none";
          }
      });

      // Populate review section when reaching Step 3
      if (currentStep === 3) {
          populateReviewSection();
      }
  }

  // Next button click handler
  nextButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
          e.preventDefault();

          // Validate current section before proceeding
          const currentSection = formSections[currentStep - 1];
          const isValid = validateSection(currentSection);

          if (!isValid) return;

          if (currentStep < steps.length) {
              currentStep++;
              updateSteps();

              // Scroll to top of form
              document.querySelector(".booking-form").scrollIntoView({ behavior: "smooth" });
          }
      });
  });

  // Previous button click handler
  prevButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
          e.preventDefault();

          if (currentStep > 1) {
              currentStep--;
              updateSteps();

              // Scroll to top of form
              document.querySelector(".booking-form").scrollIntoView({ behavior: "smooth" });
          }
      });
  });

  // Validate section
  function validateSection(section) {
      let isValid = true;

      // Check required fields
      const requiredFields = section.querySelectorAll("[required]");
      requiredFields.forEach((field) => {
          if (!field.value.trim()) {
              isValid = false;
              field.classList.add("error");

              // Add error message if not exists
              let errorElement = field.parentNode.querySelector(".form-error");
              if (!errorElement) {
                  errorElement = document.createElement("div");
                  errorElement.className = "form-error";
                  errorElement.textContent = field.getAttribute("data-error-message") || "This field is required";
                  field.parentNode.appendChild(errorElement);
              }
          }
      });

      // Check if date is selected
      if (section.id === "section-date-service") {
          const dateInput = document.getElementById("booking_date");
          if (!dateInput.value) {
              isValid = false;

              // Show error message
              let errorElement = document.querySelector(".calendar-container .form-error");
              if (!errorElement) {
                  errorElement = document.createElement("div");
                  errorElement.className = "form-error";
                  errorElement.textContent = "Please select a date";
                  document.querySelector(".calendar-container").appendChild(errorElement);
              }
          }

          // Check if service is selected
          const serviceInput = document.querySelector('input[name="service_id"]:checked');
          if (!serviceInput) {
              isValid = false;

              // Show error message
              let errorElement = document.querySelector(".service-options-container .form-error");
              if (!errorElement) {
                  errorElement = document.createElement("div");
                  errorElement.className = "form-error";
                  errorElement.textContent = "Please select a service";
                  document.querySelector(".service-options-container").appendChild(errorElement);
              }
          }

          // Check if time slot is selected
          const timeSlotInput = document.querySelector('input[name="session_time"]:checked');
          if (!timeSlotInput) {
              isValid = false;

              // Show error message
              let errorElement = document.querySelector(".time-slots-container .form-error");
              if (!errorElement) {
                  errorElement = document.createElement("div");
                  errorElement.className = "form-error";
                  errorElement.textContent = "Please select a time slot";
                  document.querySelector(".time-slots-container").appendChild(errorElement);
              }
          }
      }

      return isValid;
  }
}

/**
* Populate the review section with form data
*/
function populateReviewSection() {
    console.log("Populating review section...");

    // Step 1: Booking Details
    const bookingDate = document.getElementById("booking_date")?.value || "";
    const sessionTime = document.querySelector('input[name="session_time"]:checked')?.value || "";
    const serviceId = document.querySelector('input[name="service_id"]:checked')?.value || "";
    const serviceName = document.querySelector(`#service-${serviceId}`)?.parentElement?.querySelector(".service-option-title")?.textContent || "";

    console.log("Booking Date:", bookingDate);
    console.log("Session Time:", sessionTime);
    console.log("Service ID:", serviceId);
    console.log("Service Name:", serviceName);

    document.getElementById("review-date").textContent = bookingDate || "Not selected";
    document.getElementById("review-time").textContent = sessionTime || "Not selected";
    document.getElementById("review-service").textContent = serviceName || "Not selected";

    // Step 2: Personal Information
    const name = document.getElementById("name")?.value || "";
    const phone = document.getElementById("phone")?.value || "";

    console.log("Name:", name);
    console.log("Phone:", phone);

    document.getElementById("review-name").textContent = name || "Not provided";
    document.getElementById("review-phone").textContent = phone || "Not provided";

    // Price Summary
    const basePrice = parseFloat(document.getElementById("base_price")?.value) || 0;
    const weekendSurcharge = parseFloat(document.getElementById("weekend_surcharge")?.value) || 0;
    const totalPrice = parseFloat(document.getElementById("total_price")?.value) || 0;

    console.log("Base Price:", basePrice);
    console.log("Weekend Surcharge:", weekendSurcharge);
    console.log("Total Price:", totalPrice);

    document.getElementById("review-base-price").textContent = formatCurrency(basePrice);
    document.getElementById("review-weekend-surcharge").textContent = formatCurrency(weekendSurcharge);
    document.getElementById("review-total-price").textContent = formatCurrency(totalPrice);

    // Show weekend surcharge if applicable
    document.getElementById("review-weekend-container").style.display = weekendSurcharge > 0 ? "flex" : "none";
}

/**
* Initialize calendar
*/
function initCalendar() {
  const calendarContainer = document.getElementById("booking-calendar");

  if (!calendarContainer) return;

  const today = new Date();
  const currentMonth = today.getMonth();
  const currentYear = today.getFullYear();

  let selectedDate = null;

  // Generate calendar
  generateCalendar(currentMonth, currentYear);

  // Previous month button
  const prevMonthBtn = document.getElementById("prev-month");
  if (prevMonthBtn) {
      prevMonthBtn.addEventListener("click", () => {
          let month = Number.parseInt(calendarContainer.getAttribute("data-month"));
          let year = Number.parseInt(calendarContainer.getAttribute("data-year"));

          month--;
          if (month < 0) {
              month = 11;
              year--;
          }

          generateCalendar(month, year);
      });
  }

  // Next month button
  const nextMonthBtn = document.getElementById("next-month");
  if (nextMonthBtn) {
      nextMonthBtn.addEventListener("click", () => {
          let month = Number.parseInt(calendarContainer.getAttribute("data-month"));
          let year = Number.parseInt(calendarContainer.getAttribute("data-year"));

          month++;
          if (month > 11) {
              month = 0;
              year++;
          }

          generateCalendar(month, year);
      });
  }

  // Generate calendar function
  function generateCalendar(month, year) {
      calendarContainer.setAttribute("data-month", month);
      calendarContainer.setAttribute("data-year", year);

      const monthNames = [
          "January", "February", "March", "April", "May", "June",
          "July", "August", "September", "October", "November", "December",
      ];
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const firstDay = new Date(year, month, 1).getDay();

      // Update month and year display
      const monthYearDisplay = document.getElementById("month-year-display");
      if (monthYearDisplay) {
          monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
      }

      // Clear previous calendar
      const calendarGrid = calendarContainer.querySelector(".calendar-grid");
      if (calendarGrid) {
          calendarGrid.innerHTML = "";

          // Add day headers
          const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
          daysOfWeek.forEach((day) => {
              const dayHeader = document.createElement("div");
              dayHeader.className = "calendar-day-header";
              dayHeader.textContent = day;
              calendarGrid.appendChild(dayHeader);
          });

          // Add empty cells for days before the first day of the month
          for (let i = 0; i < firstDay; i++) {
              const emptyCell = document.createElement("div");
              emptyCell.className = "calendar-day empty";
              calendarGrid.appendChild(emptyCell);
          }

          // Add days of the month
          for (let day = 1; day <= daysInMonth; day++) {
              const date = new Date(year, month, day);
              const dayCell = document.createElement("div");
              dayCell.className = "calendar-day";
              dayCell.textContent = day;

              // Check if this is today
              const isToday = date.toDateString() === today.toDateString();
              if (isToday) {
                  dayCell.classList.add("today");
              }

              // Check if this is the selected date
              if (selectedDate && date.toDateString() === selectedDate.toDateString()) {
                  dayCell.classList.add("selected");
              }

              // Disable past dates
              if (date < new Date(today.getFullYear(), today.getMonth(), today.getDate())) {
                  dayCell.classList.add("disabled");
              } else {
                  dayCell.addEventListener("click", () => {
                      if (dayCell.classList.contains("disabled")) return;

                      // Remove selected class from all days
                      document.querySelectorAll(".calendar-day.selected").forEach((el) => {
                          el.classList.remove("selected");
                      });

                      // Add selected class to clicked day
                      dayCell.classList.add("selected");

                      // Update selected date
                      selectedDate = new Date(year, month, day);

                      // Update hidden input
                      const dateInput = document.getElementById("booking_date");
                      if (dateInput) {
                          dateInput.value = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

                          // Trigger change event
                          const event = new Event("change");
                          dateInput.dispatchEvent(event);
                      }

                      // Remove error message if exists
                      const errorElement = document.querySelector(".calendar-container .form-error");
                      if (errorElement) {
                          errorElement.remove();
                      }

                      // Update price with weekend surcharge
                      updatePriceWithWeekendSurcharge(date);
                  });
              }

              calendarGrid.appendChild(dayCell);
          }
      }
  }

  // Update price with weekend surcharge
  function updatePriceWithWeekendSurcharge(date) {
      const isWeekend = date.getDay() === 0 || date.getDay() === 6; // Sunday or Saturday
      const serviceRadios = document.querySelectorAll('input[name="service_id"]');
      const selectedService = Array.from(serviceRadios).find((radio) => radio.checked);

      if (!selectedService) return;

      const basePrice = Number.parseFloat(selectedService.getAttribute("data-price") || 0);
      const weekendSurchargeRate = 0.2; // 20%
      const weekendSurcharge = isWeekend ? basePrice * weekendSurchargeRate : 0;
      const totalPrice = basePrice + weekendSurcharge;

      // Update price display
      const basePriceEl = document.getElementById("base-price");
      const weekendSurchargeEl = document.getElementById("weekend-surcharge");
      const totalPriceEl = document.getElementById("total-price");
      const weekendSurchargeContainer = document.getElementById("weekend-surcharge-container");

      if (basePriceEl) {
          basePriceEl.textContent = formatCurrency(basePrice);
      }

      if (weekendSurchargeEl) {
          weekendSurchargeEl.textContent = formatCurrency(weekendSurcharge);
      }

      if (weekendSurchargeContainer) {
          if (isWeekend) {
              weekendSurchargeContainer.classList.remove("hidden");
          } else {
              weekendSurchargeContainer.classList.add("hidden");
          }
      }

      if (totalPriceEl) {
          totalPriceEl.textContent = formatCurrency(totalPrice);
      }

      // Update hidden inputs
      const basePriceInput = document.getElementById("base_price");
      const weekendSurchargeInput = document.getElementById("weekend_surcharge");
      const totalPriceInput = document.getElementById("total_price");

      if (basePriceInput) basePriceInput.value = basePrice;
      if (weekendSurchargeInput) weekendSurchargeInput.value = weekendSurcharge;
      if (totalPriceInput) totalPriceInput.value = totalPrice;
  }
}

/**
* Initialize service selection
*/
function initServiceSelection() {
  const serviceOptions = document.querySelectorAll(".service-option");
  const serviceRadios = document.querySelectorAll('input[name="service_id"]');

  serviceOptions.forEach((option) => {
      option.addEventListener("click", () => {
          const radioInput = option.querySelector('input[type="radio"]');
          if (radioInput) {
              radioInput.checked = true;

              // Remove selected class from all options
              serviceOptions.forEach((opt) => {
                  opt.classList.remove("selected");
              });

              // Add selected class to clicked option
              option.classList.add("selected");

              // Remove error message if exists
              const errorElement = document.querySelector(".service-options-container .form-error");
              if (errorElement) {
                  errorElement.remove();
              }

              // Update price
              const dateInput = document.getElementById("booking_date");
              if (dateInput && dateInput.value) {
                  const date = new Date(dateInput.value);
                  updatePriceWithWeekendSurcharge(date);
              }
          }
      });
  });

  // Update price with weekend surcharge
  function updatePriceWithWeekendSurcharge(date) {
      const isWeekend = date.getDay() === 0 || date.getDay() === 6; // Sunday or Saturday
      const selectedService = Array.from(serviceRadios).find((radio) => radio.checked);

      if (!selectedService) return;

      const basePrice = Number.parseFloat(selectedService.getAttribute("data-price") || 0);
      const weekendSurchargeRate = 0.2; // 20%
      const weekendSurcharge = isWeekend ? basePrice * weekendSurchargeRate : 0;
      const totalPrice = basePrice + weekendSurcharge;

      // Update price display
      const basePriceEl = document.getElementById("base-price");
      const weekendSurchargeEl = document.getElementById("weekend-surcharge");
      const totalPriceEl = document.getElementById("total-price");
      const weekendSurchargeContainer = document.getElementById("weekend-surcharge-container");

      if (basePriceEl) {
          basePriceEl.textContent = formatCurrency(basePrice);
      }

      if (weekendSurchargeEl) {
          weekendSurchargeEl.textContent = formatCurrency(weekendSurcharge);
      }

      if (weekendSurchargeContainer) {
          if (isWeekend) {
              weekendSurchargeContainer.classList.remove("hidden");
          } else {
              weekendSurchargeContainer.classList.add("hidden");
          }
      }

      if (totalPriceEl) {
          totalPriceEl.textContent = formatCurrency(totalPrice);
      }

      // Update hidden inputs
      const basePriceInput = document.getElementById("base_price");
      const weekendSurchargeInput = document.getElementById("weekend_surcharge");
      const totalPriceInput = document.getElementById("total_price");

      if (basePriceInput) basePriceInput.value = basePrice;
      if (weekendSurchargeInput) weekendSurchargeInput.value = weekendSurcharge;
      if (totalPriceInput) totalPriceInput.value = totalPrice;
  }
}

/**
* Initialize time slot selection
*/
function initTimeSlotSelection() {
  const timeSlots = document.querySelectorAll(".time-slot");

  timeSlots.forEach((slot) => {
      slot.addEventListener("click", () => {
          if (slot.classList.contains("disabled")) return;

          const radioInput = slot.querySelector('input[type="radio"]');
          if (radioInput) {
              radioInput.checked = true;

              // Remove selected class from all slots
              timeSlots.forEach((s) => {
                  s.classList.remove("selected");
              });

              // Add selected class to clicked slot
              slot.classList.add("selected");

              // Remove error message if exists
              const errorElement = document.querySelector(".time-slots-container .form-error");
              if (errorElement) {
                  errorElement.remove();
              }
          }
      });
  });
}

/**
* Initialize form validation
*/
function initFormValidation() {
  const bookingForm = document.getElementById("booking-form");

  if (!bookingForm) return;

  bookingForm.addEventListener("submit", (e) => {
      // Validate all required fields
      const requiredFields = bookingForm.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
          if (!field.value.trim()) {
              isValid = false;
              field.classList.add("error");

              // Add error message if not exists
              let errorElement = field.parentNode.querySelector(".form-error");
              if (!errorElement) {
                  errorElement = document.createElement("div");
                  errorElement.className = "form-error";
                  errorElement.textContent = field.getAttribute("data-error-message") || "This field is required";
                  field.parentNode.appendChild(errorElement);
              }
          } else {
              field.classList.remove("error");

              // Remove error message if exists
              const errorElement = field.parentNode.querySelector(".form-error");
              if (errorElement) {
                  errorElement.remove();
              }
          }
      });

      // Check if date is selected
      const dateInput = document.getElementById("booking_date");
      if (!dateInput.value) {
          isValid = false;

          // Show error message
          let errorElement = document.querySelector(".calendar-container .form-error");
          if (!errorElement) {
              errorElement = document.createElement("div");
              errorElement.className = "form-error";
              errorElement.textContent = "Please select a date";
              document.querySelector(".calendar-container").appendChild(errorElement);
          }
      }

      // Check if service is selected
      const serviceInput = document.querySelector('input[name="service_id"]:checked');
      if (!serviceInput) {
          isValid = false;

          // Show error message
          let errorElement = document.querySelector(".service-options-container .form-error");
          if (!errorElement) {
              errorElement = document.createElement("div");
              errorElement.className = "form-error";
              errorElement.textContent = "Please select a service";
              document.querySelector(".service-options-container").appendChild(errorElement);
          }
      }

      // Check if time slot is selected
      const timeSlotInput = document.querySelector('input[name="session_time"]:checked');
      if (!timeSlotInput) {
          isValid = false;

          // Show error message
          let errorElement = document.querySelector(".time-slots-container .form-error");
          if (!errorElement) {
              errorElement = document.createElement("div");
              errorElement.className = "form-error";
              errorElement.textContent = "Please select a time slot";
              document.querySelector(".time-slots-container").appendChild(errorElement);
          }
      }

      if (!isValid) {
          e.preventDefault();

          // Scroll to first error
          const firstError = bookingForm.querySelector(".error, .form-error");
          if (firstError) {
              firstError.scrollIntoView({ behavior: "smooth", block: "center" });
          }
      }
  });

  // Live validation on input blur
  const formInputs = bookingForm.querySelectorAll("input, textarea, select");
  formInputs.forEach((input) => {
      if (input.hasAttribute("required")) {
          input.addEventListener("blur", () => {
              if (!input.value.trim()) {
                  input.classList.add("error");

                  // Add error message if not exists
                  let errorElement = input.parentNode.querySelector(".form-error");
                  if (!errorElement) {
                      errorElement = document.createElement("div");
                      errorElement.className = "form-error";
                      errorElement.textContent = input.getAttribute("data-error-message") || "This field is required";
                      input.parentNode.appendChild(errorElement);
                  }
              } else {
                  input.classList.remove("error");

                  // Remove error message if exists
                  const errorElement = input.parentNode.querySelector(".form-error");
                  if (errorElement) {
                      errorElement.remove();
                  }
              }
          });
      }
  });
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
  }).format(amount);
}