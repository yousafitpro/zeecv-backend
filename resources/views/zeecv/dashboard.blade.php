@extends('layout.master')
@section('title',"Dashboard")
@section('content')

@if (empty($resumes))
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
@else
<!-- Resume List - Only HTML -->
<div class="row" id="resumeContainer">
    
  @foreach ($resumes as $res)
        <!-- Resume Card 1 -->
    
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm" style="border-radius: 12px; transition: all 0.3s;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0 font-weight-bold" style="color: #2c3e50;">
                        Full Stack Developer
                    </h5>
                    <span class="badge badge-success">Published</span>
                </div>
                <p class="card-text text-muted small mb-2">
                    <i class="fas fa-briefcase mr-1"></i> {{ $res->contact->desired_job_title }}
                </p>
                <p class="card-text text-muted small">
                    <i class="far fa-calendar-alt mr-1"></i> Updated: Dec 15, 2025
                </p>
                <div class="mt-3">
                    <span class="badge badge-light"><i class="far fa-file-pdf mr-1"></i> PDF</span>
                    <span class="badge badge-light"><i class="far fa-edit mr-1"></i> Active</span>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between">
                <div>
                    {{-- <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                    </button> --}}
                  <a href="{{ route('resume.edit',unique_encrypt($res->id)) }}"> 
                    <button class="btn btn-sm btn-outline-secondary">
                       <i class="fas fa-edit"></i>
                    </button>
                    </a>
                    {{-- <button class="btn btn-sm btn-outline-info">
                        <i class="fas fa-download"></i>
                    </button> --}}
                </div>
                
                <form action="{{ route('resume.delete', unique_encrypt($res->id)) }}"  
                      method="POST" 
                      onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('GET')
                    <button type="submit"  class="btn btn-sm btn-outline-danger" style="float: right;">
                    <i class="fas fa-trash-alt"></i>
                    </a>
                </form>
            </div>
        </div>
    </div>
    
  @endforeach




    <!-- Create New Resume Card -->
    <div class="col-md-6 col-lg-4 mb-4">
        <a href="{{ route('resume.create') }}" class="card h-100" 
             style="border: 2px dashed #dcdde1; border-radius: 12px; cursor: pointer; transition: all 0.3s;"
             onmouseover="this.style.borderColor='#3498db'; this.style.background='#f8f9fa';"
             onmouseout="this.style.borderColor='#dcdde1'; this.style.background='transparent';">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 200px;">
                <i class="fas fa-plus-circle" style="font-size: 48px; color: #3498db;"></i>
                <h6 class="mt-3 mb-1 font-weight-bold">Create New Resume</h6>
                <p class="text-muted small mb-0">Start building your professional resume</p>
            </div>
          </a>
    </div>

</div>
@endif

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