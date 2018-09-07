@section('after_styles')
  <!-- DATA TABLES -->
 

  <link href="{{ asset('vendor/adminlte') }}/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />



@endsection

@push('scripts')

    <!-- DATA TABLES SCRIPT -->
   <script src="{{ asset('vendor/adminlte') }}/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    
    <script src="{{ asset('vendor/adminlte') }}/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
@endpush