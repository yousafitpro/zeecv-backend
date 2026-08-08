@extends('zeecv.resume.layout')
@section('title',"Dashboard")
@section('content')
@include('zeecv.resume.edit.style')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume Builder Layout</title>
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- JS Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

  <!-- Top Navigation Bar -->
  <header class="app-header d-flex justify-content-between align-items-center px-4 py-2 bg-white">
    <a href="#" class="btn btn-link text-secondary text-decoration-none p-0">
      <i class="fas fa-arrow-left mr-2"></i>Back to previous page
    </a>
    <button class="btn btn-save px-4 rounded-pill">Save</button>
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
           @include('zeecv.resume.components.experience')



          </div>
        </div>

        @include('zeecv.resume.components.template')

      </div>

        @include('zeecv.resume.components.preview')

    </div>
  </main>



 @include('zeecv.resume.edit.script')
</body>
</html>
@endsection