@extends('layout.home')

@section('meta_tags') <title>About ZeeCV - Build a Professional Resume That Gets Noticed</title>


<meta name="description"
      content="Learn about ZeeCV, a modern AI-powered resume builder designed to help job seekers create professional, ATS-friendly resumes and improve their chances of getting hired.">

<meta name="keywords"
      content="about ZeeCV, resume builder, AI resume builder, ATS resume, professional resume, CV maker, resume creator">


@endsection

@section('content')

<style>
    .zeecv_about_outer {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #ffffff;
        color: #1e293b;
    }

    .zeecv_about_hero {
        padding: 150px 20px 90px;
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.10), transparent 35%),
            radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.07), transparent 30%),
            #f8fafc;
        text-align: center;
    }

    .zeecv_about_badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        margin-bottom: 22px;
        border-radius: 50px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 14px;
        font-weight: 600;
    }

    .zeecv_about_hero h1 {
        max-width: 850px;
        margin: 0 auto 20px;
        font-size: 52px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -1.5px;
        color: #0f172a;
    }

    .zeecv_about_hero h1 span {
        color: #2563eb;
    }

    .zeecv_about_hero p {
        max-width: 700px;
        margin: 0 auto;
        color: #64748b;
        font-size: 18px;
        line-height: 1.8;
    }

    .zeecv_about_section {
        padding: 90px 20px;
    }

    .zeecv_about_container {
        max-width: 1120px;
        margin: 0 auto;
    }

    .zeecv_about_two_col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 70px;
        align-items: center;
    }

    .zeecv_about_label {
        color: #2563eb;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 14px;
    }

    .zeecv_about_content h2 {
        margin: 0 0 20px;
        color: #0f172a;
        font-size: 38px;
        line-height: 1.25;
        font-weight: 750;
    }

    .zeecv_about_content p {
        color: #64748b;
        font-size: 16px;
        line-height: 1.85;
        margin-bottom: 16px;
    }

    .zeecv_about_visual {
        position: relative;
    }

    .zeecv_about_visual_card {
        padding: 35px;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
    }

    .zeecv_about_visual_header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .zeecv_about_visual_icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 22px;
    }

    .zeecv_about_visual_header strong {
        display: block;
        color: #0f172a;
        font-size: 18px;
    }

    .zeecv_about_visual_header span {
        display: block;
        color: #94a3b8;
        font-size: 13px;
        margin-top: 3px;
    }

    .zeecv_about_progress {
        margin-bottom: 18px;
    }

    .zeecv_about_progress_top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 7px;
        font-size: 13px;
        color: #475569;
        font-weight: 600;
    }

    .zeecv_about_progress_bar {
        height: 8px;
        border-radius: 20px;
        background: #f1f5f9;
        overflow: hidden;
    }

    .zeecv_about_progress_bar span {
        display: block;
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
    }

    .zeecv_about_mission {
        background: #f8fafc;
        text-align: center;
    }

    .zeecv_about_mission_inner {
        max-width: 800px;
        margin: auto;
    }

    .zeecv_about_mission h2 {
        margin-bottom: 20px;
        color: #0f172a;
        font-size: 38px;
        font-weight: 750;
    }

    .zeecv_about_mission p {
        color: #64748b;
        font-size: 17px;
        line-height: 1.9;
    }

    .zeecv_about_features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 45px;
    }

    .zeecv_about_feature {
        padding: 30px 25px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: #ffffff;
        transition: all .25s ease;
    }

    .zeecv_about_feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
        border-color: #bfdbfe;
    }

    .zeecv_about_feature_icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 20px;
    }

    .zeecv_about_feature h3 {
        margin-bottom: 10px;
        color: #0f172a;
        font-size: 18px;
        font-weight: 700;
    }

    .zeecv_about_feature p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .zeecv_about_cta {
        padding: 85px 20px;
        text-align: center;
    }

    .zeecv_about_cta_box {
        max-width: 950px;
        margin: auto;
        padding: 65px 35px;
        border-radius: 26px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 25px 60px rgba(37, 99, 235, 0.25);
    }

    .zeecv_about_cta h2 {
        margin: 0 0 15px;
        color: #ffffff;
        font-size: 38px;
        font-weight: 750;
    }

    .zeecv_about_cta p {
        max-width: 650px;
        margin: 0 auto 30px;
        color: rgba(255,255,255,.85);
        font-size: 16px;
        line-height: 1.7;
    }

    .zeecv_about_cta a {
        display: inline-block;
        padding: 13px 28px;
        border-radius: 10px;
        background: #ffffff;
        color: #2563eb;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        transition: all .2s ease;
    }

    .zeecv_about_cta a:hover {
        transform: translateY(-2px);
        color: #1d4ed8;
        text-decoration: none;
    }

    @media (max-width: 991px) {

        .zeecv_about_hero h1 {
            font-size: 42px;
        }

        .zeecv_about_two_col {
            grid-template-columns: 1fr;
            gap: 45px;
        }

        .zeecv_about_features {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767px) {

        .zeecv_about_hero {
            padding: 125px 20px 70px;
        }

        .zeecv_about_hero h1 {
            font-size: 34px;
        }

        .zeecv_about_hero p {
            font-size: 16px;
        }

        .zeecv_about_section {
            padding: 65px 20px;
        }

        .zeecv_about_content h2,
        .zeecv_about_mission h2,
        .zeecv_about_cta h2 {
            font-size: 30px;
        }

        .zeecv_about_features {
            grid-template-columns: 1fr;
        }

        .zeecv_about_visual_card {
            padding: 25px;
        }

        .zeecv_about_cta {
            padding: 60px 20px;
        }

        .zeecv_about_cta_box {
            padding: 45px 25px;
        }
    }
</style>

<div class="zeecv_about_outer">


{{-- Hero --}}
<section class="zeecv_about_hero">

    <div class="zeecv_about_badge">
        <i class="fas fa-sparkles"></i>
        About ZeeCV
    </div>

    <h1>
        Your Career Deserves a
        <span>Better Resume</span>
    </h1>

    <p>
        ZeeCV is a modern resume platform built to help job seekers
        create professional, ATS-friendly resumes and present their
        skills and experience with confidence.
    </p>

</section>


{{-- About ZeeCV --}}
<section class="zeecv_about_section">

    <div class="zeecv_about_container">

        <div class="zeecv_about_two_col">

            <div class="zeecv_about_content">

                <div class="zeecv_about_label">
                    Who We Are
                </div>

                <h2>
                    We make creating a great resume simple.
                </h2>

                <p>
                    Your resume is more than a document. It is your
                    introduction to employers, recruiters and hiring
                    managers.
                </p>

                <p>
                    We created ZeeCV to make the resume-building process
                    easier, faster and more professional. Instead of
                    spending hours worrying about formatting and structure,
                    you can focus on presenting your experience and
                    achievements in the best possible way.
                </p>

                <p>
                    Whether you are applying for your first job, changing
                    careers or looking for your next opportunity, ZeeCV
                    gives you the tools to build a resume that represents
                    you professionally.
                </p>

            </div>


            <div class="zeecv_about_visual">

                <div class="zeecv_about_visual_card">

                    <div class="zeecv_about_visual_header">

                        <div class="zeecv_about_visual_icon">
                            <i class="fas fa-file-alt"></i>
                        </div>

                        <div>
                            <strong>Professional Resume</strong>
                            <span>Ready for your next opportunity</span>
                        </div>

                    </div>


                    <div class="zeecv_about_progress">

                        <div class="zeecv_about_progress_top">
                            <span>Professional Summary</span>
                            <span>Complete</span>
                        </div>

                        <div class="zeecv_about_progress_bar">
                            <span style="width: 95%;"></span>
                        </div>

                    </div>


                    <div class="zeecv_about_progress">

                        <div class="zeecv_about_progress_top">
                            <span>Work Experience</span>
                            <span>Complete</span>
                        </div>

                        <div class="zeecv_about_progress_bar">
                            <span style="width: 90%;"></span>
                        </div>

                    </div>


                    <div class="zeecv_about_progress">

                        <div class="zeecv_about_progress_top">
                            <span>Skills</span>
                            <span>Complete</span>
                        </div>

                        <div class="zeecv_about_progress_bar">
                            <span style="width: 88%;"></span>
                        </div>

                    </div>


                    <div class="zeecv_about_progress">

                        <div class="zeecv_about_progress_top">
                            <span>Education</span>
                            <span>Complete</span>
                        </div>

                        <div class="zeecv_about_progress_bar">
                            <span style="width: 92%;"></span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- Mission --}}
<section class="zeecv_about_section zeecv_about_mission">

    <div class="zeecv_about_container">

        <div class="zeecv_about_mission_inner">

            <div class="zeecv_about_label">
                Our Mission
            </div>

            <h2>
                Helping people move forward in their careers
            </h2>

            <p>
                We believe everyone deserves the opportunity to present
                their professional story clearly and confidently.
                Our mission is to remove the complexity from resume
                creation and provide accessible tools that help people
                put their best foot forward in the job market.
            </p>

        </div>


        <div class="zeecv_about_features">

            <div class="zeecv_about_feature">

                <div class="zeecv_about_feature_icon">
                    <i class="fas fa-robot"></i>
                </div>

                <h3>AI-Powered</h3>

                <p>
                    Use intelligent tools to improve your resume content,
                    wording and professional presentation.
                </p>

            </div>


            <div class="zeecv_about_feature">

                <div class="zeecv_about_feature_icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <h3>ATS-Friendly</h3>

                <p>
                    Create structured resumes designed to be easy for
                    applicant tracking systems and recruiters to read.
                </p>

            </div>


            <div class="zeecv_about_feature">

                <div class="zeecv_about_feature_icon">
                    <i class="fas fa-palette"></i>
                </div>

                <h3>Professional Templates</h3>

                <p>
                    Choose clean and professional designs that help your
                    experience and skills stand out.
                </p>

            </div>

        </div>

    </div>

</section>


{{-- CTA --}}
<section class="zeecv_about_cta">

    <div class="zeecv_about_cta_box">

        <h2>
            Ready to build a better resume?
        </h2>

        <p>
            Create a professional resume, showcase your experience and
            take the next step toward your career goals.
        </p>

        <a href="{{ url('signup') }}">
            Create Your Resume
        </a>

    </div>

</section>


</div>

@endsection
