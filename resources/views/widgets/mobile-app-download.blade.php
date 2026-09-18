<style>
    /* =========================================
       MOBILE APP STRIPE WRAPPER STYLES
       ========================================= */
    .mobile-app-stripe-wrapper {
        font-family: system-ui, -apple-system, sans-serif;
        width: 100%;
        background-color: #111827; /* Dark theme matching desktop card */
        padding: 14px 20px;
        box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1); /* Shadow upwards for a bottom banner feel */
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
    }

    /* Left Side Text with Icon */
    .mobile-app-stripe-wrapper .stripe-text {
        color: #ffffff;
        font-weight: 500;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 10px; /* Space between icon and text */
        margin: 0;
    }

    .mobile-app-stripe-wrapper .stripe-text i {
        color: #3ddc84; /* Android Green */
        font-size: 1.2rem;
    }

    /* Right Side Button */
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
        transform: translateY(-1px);
    }

    /* =========================================
       HIDE ON DESKTOP (Only show on Mobile View)
       ========================================= */
    @media (min-width: 768px) {
        .mobile-app-stripe-wrapper {
            display: none !important;
        }
    }
</style>

<!-- Start of New Wrapper -->
<div class="mobile-app-stripe-wrapper">
    
    <!-- Left Text with Android Icon -->
    <div class="stripe-text">
        <i class="fa-brands fa-android"></i>
        Download App now
    </div>
    
    <!-- Right Button with Google Play Icon -->
    <a href="https://play.google.com/store/apps/details?id=com.zeecv" target="_blank" class="stripe-btn">
        <i class="fa-brands fa-google-play"></i>
        Get
    </a>
    
</div>
<!-- End of Wrapper -->