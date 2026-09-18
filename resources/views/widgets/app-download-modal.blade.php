<style>
    /* =========================================
       MODAL WRAPPER STYLES
       ========================================= */
    .app-download-modal-wrapper {
        font-family: system-ui, -apple-system, sans-serif;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(4px);
        
        /* HIDDEN BY DEFAULT */
        display: none; 
        
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    /* When active, show the modal */
    .app-download-modal-wrapper.active {
        display: flex;
    }

    /* Modal Box */
    .app-download-modal-wrapper .modal-box {
        background-color: #ffffff;
        border-radius: 20px;
        padding: 32px 24px;
        width: 90%;
        max-width: 400px;
        position: relative;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Top Right Close Button (X) */
    .app-download-modal-wrapper .close-btn-top {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #f3f4f6;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .app-download-modal-wrapper .close-btn-top:hover {
        background: #e5e7eb;
        color: #111827;
    }

    /* Icon Box */
    .app-download-modal-wrapper .icon-box {
        width: 64px;
        height: 64px;
        background-color: #e6f4ea;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        font-size: 32px;
        color: #3ddc84;
    }

    /* Typography */
    .app-download-modal-wrapper .modal-title {
        color: #111827;
        font-weight: 700;
        font-size: 1.35rem;
        margin-bottom: 10px;
    }

    .app-download-modal-wrapper .modal-desc {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 24px;
    }

    /* Primary Action Button */
    .app-download-modal-wrapper .btn-google-play {
        background-color: #3ddc84;
        color: #000000;
        font-weight: 600;
        border-radius: 10px;
        padding: 14px 20px;
        width: 100%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: background-color 0.2s;
        font-size: 1rem;
    }

    .app-download-modal-wrapper .btn-google-play:hover {
        background-color: #32b56b;
        color: #000000;
    }

    /* Secondary Close Button */
    .app-download-modal-wrapper .btn-close-bottom {
        background: transparent;
        border: none;
        color: #9ca3af;
        font-size: 0.9rem;
        margin-top: 16px;
        cursor: pointer;
        width: 100%;
        padding: 8px;
        transition: color 0.2s;
    }

    .app-download-modal-wrapper .btn-close-bottom:hover {
        color: #111827;
        text-decoration: underline;
    }

    /* =========================================
       TRIGGER BUTTON STYLES
       ========================================= */
    #openAppModalBtn {
        padding: 10px 20px; 
        background: #111827; 
        color: white; 
        border: none; 
        border-radius: 8px; 
        cursor: pointer;
        
        /* HIDDEN BY DEFAULT */
        display: none;  */
    }
</style>

<!-- Start of Modal Wrapper -->
<div class="app-download-modal-wrapper" id="appDownloadModal">
    
    <div class="modal-box">
        
        <!-- Top Right Close Button -->
        <button class="close-btn-top" id="closeModalTop" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Icon -->
        <div class="icon-box">
            <i class="fa-brands fa-android"></i>
        </div>

        <!-- Content -->
        <h3 class="modal-title">Download Android App</h3>
        <p class="modal-desc">
            Get real-time job updates, apply on the go, and manage your profile easily with our mobile app.
        </p>

        <!-- Action Button -->
        <a href="{{ route('home.jobs.app') }}" target="_blank" class="btn-google-play">
            <i class="fa-brands fa-google-play"></i>
            Get it on Google Play
        </a>

        <!-- Bottom Close Button -->
        <button class="btn-close-bottom" id="closeModalBottom">
            Maybe later
        </button>

    </div>

</div>
<!-- End of Modal Wrapper -->

<!-- Example Trigger Button (Hidden by default in CSS) -->
<button id="openAppModalBtn">
    Open Download Modal
</button>

<!-- JavaScript for Modal & Local Storage Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('appDownloadModal');
        const triggerBtn = document.getElementById('openAppModalBtn');
        const closeTopBtn = document.getElementById('closeModalTop');
        const closeBottomBtn = document.getElementById('closeModalBottom');
        
        // The key used to store the flag in localStorage
        const STORAGE_KEY = 'hideAppDownloadModal';

        // 1. CHECK STORAGE ON PAGE LOAD
        // If the user has NOT closed it before (flag is not 'true'), show the trigger button
        if (localStorage.getItem(STORAGE_KEY) !== 'true') {
            if (triggerBtn) {
                triggerBtn.style.display = 'inline-block'; 
            }
        }

        // Function to open the modal
        window.openAppModal = function() {
            if (localStorage.getItem(STORAGE_KEY) === 'true') return;
            modal.classList.add('active');
        };

        // Function to close the modal and set the flag
        function closeModal() {
            modal.classList.remove('active');
            
            // 2. SET STORAGE FLAG
            localStorage.setItem(STORAGE_KEY, 'true');
            
            // Hide the trigger button immediately after closing
            if (triggerBtn) {
                triggerBtn.style.display = 'none';
            }
        }

        // Event Listeners for both close buttons
        closeTopBtn.addEventListener('click', closeModal);
        closeBottomBtn.addEventListener('click', closeModal);

        // Close modal if user clicks outside the modal box (on the dark backdrop)
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        // Attach click event to trigger button

    
    });
</script>