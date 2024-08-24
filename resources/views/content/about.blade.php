@extends('layouts/contentLayoutMaster')

@section('title', 'About Page')

@section('content')
<!-- Content -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">"About Page" Data</h4>
    @if(session('success'))
    {{ session('success') }}
    @endif
  </div>
  <div class="card-body">
    <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label for="defaultFormControlInput" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3">{{ $about['description'] ?? '' }}</textarea>
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Upload Photo</label>
        <input class="form-control" name="file" type="file" id="file">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
@endsection