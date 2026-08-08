@extends('layout.master')
@section('title',"Dashboard")
@section('content')
<div class="row">
  <div class="col-md-12">
    <!-- Empty State - No Resumes Created Yet -->
    <div class="text-center py-5">
      <i class="fas fa-file-alt" style="font-size: 80px; color: #dcdde1; display: block; margin-bottom: 20px;"></i>
      <h4 class="mb-2">No Resumes Created Yet</h4>
      <p class="text-muted mb-4">Create your first resume to get started</p>
      
      <!-- Big Circle Create Button -->
      <a href="{{ route('resume.create') }}" class="create-resume-circle" >
        <i class="fas fa-plus"></i>
        <span>Create Resume</span>
      </a>
    </div>
  </div>
</div>

<style>
  /* Create Resume Button (Big Circle) */
  .create-resume-circle {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
  }
  .create-resume-circle:hover {

    transform: scale(1.05);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
  }
   a:hover{
    color: white !important;
   }
  .create-resume-circle i {
    font-size: 48px;
    margin-bottom: 10px;
  }
  .create-resume-circle span {
    font-size: 16px;
    font-weight: 600;
  }
</style>
@endsection