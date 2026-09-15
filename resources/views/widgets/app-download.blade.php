<!-- =============================================
     DOWNLOAD BANNER
============================================= -->
<div id="zeecv_download_banner" class="zeecv_download_banner">
    <div class="zeecv_download_inner">
        <div class="zeecv_download_text">
            Get the app for a faster, better experience.
            {{-- <a href="{{ url('page-view/download') }}" target="_blank">
                Learn more
            </a> --}}
        </div>

        <div class="zeecv_download_actions">
            <a href="{{ asset('apps/zeecv.apk') }}"
               id="zeecv_download_btn"
               class="zeecv_download_btn"
               download>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3v12"/>
                    <path d="M7 10l5 5 5-5"/>
                    <path d="M5 21h14"/>
                </svg>
                Download App
            </a>

            <button type="button"
                    id="zeecv_download_close"
                    class="zeecv_download_close"
                    aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 6l12 12"/>
                    <path d="M18 6L6 18"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
/* =========================================
   Download Banner
========================================= */
.zeecv_download_banner {
  

    height: 40px;
    background: #0f172a;
    color: #ffffff;
    z-index: 999999;
    display: none;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.15);
    font-family: Inter, Arial, sans-serif;
}

.zeecv_download_inner {
    width: 100%;
    max-width: 1200px;
    height: 100%;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-sizing: border-box;
}

.zeecv_download_text {
    font-size: 12px;
    color: #cbd5e1;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.zeecv_download_text a {
    color: #60a5fa;
    text-decoration: none;
    margin-left: 5px;
}

.zeecv_download_text a:hover {
    color: #93c5fd;
    text-decoration: underline;
}

.zeecv_download_actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

/* Download button (primary style, same family as accept btn) */
.zeecv_download_btn {
    height: 28px;
    padding: 0 13px;
    border-radius: 5px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #2563eb;
    border: 1px solid #2563eb;
    color: #ffffff;
    text-decoration: none;
    white-space: nowrap;
}

.zeecv_download_btn:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff;
    text-decoration: none;
}

/* Close icon button */
.zeecv_download_close {
    width: 28px;
    height: 28px;
    padding: 0;
    border-radius: 5px;
    background: transparent;
    border: 1px solid #475569;
    color: #cbd5e1;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.zeecv_download_close:hover {
    background: #1e293b;
    border-color: #64748b;
    color: #ffffff;
}

@media (max-width: 700px) {
    .zeecv_download_banner {
        height: auto;
        min-height: 40px;
    }
    .zeecv_download_inner {
        padding: 7px 12px;
        gap: 10px;
    }
    .zeecv_download_text {
        white-space: normal;
        font-size: 11px;
        line-height: 1.4;
    }
    .zeecv_download_actions {
        gap: 5px;
    }
    .zeecv_download_btn {
        height: 27px;
        padding: 0 10px;
        font-size: 11px;
    }
    .zeecv_download_close {
        width: 27px;
        height: 27px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const banner    = document.getElementById('zeecv_download_banner');
    const download  = document.getElementById('zeecv_download_btn');
    const closeBtn  = document.getElementById('zeecv_download_close');
    const KEY       = 'zeecv_download_banner';

    // Show only if user hasn't downloaded or dismissed it yet
    if (localStorage.getItem(KEY) === null) {
        banner.style.display = 'block';
    }

    // On download → remember + hide
    download.addEventListener('click', function () {
        localStorage.setItem(KEY, 'downloaded');
        banner.style.display = 'none';
    });

    // On close (×) → remember + hide
    closeBtn.addEventListener('click', function () {
        localStorage.setItem(KEY, 'dismissed');
        banner.style.display = 'none';
    });
});
</script>