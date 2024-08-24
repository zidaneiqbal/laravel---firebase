@extends('layouts/contentLayoutMaster')

@section('title', 'Certificates Page')

@section('content')
<!-- Content -->
<div class="card">
  <div class="card-header">
    <a href="{{ url('admin/certificates/add') }}" class="btn btn-primary">Add +</a>
  </div>
  <div class="card-body">
    <table id="certificates-table" class="datatables-users table">
      <thead class="table-light">
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>Photo</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
    $('#certificates-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('certificates.data') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'photo',
          name: 'photo',
          orderable: false,
          searchable: false
        },
        {
          data: 'actions',
          name: 'actions',
          orderable: false,
          searchable: false
        }
      ]
    });

    window.deleteCertificate = function(id) {
      if (confirm('Are you sure you want to delete this certificate?')) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: '{{ url("certificates/delete") }}/' + id,
          type: 'DELETE',
          success: function(result) {
            $('#certificates-table').DataTable().ajax.reload();
            alert(result.success);
          },
          error: function(xhr) {
            alert('An error occurred: ' + xhr.responseText);
          }
        });
      }
    };
  });
</script>
@endpush