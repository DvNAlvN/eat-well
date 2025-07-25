document.addEventListener("DOMContentLoaded", function () {
    var carousel = document.getElementById("cdsCarousel");
    if (!carousel) return;

    // Ensure Bootstrap Carousel is initialized
    var bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);

    var indicatorBtns = document.querySelectorAll(
        ".cds-carousel-indicator-btn"
    );

    // Listen for carousel slide event
    carousel.addEventListener("slid.bs.carousel", function (event) {
        var idx = event.to;
        indicatorBtns.forEach(function (btn, i) {
            if (i === idx) {
                btn.classList.add("active");
                btn.setAttribute("aria-current", "true");
            } else {
                btn.classList.remove("active");
                btn.setAttribute("aria-current", "false");
            }
        });
    });

    // Also handle click on indicators to slide carousel
    indicatorBtns.forEach(function (btn, i) {
        btn.addEventListener("click", function () {
            bsCarousel.to(i);
        });
    });

    let lastCardStars = null; // Track last clicked card stars
    let lastCardStarsIdx = -1;
    let lastOrderId = null;

    // Card stars
    document.querySelectorAll(".rating-container").forEach(function (container) {
        const stars = container.querySelectorAll(".star-icon-btn");
        let selected = -1;
        const orderId = container.dataset.orderId; // <-- Get orderId from data attribute

        stars.forEach((star, idx) => {
            star.addEventListener("click", function () {
                selected = idx;
                updateStars(idx);
                lastCardStars = stars;
                lastCardStarsIdx = idx;
                lastOrderId = orderId; // <-- Set lastOrderId for use in submit
                openRateReviewModal(idx + 1);
            });
            star.addEventListener("mouseenter", function () {
                updateStars(idx);
            });
        });
        const ratingIconList = container.querySelector(".rating-icon-list");
        if (ratingIconList) {
            ratingIconList.addEventListener("mouseleave", function () {
                updateStars(selected);
            });
        }
        function updateStars(activeIdx) {
            stars.forEach((s, i) => {
                if (i <= activeIdx) {
                    s.classList.add("choosen");
                } else {
                    s.classList.remove("choosen");
                }
            });
        }
    });

    // Manual Modal logic
    const modal = document.getElementById("rateReviewModal");
    const modalStars = modal.querySelectorAll(".star-icon-modal");
    let modalSelected = -1;

    modalStars.forEach((star, idx) => {
        star.addEventListener("click", function () {
            modalSelected = idx;
            updateModalStars(idx);
        });
        star.addEventListener("mouseenter", function () {
            updateModalStars(idx);
        });
    });
    modal
        .querySelector(".rating-icon-list-modal")
        .addEventListener("mouseleave", function () {
            updateModalStars(modalSelected);
        });

    function updateModalStars(activeIdx) {
        modalStars.forEach((s, i) => {
            if (i <= activeIdx) {
                s.classList.add("choosen");
            } else {
                s.classList.remove("choosen");
            }
        });
    }

    // Open modal and set stars
    window.openRateReviewModal = function (starValue) {
        modalSelected = starValue - 1;
        updateModalStars(modalSelected);
        modal.querySelector("#reviewText").value = "";
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    };

    // Reset card stars
    function resetCardStars() {
        if (lastCardStars) {
            lastCardStars.forEach((s) => s.classList.remove("choosen"));
        }
        lastCardStars = null;
        lastCardStarsIdx = -1;
        lastOrderId = null;
    }

    // Close modal (close/cancel/outside)
    function closeModalAndReset() {
        modal.style.display = "none";
        document.body.style.overflow = "";
        resetCardStars();
    }

    document.getElementById("closeRateReviewModal").onclick =
        document.getElementById("cancelRateReviewModal").onclick =
            closeModalAndReset;

    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeModalAndReset();
        }
    });

    // Success modal logic
    const successModal = document.getElementById("successModal");
    function showSuccessModal() {
        successModal.style.display = "flex";
        document.body.style.overflow = "hidden";
    }
    function closeSuccessModal() {
        successModal.style.display = "none";
        document.body.style.overflow = "";
        // Optionally reload page or update UI
        window.location.reload();
    }
    document.getElementById("closeSuccessModal").onclick =
        document.getElementById("okSuccessModal").onclick = closeSuccessModal;

    // Submit review
    modal.querySelector("#submitRateReviewModal").onclick = function () {
        const rating = modalSelected + 1;
        const review = modal.querySelector("#reviewText").value;
        const orderId = lastOrderId;
        if (!orderId) return;
        console.log("Masuk");

        fetch(`/orders/${orderId}/review`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ rating, review }),
        })
            .then((res) => res.json())
            .then((data) => {
                modal.style.display = "none";
                document.body.style.overflow = "";
                showSuccessModal();
            });
    };
});
