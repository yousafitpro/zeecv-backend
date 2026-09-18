<style>
    /* =========================================
       WRAPPER CLASS STYLES
       ========================================= */
    .download-app-wrapper {
        font-family: system-ui, -apple-system, sans-serif;
    }

    /* Shared Card Styling */
    .download-app-wrapper .app-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Shared Icon Box */
    .download-app-wrapper .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Shared Typography */
    .download-app-wrapper .card-title-text {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .download-app-wrapper .card-desc-text {
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
    }

    /* =========================================
       LIGHT CARD (To ask user to download Android app)
       ========================================= */
    .download-app-wrapper .light-app-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        position: relative; /* Required for absolute positioning of close button */
        
        /* HIDDEN BY DEFAULT (Prevents flash before JS loads) */
        display: none; 
    }
    
    .download-app-wrapper .light-app-card .icon-box {
        background-color: #e6f4ea;
        color: #3ddc84;
    }
    
    .download-app-wrapper .light-app-card .card-title-text {
        color: #111827;
        padding-right: 10px; /* Prevents title text from overlapping close button */
    }
    
    .download-app-wrapper .light-app-card .card-desc-text {
        color: #6b7280;
    }
    
    .download-app-wrapper .light-app-card .btn-android {
        background-color: #3ddc84;
        color: #000000;
        font-weight: 600;
        border-radius: 8px;
        padding: 12px 20px;
        width: 100%;
        border: none;
        transition: background-color 0.2s;
    }
    
    .download-app-wrapper .light-app-card .btn-android:hover {
        background-color: #32b56b;
    }

    /* Close Button Styling */
    .download-app-wrapper .light-app-card .close-card-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        background: transparent;
        border: none;
        color: #9ca3af;
        font-size: 1.2rem;
        line-height: 1;
        padding: 4px;
        cursor: pointer;
        transition: color 0.2s ease;
        z-index: 10;
    }

    .download-app-wrapper .light-app-card .close-card-btn:hover {
        color: #111827;
    }
</style>

<!-- Start of Wrapper -->
<div class="download-app-wrapper">
    
    <!-- 2. LIGHT CARD (To ask user to download Android app) -->
    <div class="card app-card light-app-card p-4 h-100" id="androidAppCard">
        
        <!-- Close Button -->
        <button class="close-card-btn" id="closeAndroidAppCard" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="card-body p-0 d-flex flex-column">
            <div class="icon-box mb-4">
                <i class="fa-brands fa-android"></i>
            </div>
            <h4 class="card-title-text">Download Android App</h4>
            <p class="card-desc-text flex-grow-1">
                Get the app to apply for jobs on the go, receive instant notifications, and manage your profile easily.
            </p>
            <a href="https://play.google.com/store/apps/details?id=com.zeecv" target="_blank" class="btn btn-android mt-auto">
                <i class="fa-brands fa-google-play me-2"></i> Get it on Google Play
            </a>
        </div>
    </div>
     
</div>
<!-- End of Wrapper -->

<!-- JavaScript for Local Storage Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cardElement = document.getElementById('androidAppCard');
        const closeButton = document.getElementById('closeAndroidAppCard');
        
        // 1. Check if value is NOT in storage. If it's missing, show the card.
        if (localStorage.getItem('hideAndroidAppCard') !== 'true') {
            // We use 'flex' here because the inner card-body uses flexbox, 
            // and we want the card to fill its container height.
            cardElement.style.display = 'flex';
        }

        // 2. Handle Close Button Click
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                // Hide immediately
                cardElement.style.display = 'none';
                
                // Store the value in Local Storage so it stays hidden on refresh
                localStorage.setItem('hideAndroidAppCard', 'true');
            });
        }
    });
</script>