/**
 * PS Rental - Home Page JavaScript
 */

document.addEventListener("DOMContentLoaded", () => {
    // Initialize testimonial slider
    initTestimonialSlider()
  
    // Initialize animation on scroll
    initAnimationOnScroll()
  
    // Initialize smooth scroll for anchor links
    initSmoothScroll()
  })
  
  /**
   * Initialize testimonial slider
   */
  function initTestimonialSlider() {
    const slider = document.querySelector(".testimonial-slider")
  
    if (!slider) return
  
    let currentSlide = 0
    const slides = slider.querySelectorAll(".testimonial-item")
    const totalSlides = slides.length
  
    // Hide all slides except the first one
    slides.forEach((slide, index) => {
      if (index !== 0) {
        slide.style.display = "none"
      }
    })
  
    // Create navigation dots
    const dotsContainer = document.createElement("div")
    dotsContainer.className = "slider-dots"
  
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement("button")
      dot.className = "slider-dot"
      if (i === 0) dot.classList.add("active")
  
      dot.addEventListener("click", () => {
        goToSlide(i)
      })
  
      dotsContainer.appendChild(dot)
    }
  
    slider.appendChild(dotsContainer)
  
    // Create navigation arrows
    const prevButton = document.createElement("button")
    prevButton.className = "slider-arrow slider-arrow-prev"
    prevButton.innerHTML = "&larr;"
    prevButton.addEventListener("click", () => {
      goToSlide(currentSlide - 1)
    })
  
    const nextButton = document.createElement("button")
    nextButton.className = "slider-arrow slider-arrow-next"
    nextButton.innerHTML = "&rarr;"
    nextButton.addEventListener("click", () => {
      goToSlide(currentSlide + 1)
    })
  
    slider.appendChild(prevButton)
    slider.appendChild(nextButton)
  
    // Auto-advance slides every 5 seconds
    let slideInterval = setInterval(() => {
      goToSlide(currentSlide + 1)
    }, 5000)
  
    // Pause auto-advance on hover
    slider.addEventListener("mouseenter", () => {
      clearInterval(slideInterval)
    })
  
    slider.addEventListener("mouseleave", () => {
      slideInterval = setInterval(() => {
        goToSlide(currentSlide + 1)
      }, 5000)
    })
  
    // Go to specific slide
    function goToSlide(index) {
      // Handle wrapping
      if (index < 0) {
        index = totalSlides - 1
      } else if (index >= totalSlides) {
        index = 0
      }
  
      // Hide current slide
      slides[currentSlide].style.display = "none"
  
      // Show new slide
      slides[index].style.display = "block"
  
      // Update dots
      dotsContainer.querySelectorAll(".slider-dot").forEach((dot, i) => {
        if (i === index) {
          dot.classList.add("active")
        } else {
          dot.classList.remove("active")
        }
      })
  
      // Update current slide index
      currentSlide = index
    }
  }
  
  /**
   * Initialize animation on scroll
   */
  function initAnimationOnScroll() {
    const elements = document.querySelectorAll(".animate-on-scroll")
  
    if (elements.length === 0) return
  
    // Check if element is in viewport
    function isInViewport(element) {
      const rect = element.getBoundingClientRect()
      return rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8
    }
  
    // Add animation class when element is in viewport
    function checkElements() {
      elements.forEach((element) => {
        if (isInViewport(element) && !element.classList.contains("animated")) {
          element.classList.add("animated")
        }
      })
    }
  
    // Check elements on page load
    checkElements()
  
    // Check elements on scroll
    window.addEventListener("scroll", checkElements)
  }
  
  /**
   * Initialize smooth scroll for anchor links
   */
  function initSmoothScroll() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]')
  
    anchorLinks.forEach((link) => {
      link.addEventListener("click", function (e) {
        const targetId = this.getAttribute("href")
  
        // Skip if href is just "#"
        if (targetId === "#") return
  
        const targetElement = document.querySelector(targetId)
  
        if (targetElement) {
          e.preventDefault()
  
          const headerHeight = document.querySelector(".site-header").offsetHeight
          const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight
  
          window.scrollTo({
            top: targetPosition,
            behavior: "smooth",
          })
        }
      })
    })
  }
  
  