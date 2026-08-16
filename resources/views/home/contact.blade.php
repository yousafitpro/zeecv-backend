@extends('layout.home')

@section('meta_tags')
    <title>Contact Us | ZeeCV</title>
    <meta name="description" content="Get in touch with ZeeCV. We're here to help with your resume, job search, and any questions you may have.">
@endsection

@section('content')

<style>
    .contact_us_outer_div {
        background: #f7f9fc;
        padding: 60px 15px;
        min-height: 70vh;
    }

    .contact_us_outer_div .contact_us_wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .contact_us_outer_div .contact_us_header {
        text-align: center;
        margin-bottom: 40px;
    }

    .contact_us_outer_div .contact_us_badge {
        display: inline-block;
        background: rgba(13, 110, 253, 0.08);
        color: #0d6efd;
        padding: 7px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .contact_us_outer_div .contact_us_title {
        font-size: 36px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .contact_us_outer_div .contact_us_subtitle {
        color: #6b7280;
        font-size: 16px;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .contact_us_outer_div .contact_us_card {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 35px rgba(31, 41, 55, 0.08);
        border: 1px solid #edf0f5;
    }

    .contact_us_outer_div .contact_us_info {
        background: #111827;
        color: #ffffff;
        height: 100%;
        padding: 40px 35px;
    }

    .contact_us_outer_div .contact_us_info_title {
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .contact_us_outer_div .contact_us_info_text {
        color: #cbd5e1;
        line-height: 1.7;
        font-size: 14px;
        margin-bottom: 35px;
    }

    .contact_us_outer_div .contact_us_info_item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .contact_us_outer_div .contact_us_info_icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
        color: #ffffff;
        font-size: 16px;
    }

    .contact_us_outer_div .contact_us_info_item h6 {
        margin: 0 0 4px;
        font-size: 14px;
        font-weight: 600;
    }

    .contact_us_outer_div .contact_us_info_item p {
        margin: 0;
        color: #cbd5e1;
        font-size: 13px;
        line-height: 1.5;
        word-break: break-word;
    }

    .contact_us_outer_div .contact_us_form {
        padding: 40px 35px;
    }

    .contact_us_outer_div .contact_us_form_title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 25px;
    }

    .contact_us_outer_div .contact_us_label {
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .contact_us_outer_div .contact_us_input {
        width: 100%;
        height: 48px;
        border: 1px solid #dfe3e8;
        border-radius: 7px;
        padding: 0 14px;
        font-size: 14px;
        color: #1f2937;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }

    .contact_us_outer_div .contact_us_input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08);
    }

    .contact_us_outer_div .contact_us_textarea {
        width: 100%;
        min-height: 145px;
        resize: vertical;
        border: 1px solid #dfe3e8;
        border-radius: 7px;
        padding: 13px 14px;
        font-size: 14px;
        color: #1f2937;
        outline: none;
        transition: all 0.2s ease;
    }

    .contact_us_outer_div .contact_us_textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08);
    }

    .contact_us_outer_div .contact_us_submit {
        height: 48px;
        padding: 0 28px;
        border: 0;
        border-radius: 7px;
        background: #0d6efd;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .contact_us_outer_div .contact_us_submit:hover {
        background: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
    }

    .contact_us_outer_div .contact_us_required {
        color: #dc3545;
    }

    .contact_us_outer_div .contact_us_alert {
        border-radius: 7px;
        font-size: 14px;
    }

    @media (max-width: 767px) {
        .contact_us_outer_div {
            padding: 40px 10px;
        }

        .contact_us_outer_div .contact_us_title {
            font-size: 28px;
        }

        .contact_us_outer_div .contact_us_subtitle {
            font-size: 14px;
        }

        .contact_us_outer_div .contact_us_info {
            padding: 30px 25px;
        }

        .contact_us_outer_div .contact_us_form {
            padding: 30px 20px;
        }
    }
</style>

<div class="contact_us_outer_div">

    <div class="contact_us_wrapper">

        {{-- Header --}}
        <div class="contact_us_header">
            <span class="contact_us_badge">Get In Touch</span>

            <h1 class="contact_us_title">
                Contact Us
            </h1>

            <p class="contact_us_subtitle">
                Have a question, feedback, or need help with ZeeCV?
                Send us a message and our team will get back to you as soon as possible.
            </p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success contact_us_alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div class="alert alert-danger contact_us_alert">
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contact_us_card">

            <div class="row no-gutters">

                {{-- Contact Information --}}
                <div class="col-lg-5">

                    <div class="contact_us_info">

                        <h2 class="contact_us_info_title">
                            Let's talk
                        </h2>

                        <p class="contact_us_info_text">
                            Whether you have a question about our services,
                            need assistance with your resume, or simply want
                            to share your feedback, we'd love to hear from you.
                        </p>

                        <div class="contact_us_info_item">

                            <div class="contact_us_info_icon">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div>
                                <h6>Email</h6>
                                <p>support@zeecv.com</p>
                            </div>

                        </div>

                        <div class="contact_us_info_item">

                            <div class="contact_us_info_icon">
                                <i class="fas fa-clock"></i>
                            </div>

                            <div>
                                <h6>Response Time</h6>
                                <p>
                                    We usually respond within 24 hours.
                                </p>
                            </div>

                        </div>

                        <div class="contact_us_info_item">

                            <div class="contact_us_info_icon">
                                <i class="fas fa-headset"></i>
                            </div>

                            <div>
                                <h6>Support</h6>
                                <p>
                                    Our team is here to help you with any questions.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Contact Form --}}
                <div class="col-lg-7">

                    <div class="contact_us_form">

                        <h2 class="contact_us_form_title">
                            Send us a message
                        </h2>

                        <form method="POST" action="{{ route('home.contact_post') }}">

                            @csrf

                            <div class="form-row">

                                <div class="form-group col-md-6">

                                    <label class="contact_us_label">
                                        Name <span class="contact_us_required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="contact_us_input"
                                        placeholder="Enter your name"
                                        required
                                    >

                                </div>

                                <div class="form-group col-md-6">

                                    <label class="contact_us_label">
                                        Email <span class="contact_us_required">*</span>
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="contact_us_input"
                                        placeholder="Enter your email"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="contact_us_label">
                                    Subject <span class="contact_us_required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    class="contact_us_input"
                                    placeholder="What is this about?"
                                    required
                                >

                            </div>

                            <div class="form-group">

                                <label class="contact_us_label">
                                    Message <span class="contact_us_required">*</span>
                                </label>

                                <textarea
                                    name="message"
                                    class="contact_us_textarea"
                                    placeholder="Write your message here..."
                                    required
                                >{{ old('message') }}</textarea>

                            </div>

                            <button
                                type="submit"
                                class="contact_us_submit"
                            >
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send Message
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection