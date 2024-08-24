@extends('content/display/layouts/mainLayout')

@section('title', 'About')

@section('content')
<div class="container-fluid" style="background-color: #55423d;">
  <div class="row min-vh-100 align-items-center justify-content-center text-center text-white">
    <div class="col-md-8 col-lg-6">
      <!-- Foto -->
      <div class="mb-4">
        <img src="{{ $about['file_photo'] ? asset('storage/' . $about['file_photo']) : asset('default-photo.jpg') }}" alt="About Photo" class="img-fluid rounded-circle" style="width: 175px; height: auto;">
      </div>

      <!-- Deskripsi -->
      <div class="about-description">
        <p>{{ $about['description'] }}</p>
      </div>
    </div>
  </div>
</div>
@endsection
@push('styles')
<style>
  .about-description {
    margin: 0 auto;
    padding: 20px;
    /* Optional: semi-transparent background */
    border-radius: 10px;
    /* Optional: rounded corners */
  }

  .about-description p {
    font-size: 1.2rem;
  }

  .img-fluid {
    max-width: 100%;
    height: auto;
  }
</style>
@endpush