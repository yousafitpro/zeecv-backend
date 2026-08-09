<div class="mt-4">
    <div class="unlock-card">

```
    <div class="unlock-card-content">

        <div class="unlock-card-left">
            <div class="unlock-badge">
                <i class="fa-solid fa-lock-open"></i>
            </div>

            <div>
                <div class="unlock-label">
                    PREMIUM ACCESS
                </div>

                <h5 class="unlock-title">
                    Unlock Your Professional Resume
                </h5>

                <p class="unlock-description">
                    Complete your payment to unlock your resume and
                    access all premium features.
                </p>
            </div>
        </div>

        <a href="{{ route('resume.pay_and_unlock') }}"
           class="unlock-button">
            <span>Pay & Unlock</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>

    <div class="unlock-footer">
        <span>
            <i class="fa-solid fa-shield-halved"></i>
            Secure payment
        </span>

        <span class="unlock-divider"></span>

        <span>
            <i class="fa-solid fa-circle-check"></i>
            Instant access
        </span>
    </div>

</div>
```

</div>

<style>
    .unlock-card {
        position: relative;
        background: #ffffff;
        border: 1px solid #e9e6e2;
        border-radius: 16px;
        padding: 22px 24px 16px;
        box-shadow:
            0 2px 5px rgba(0, 0, 0, 0.02),
            0 8px 25px rgba(0, 0, 0, 0.045);
        transition: all 0.25s ease;
    }

    .unlock-card:hover {
        border-color: #ddd7d0;
        box-shadow:
            0 4px 8px rgba(0, 0, 0, 0.025),
            0 12px 32px rgba(0, 0, 0, 0.07);
        transform: translateY(-1px);
    }

    .unlock-card-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
    }

    .unlock-card-left {
        display: flex;
        align-items: center;
        min-width: 0;
    }

    .unlock-badge {
        width: 48px;
        height: 48px;
        min-width: 48px;
        margin-right: 16px;
        border-radius: 13px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #faf6f1;
        color: #a66f45;

        font-size: 18px;
    }

    .unlock-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.2px;
        color: #a66f45;
        margin-bottom: 3px;
    }

    .unlock-title {
        margin: 0 0 5px;
        color: #252525;
        font-size: 16px;
        font-weight: 650;
        letter-spacing: -0.2px;
    }

    .unlock-description {
        margin: 0;
        color: #77736f;
        font-size: 13px;
        line-height: 1.5;
    }

    .unlock-button {
        flex-shrink: 0;

        display: inline-flex;
        align-items: center;
        gap: 10px;

        padding: 11px 18px;
        border-radius: 9px;

        background: #252525;
        color: #ffffff;

        text-decoration: none;
        font-size: 13px;
        font-weight: 600;

        transition: all 0.2s ease;
    }

    .unlock-button:hover {
        background: #111111;
        color: #ffffff;
        transform: translateX(2px);
    }

    .unlock-button i {
        font-size: 11px;
        transition: transform 0.2s ease;
    }

    .unlock-button:hover i {
        transform: translateX(3px);
    }

    .unlock-footer {
        display: flex;
        align-items: center;
        gap: 12px;

        margin-top: 17px;
        padding-top: 13px;

        border-top: 1px solid #f0eeeb;

        color: #99948e;
        font-size: 11px;
    }

    .unlock-footer i {
        margin-right: 5px;
        font-size: 10px;
        color: #aaa39c;
    }

    .unlock-divider {
        width: 1px;
        height: 12px;
        background: #e5e2de;
    }

    @media (max-width: 650px) {
        .unlock-card-content {
            align-items: flex-start;
            flex-direction: column;
        }

        .unlock-button {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 450px) {
        .unlock-card {
            padding: 20px;
        }

        .unlock-card-left {
            align-items: flex-start;
        }

        .unlock-badge {
            width: 42px;
            height: 42px;
            min-width: 42px;
            margin-right: 12px;
        }

        .unlock-title {
            font-size: 15px;
        }

        .unlock-description {
            font-size: 12px;
        }
    }
</style>
