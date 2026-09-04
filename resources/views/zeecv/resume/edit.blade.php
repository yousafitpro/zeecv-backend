@extends('zeecv.resume.layout')
@section('title',"Dashboard")
@section('content')
 


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('assets/favicon/site.webmanifest')}}">
  <link rel="stylesheet" href="{{asset('theme/css/bootstrap.min.css')}}">
  <title>Resume Builder Layout</title>
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="{{ asset('resume/css/bootstrap-4.6.2.min.css') }}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('resume/css/font-awesome-5.15.4.css') }}">
    <!-- JS Dependencies -->
  <script src="{{ asset("resume/js/jquery-3.5.1.min.js") }}"></script>
  
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>
  <script src="{{ asset('resume/js/bootstrap-4.6.2.bundle.min.js') }}"></script>
      <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <link
    rel="stylesheet"
    href="{{ asset('resume/css/colorpicker-classic.min.css') }}"
/>
<script src="{{ asset('resume/js/colorpicker.js') }}"></script>
  @include('zeecv.resume.edit.script')
  @include('zeecv.resume.edit.style')
</head>
<body>

  <!-- Top Navigation Bar -->
  <header class="app-header sticky-top d-flex justify-content-between align-items-center' px-4 py-2 bg-white">
    @if(request('is_app','yes')!='no')
    <a href="{{ route('home.jobs') }}" class="btn btn-link text-secondary text-decoration-none p-0">
      <i class="fas fa-arrow-left mr-2"></i>Jobs
    </a>
    @endif
    <div class="resume-edit-action-buttons">
      @if(request('is_app','yes')!='no')
        <a  onclick="resumePrintFunNewWindow('{{ route('resume.pdf.preview',request('id')) }}?resume={{ now() }}&resume_token={{ auth()->user()->login_token }}')" target="_blank" class="btn btn-save btn-preview px-4 rounded-pill" >PDF Preview</a>
      
      
    <a onclick="resumePrintFunNewWindow('{{ route('resume.pdf',request('id')) }}?resume={{ now() }}&resume_token={{ auth()->user()->login_token }}')" class="btn btn-save px-4 rounded-pill" >Download PDF</a>
  @endif
  </div>
  </header>

  <!-- Main Container -->
  <main class="container-fluid main-wrapper py-4 px-lg-5">
    <div class="row">

      <!-- LEFT COLUMN: Editor Form Controls -->
      <div class="col-lg-4 col-md-5 mb-4">
        
        <!-- Tab Switcher -->
        <div class="toggle-pills d-flex mb-3 p-1 rounded">
          <button class="btn btn-pill active flex-fill" id="btnContentTab">
            <i class="fas fa-pen mr-1"></i> Content
          </button>
          <button class="btn btn-pill flex-fill" id="btnTemplateTab">
            <i class="fas fa-palette mr-1"></i> Template
          </button>
        </div>

        <!-- CONTENT TAB VIEW -->
        <div id="contentView">
          <div class="accordion-list" id="builderAccordion">
            @include('zeecv.resume.components.contact')
           @include('zeecv.resume.components.summary')
           
           @include('zeecv.resume.components.experience')
           @include('zeecv.resume.components.education')
           @include('zeecv.resume.components.skill')
           @include('zeecv.resume.components.language')
           @include('zeecv.resume.components.certificate')



          </div>
        </div>

        @include('zeecv.resume.components.template')

      </div>
   <div class="col-lg-8 col-md-7 d-none d-md-block" style="padding: 0px !important">
     <div class="resumePrintDiveOuter">
     <div class="resumePrintDiveInner">
      <div id="CV_Preview_div" style="width: 100%;background:transparent;"></div>
     </div>
     </div>
   </div>
    </div>
  </main>


 <script>

function resumePrintFun(url) {
    window.location.href = url;
}

function resumePrintFunNewWindow(url) {
const randomNumber = Math.floor(Math.random() * 1000000);
const newUrl = url + '&resume_now=' + randomNumber;

window.open(newUrl, '_blank', 'noopener,noreferrer');
}
      $(document).ready(function(){
      LoadCVPreview()
    })
  function LoadCVPreview() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '{{ route('resume.preview') }}',
            type: 'POST',
            data:{
              'resume_id':'{{ request('id') }}'
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
            },
            success: function(response) {
                $('#CV_Preview_div').html(response);
                resolve(response);
            },
            error: function(xhr, status, error) {
                reject({ xhr, status, error });
            }
        });
    });
}
 </script>


</body>
</html>
@endsection