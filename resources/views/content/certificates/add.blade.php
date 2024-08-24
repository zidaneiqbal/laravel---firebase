@extends('layouts/contentLayoutMaster')

@section('title', 'Add Certificates')

@section('content')
<!-- Content -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Add Certificates Data</h4>
    @if(session('error'))
    {{ session('error') }}
    @endif
  </div>
  <div class="card-body">
    <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label for="defaultFormControlInput" class="form-label">Name</label>
        <input class="form-control" name="name" id="name" rows="3" required></input>
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Upload Image</label>
        <input class="form-control" name="file" type="file" id="file" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
@endsection