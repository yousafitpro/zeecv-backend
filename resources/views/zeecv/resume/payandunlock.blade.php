<div class="container py-5">
    <br>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

        <div class="zeecv-info-card">

            <div class="zeecv-icon">
                <img src="{{asset('app-icons/white-logo.png')}}" style="width: 100px;">
            </div>
        <br>
            <h4>We're Improving ZeeCV</h4>

            <p>
                We're working on new resume templates and making it even
                easier to create a professional resume.
            </p>

            <p class="text-muted small mb-4">
                Stay connected with ZeeCV for new templates, features,
                and improvements coming your way.
            </p>

            <a href="{{ url('dashboard') }}" class="zeecv-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to My Resume
            </a>

        </div>

    </div>
</div>


</div>

<style>
    .zeecv-info-card {
        background: #fff;
        /* border: 1px solid #e9e5e1; */
        border-radius: 14px;
        padding: 35px 30px;
        text-align: center;
        /* box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04); */
    }

    .zeecv-icon {
        width: 55px;
        height: 55px;
        margin: 0 auto 18px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #faf5ef;
        color: #b67a4f;
        border-radius: 12px;

        font-size: 21px;
    }

    .zeecv-info-card h4 {
        margin-bottom: 10px;
        color: #292929;
        font-weight: 650;
    }

    .zeecv-info-card p {
        max-width: 520px;
        margin: 0 auto 8px;
        color: #666;
        font-size: 14px;
        line-height: 1.7;
    }

    .zeecv-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 9px 17px;
        border-radius: 8px;

        background: #292929;
        color: #fff;

        text-decoration: none;
        font-size: 13px;
        font-weight: 600;

        transition: .2s ease;
    }

    .zeecv-btn:hover {
        background: #111;
        color: #fff;
    }
</style>
