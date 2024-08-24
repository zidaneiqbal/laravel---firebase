@extends('layouts/contentLayoutMaster')

@section('title', 'Home Page')

@section('content')
<!-- Kick start -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">{{ $about['title'] ?? '' }} 🚀</h4>
  </div>
  <div class="card-body">
    <div class="card-text">
      <p>
        {{ $about['description'] ?? '' }}
      </p>
    </div>
  </div>
</div>
<!--/ Kick start -->

<!-- Page layout -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">What is page layout?</h4>
  </div>
  <div class="card-body">
    <div class="card-text">
      <p>
        Starter kit includes pages with different layouts, useful for your next project to start development process
        from scratch with no time.
      </p>
      <ul>
        <li>Each layout includes required only assets only.</li>
        <li>
          Select your choice of layout from starter kit, customize it with optional changes like colors and branding,
          add required dependency only.
        </li>
      </ul>
      <div class="alert alert-primary" role="alert">
        <div class="alert-body">
          <strong>Info:</strong> Please check the &nbsp;<a
            class="text-primary"
            href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation/documentation-layouts.html#layout-collapsed-menu"
            target="_blank"
            >Layout documentation</a
          >&nbsp; for more layout options i.e collapsed menu, without menu, empty & blank.
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Page layout -->
@endsection