<style>
    /* =========================================
       MOBILE APP STRIPE WRAPPER STYLES
       ========================================= */
    .mobile-app-stripe-wrapper {
        font-family: system-ui, -apple-system, sans-serif;
        width: 100%;
        background-color: #111827; /* Dark theme */
        padding: 14px 20px;
        box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        
        /* 1. HIDDEN BY DEFAULT (Prevents flash before JS loads) */
        display: none; 
    }

    /* Left Side Text with Icon */
    .mobile-app-stripe-wrapper .stripe-text {
        color: #ffffff;
        font-weight: 500;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .mobile-app-stripe-wrapper .stripe-text i {
        color: #3ddc84; /* Android Green */
        font-size: 1.2rem;
    }

    /* Right Side Actions Container */
    .mobile-app-stripe-wrapper .stripe-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* "Get" Button */
    .mobile-app-stripe-wrapper .stripe-btn {
        background-color: #ffffff;
        color: #111827;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 18px;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        border: none;
        transition: all 0.2s ease;
    }

    .mobile-app-stripe-wrapper .stripe-btn:hover {
        background-color: #f3f4f6;
        color: #111827;
    }

    /* Close Button */
    .mobile-app-stripe-wrapper .stripe-close-btn {
        background: transparent;
        border: none;
        color: #9ca3af; /* Light gray */
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .mobile-app-stripe-wrapper .stripe-close-btn:hover {
        color: #ffffff;
    }

    /* =========================================
       HIDE ON DESKTOP (Overrides JS on larger screens)
       ========================================= */
    @media (min-width: 768px) {
        .mobile-app-stripe-wrapper {
            display: none !important;
        }
    }
</style>

<!-- Start of New Wrapper -->
<div class="mobile-app-stripe-wrapper" id="mobileAppStripe">
    
    <!-- Left Text with Android Icon -->
    <div class="stripe-text">
        <i class="fa-brands fa-android"></i>
        Download App now
    </div>
    
    <!-- Right Side: Get Button & Close Button -->
    <div class="stripe-actions">
        <a href="{{ route('home.jobs.app') }}" class="stripe-btn">
            <i class="fa-brands fa-google-play"></i>
            Get
        </a>
        <button class="stripe-close-btn" id="closeAppStripe" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
</div>
<!-- End of Wrapper -->

<!-- JavaScript for Local Storage Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stripeElement = document.getElementById('mobileAppStripe');
        const closeButton = document.getElementById('closeAppStripe');
        
        // 1. Check if value is NOT in storage. If it's missing, show it.
        if (localStorage.getItem('hideAppStripe') !== 'true') {
            // We use 'flex' here because our CSS layout uses flexbox
            stripeElement.style.display = 'flex';
        }

        // 2. Handle Close Button Click
        closeButton.addEventListener('click', function() {
            // Hide immediately
            stripeElement.style.display = 'none';
            
            // Store the value in Local Storage so it stays hidden on refresh
            localStorage.setItem('hideAppStripe', 'true');
        });
    });
</script>