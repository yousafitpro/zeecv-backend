@extends('layout.home')

@section('title',"User Profile")

@section('content')

<style>
    /* =========================================================
       PROFILE PAGE
       All custom styles are scoped under #profile_update_div
    ========================================================= */

    #profile_update_div {
        min-height: calc(100vh - 70px);
        padding: 35px 15px 50px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                     Roboto, Helvetica, Arial, sans-serif;
        color: #1f2937;
    }

    /* Main Container */
    #profile_update_div .profile-page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header */
    #profile_update_div .profile-page-header {
        margin-bottom: 25px;
    }

    #profile_update_div .profile-page-title {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 5px;
        letter-spacing: -0.3px;
    }

    #profile_update_div .profile-page-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Profile Header Card */
    #profile_update_div .profile-summary-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        margin-bottom: 24px;
        overflow: hidden;
    }

    #profile_update_div .profile-summary-top {
        height: 85px;
        background: linear-gradient(90deg, #2993da 0%, #7358FF 50%, #B351FF 100%);
        border-bottom: 1px solid #e5e7eb;
    }

    #profile_update_div .profile-summary-content {
        padding: 0 30px 25px;
        position: relative;
    }

    #profile_update_div .profile-avatar-wrapper {
        width: 92px;
        height: 92px;
        border-radius: 50%;
        background: #ffffff;
        border: 4px solid #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        margin-top: -46px;
        position: relative;
        overflow: hidden;
    }

    #profile_update_div .profile-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #profile_update_div .profile-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2f7;
        color: #64748b;
        font-size: 34px;
    }

    #profile_update_div .profile-summary-info {
        margin-top: 12px;
    }

    #profile_update_div .profile-summary-name {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px;
    }

    #profile_update_div .profile-summary-email {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    /* Cards */
    #profile_update_div .profile-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    #profile_update_div .profile-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #ffffff;
        display: flex;
        align-items: center;
    }

    #profile_update_div .profile-card-header-icon {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: #475569;
        font-size: 16px;
    }

    #profile_update_div .profile-card-header-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    #profile_update_div .profile-card-header-subtitle {
        margin: 2px 0 0;
        font-size: 12px;
        color: #6b7280;
    }

    #profile_update_div .profile-card-body {
        padding: 25px 24px;
    }

    /* Labels */
    #profile_update_div .profile-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }

    /* Inputs */
    #profile_update_div .profile-input {
        display: block;
        width: 100%;
        height: 44px;
        padding: 9px 13px;
        font-size: 14px;
        color: #111827;
        background: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    #profile_update_div .profile-input:hover {
        border-color: #9ca3af;
    }

    #profile_update_div .profile-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        background: #ffffff;
    }

    #profile_update_div .profile-input[readonly],
    #profile_update_div .profile-input:disabled {
        background: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }

    #profile_update_div .profile-form-group {
        margin-bottom: 20px;
    }

    #profile_update_div .profile-form-group:last-child {
        margin-bottom: 0;
    }

    /* Input Help Text */
    #profile_update_div .profile-help-text {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #9ca3af;
    }

    /* File Upload */
    #profile_update_div .profile-upload-box {
        position: relative;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 8px;
        padding: 18px;
        transition: all .2s ease;
        cursor: pointer;
    }

    #profile_update_div .profile-upload-box:hover {
        border-color: #2563eb;
        background: #f8fbff;
    }

    #profile_update_div .profile-upload-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    #profile_update_div .profile-upload-content {
        display: flex;
        align-items: center;
    }

    #profile_update_div .profile-upload-icon {
        width: 42px;
        height: 42px;
        border-radius: 7px;
        background: #eaf2ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 13px;
        font-size: 18px;
    }

    #profile_update_div .profile-upload-title {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin: 0 0 3px;
    }

    #profile_update_div .profile-upload-subtitle {
        font-size: 12px;
        color: #9ca3af;
        margin: 0;
    }

    /* Buttons */
    #profile_update_div .profile-btn {
        border: none;
        border-radius: 6px;
        min-height: 42px;
        padding: 9px 18px;
        font-size: 14px;
        font-weight: 600;
        transition: all .2s ease;
        cursor: pointer;
    }

    #profile_update_div .profile-btn-primary {
        background: #2557a7;
        color: #ffffff;
    }

    #profile_update_div .profile-btn-primary:hover {
        background: #1d4a91;
        color: #ffffff;
        box-shadow: 0 2px 5px rgba(37, 87, 167, 0.25);
    }

    #profile_update_div .profile-btn i {
        margin-right: 6px;
    }

    /* Password Section */
    #profile_update_div .password-security-note {
        display: flex;
        align-items: flex-start;
        padding: 12px 14px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        margin-bottom: 22px;
    }

    #profile_update_div .password-security-note-icon {
        color: #64748b;
        margin-right: 10px;
        margin-top: 2px;
    }

    #profile_update_div .password-security-note-text {
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    /* Password Divider */
    #profile_update_div .profile-section-divider {
        border: 0;
        border-top: 1px solid #e5e7eb;
        margin: 24px 0;
    }

    /* Required */
    #profile_update_div .profile-required {
        color: #dc2626;
        margin-left: 2px;
    }

    /* Responsive */
    @media (max-width: 991px) {
        #profile_update_div {
            padding-top: 25px;
        }
    }

    @media (max-width: 767px) {

        #profile_update_div {
            padding: 20px 10px 35px;
        }

        #profile_update_div .profile-page-title {
            font-size: 22px;
        }

        #profile_update_div .profile-summary-content {
            padding-left: 20px;
            padding-right: 20px;
        }

        #profile_update_div .profile-card-body {
            padding: 20px;
        }

        #profile_update_div .profile-card-header {
            padding: 16px 20px;
        }

        #profile_update_div .profile-upload-content {
            align-items: flex-start;
        }

        #profile_update_div .profile-summary-name {
            font-size: 19px;
        }
    }
</style>


<div id="profile_update_div">

    <div class="profile-page-wrapper">

        <!-- Page Header -->
        <div class="profile-page-header">
            <h1 class="profile-page-title">Profile settings</h1>
            <p class="profile-page-subtitle">
                Manage your personal information and account security.
            </p>
        </div>


        <!-- Profile Summary -->
        <div class="profile-summary-card">

            <div class="profile-summary-top"></div>

            <div class="profile-summary-content">

                <div class="profile-avatar-wrapper">

                    @if(!empty($record->avatar))

                        <img src="{{auth()->user()->avatar()}}" alt="{{ $record->name }}">

                    @else

                        <div class="profile-avatar-placeholder">
                            <i class="ti-user"></i>
                        </div>

                    @endif

                </div>

                <div class="profile-summary-info">

                    <h2 class="profile-summary-name">
                        {{ $record->name }}
                    </h2>

                    <p class="profile-summary-email">
                        {{ $record->email }}
                    </p>

                </div>

            </div>

        </div>


        <div class="row">

            <!-- LEFT COLUMN -->
            <div class="col-lg-7">

                <!-- Personal Information -->
                <div class="profile-card">

                    <div class="profile-card-header">

                        <div class="profile-card-header-icon">
                             <i class="fa fa-user"></i>
                        </div>

                        <div>
                            <h2 class="profile-card-header-title">
                                Personal information
                            </h2>

                            <p class="profile-card-header-subtitle">
                                Update your personal and contact details.
                            </p>
                        </div>

                    </div>


                    <div class="profile-card-body">

                        <form
                            method="POST"
                            enctype="multipart/form-data"
                            action="{{ route('home.user.profile.update') }}"
                        >

                            @csrf


                            <!-- Avatar -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    Profile photo
                                </label>

                                <div class="profile-upload-box">

                                    <input
                                        type="file"
                                        name="avatar"
                                        accept="image/*"
                                        class="profile-upload-input"
                                    >

                                    <div class="profile-upload-content">

                                        <div class="profile-upload-icon">
                                            <i class="fa fa-upload"></i>
                                        </div>

                                        <div>

                                            <p class="profile-upload-title">
                                                Upload a new profile photo
                                            </p>

                                            <p class="profile-upload-subtitle">
                                                JPG, JPEG or PNG. Recommended size 400 × 400px.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <!-- Full Name -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    Full name
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ $record->name }}"
                                    class="profile-input"
                                    
                                    required
                                >

                                <small class="profile-help-text">
                                    Your name is managed by your account.
                                </small>

                            </div>


                            <!-- Email -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    Email address
                                </label>

                                <input
                                    type="email"
                                    value="{{ $record->email }}"
                                    class="profile-input"
                                    disabled
                                >

                                <small class="profile-help-text">
                                    Your email address cannot be changed here.
                                </small>

                            </div>


                            <!-- Phone -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    Phone number
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ $record->phone }}"
                                    class="profile-input"
                                    placeholder="Enter your phone number"
                                >

                            </div>


                            <!-- Address -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    Address
                                </label>

                                <input
                                    type="text"
                                    name="address"
                                    value="{{ $record->address }}"
                                    class="profile-input"
                                    placeholder="Street address"
                                >

                            </div>


                            <!-- City / Zip -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="profile-form-group">

                                        <label class="profile-label">
                                            City
                                        </label>

                                        <input
                                            type="text"
                                            name="city"
                                            value="{{ $record->city }}"
                                            class="profile-input"
                                            placeholder="City"
                                        >

                                    </div>

                                </div>



                                <div class="col-md-3">

                                    <div class="profile-form-group">

                                        <label class="profile-label">
                                            ZIP / Postal code
                                        </label>

                                        <input
                                            type="text"
                                            name="zipcode"
                                            value="{{ $record->zipcode }}"
                                            class="profile-input"
                                            placeholder="ZIP code"
                                        >

                                    </div>

                                </div>
                                <div class="col-md-3">

                                    <div class="profile-form-group">

                                        <label class="profile-label">
                                            Country
                                        </label>

                                        <input
                                            type="text"
                                            name="country"
                                            value="{{ $record->country }}"
                                            class="profile-input"
                                            placeholder="Country"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- Submit -->
                            <div class="text-right mt-2">

                                <button
                                    type="submit"
                                    class="profile-btn profile-btn-primary"
                                >
                                    <i class="ti-save"></i>
                                    Save changes
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            <!-- RIGHT COLUMN -->
            <div class="col-lg-5">

                <!-- Account Security -->
                <div class="profile-card">

                    <div class="profile-card-header">

                        <div class="profile-card-header-icon">
                            <i class="fa fa-lock"></i>
                        </div>

                        <div>

                            <h2 class="profile-card-header-title">
                                Account security
                            </h2>

                            <p class="profile-card-header-subtitle">
                                Keep your account secure.
                            </p>

                        </div>

                    </div>


                    <div class="profile-card-body">

                        <div class="password-security-note">

                            <div class="password-security-note-icon">
                                <i class="ti-info-alt"></i>
                            </div>

                            <p class="password-security-note-text">
                                Choose a strong password that you don't use
                                anywhere else. Your password should be difficult
                                for others to guess.
                            </p>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('changePasswordPost') }}"
                        >

                            @csrf


                            <!-- Current Password -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    Current password
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    type="password"
                                    name="old_password"
                                    class="profile-input"
                                    placeholder="Enter current password"
                                    autocomplete="current-password"
                                    required
                                >

                            </div>


                            <!-- New Password -->
                            <div class="profile-form-group">

                                <label class="profile-label">
                                    New password
                                    <span class="profile-required">*</span>
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="profile-input"
                                    placeholder="Enter new password"
                                    autocomplete="new-password"
                                    required
                                >

                            </div>


                            <div class="text-right mt-3">

                                <button
                                    type="submit"
                                    class="profile-btn profile-btn-primary"
                                >
                                    <i class="ti-lock"></i>
                                    Update password
                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                <!-- Account Information -->
                <div class="profile-card">

                    <div class="profile-card-header">

                        <div class="profile-card-header-icon">
                             <i class="fa fa-info"></i>
                        </div>

                        <div>

                            <h2 class="profile-card-header-title">
                                Account information
                            </h2>

                            <p class="profile-card-header-subtitle">
                                Basic information about your account.
                            </p>

                        </div>

                    </div>


                    <div class="profile-card-body">

                        <div class="profile-form-group">

                            <label class="profile-label">
                                Email address
                            </label>

                            <input
                                type="email"
                                value="{{ $record->email }}"
                                class="profile-input"
                                disabled
                            >

                        </div>

                        <div class="profile-form-group">

                            <label class="profile-label">
                                Account status
                            </label>

                            <input
                                type="text"
                                value="Active"
                                class="profile-input"
                                disabled
                            >

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@stop

@section('js')
@endsection