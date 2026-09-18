<style>
    /* =========================================
       SEPARATE WRAPPER CLASS STYLES
       ========================================= */
    .apply-on-the-go-wrapper {
        font-family: system-ui, -apple-system, sans-serif;
        max-width: 100%; /* Adjust as needed for your layout */
    }

    /* Card Styling */
    .apply-on-the-go-wrapper .app-promo-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb; /* Light subtle border */
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); /* Very subtle shadow */
    }

    /* Typography */
    .apply-on-the-go-wrapper .promo-title {
        color: #1e3a8a; /* Dark navy blue */
        font-weight: 600;
        font-size: 1.15rem;
        margin-bottom: 4px;
    }

    .apply-on-the-go-wrapper .promo-desc {
        color: #6b7280; /* Light grey */
        font-size: 0.9rem;
        margin-bottom: 18px;
    }

    /* Icons Container */
    .apply-on-the-go-wrapper .app-icons-row {
        display: flex;
        gap: 12px; /* Space between the two icons */
    }

    /* Black Box Icon Styling */
    .apply-on-the-go-wrapper .app-icon-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        background-color: #000000; /* Black background */
        border-radius: 10px;
        text-decoration: none;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    .apply-on-the-go-wrapper .app-icon-btn:hover {
        transform: translateY(-2px);
        opacity: 0.8;
    }

    /* Icon Colors */
    .apply-on-the-go-wrapper .app-icon-btn i {
        font-size: 24px;
    }

    .apply-on-the-go-wrapper .icon-apple {
        color: #ffffff; /* White Apple logo */
    }

    .apply-on-the-go-wrapper .icon-google {
        /* Giving it a slight colored tint to match the image's colorful play button */
        color: #ffffff; 
        /* Alternatively, you could use a gradient here to mimic the colorful Play Store logo */
    }
</style>

<!-- Start of Separate Wrapper -->
<div class="apply-on-the-go-wrapper">
    
    <div class="app-promo-card">
        
        <!-- Text Section -->
        <h4 class="promo-title">Apply on-the-go</h4>
        <p class="promo-desc">Get real-time job updates only on our App</p>
        
        <!-- Icons Section -->
        <div class="app-icons-row">
            
            <!-- Apple App Store Icon -->
            {{-- <a href="#" class="app-icon-btn" aria-label="Download on the App Store">
                <i class="fa-brands fa-apple icon-apple"></i>
            </a> --}}
            
            <!-- Google Play Store Icon -->
            <a href="{{ route('home.jobs.app') }}" class="app-icon-btn" aria-label="Get it on Google Play">
                <i class="fa-brands fa-google-play icon-google"></i>
            </a>
            
        </div>
        
    </div>

</div>
<!-- End of Separate Wrapper -->