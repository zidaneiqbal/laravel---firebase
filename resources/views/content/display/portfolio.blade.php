@extends('content/display/layouts/mainLayout')

@section('title', 'Portfolio')

@section('content')
<div class="container-fluid p-4">
  <div class="row min-vh-100 align-items-center justify-content-center text-center text-white">
    <div class="row">
      @if($portfolios)
      @foreach($portfolios as $portfolio)
      <div class="col-md-4 col-sm-6 mb-4">
        <a href="{{ $portfolio['link'] }}" target="_blank">
          <div class="card cursor-pointer">
            <img src="{{ asset('storage/' . $portfolio['photo']) }}" class="card-img-top portfolio-image" alt="{{ $portfolio['name'] }}">
            <div class="card-body">
              <h5 class="card-title">{{ $portfolio['name'] }}</h5>
            </div>
          </div>
        </a>
      </div>
      @endforeach
      @else
      <div class="col-12">
        <p class="text-center">No portfolios available at the moment.</p>
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

  .portfolio-image {
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .card:hover {
      transform: scale(1.2);
      z-index: 999 !important;
      position: relative !important;
  }

  .card {
    background-color: #ffc0ad;
  }

  .card-title {
    color: #271c19;
    font-weight: 700 !important;
    margin-bottom: 0 !important;
  }
</style>
@endpush