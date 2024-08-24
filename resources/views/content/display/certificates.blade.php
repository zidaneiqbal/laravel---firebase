@extends('content/display/layouts/mainLayout')

@section('title', 'Certificates')

@section('content')
<div class="container-fluid p-4">
  <div class="row min-vh-100 align-items-center justify-content-center text-center text-white">
    <div class="row">
      @if($certificates)
      @foreach($certificates as $certificate)
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="card shadow-sm">
          @if(isset($certificate['photo']))
          <img src="{{ asset('storage/' . $certificate['photo']) }}" class="card-img-top" alt="{{ $certificate['name'] }}">
          @else
          <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="{{ $certificate['name'] }}">
          @endif
          <div class="card-body">
            <h5 class="card-title text-center">{{ $certificate['name'] }}</h5>
          </div>
        </div>
      </div>
      @endforeach
      @else
      <div class="col-12">
        <p class="text-center">No certificates available at the moment.</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
@push('styles')
<style>
  .container-fluid {
    background-color: #55423d;
  }
</style>
@endpush