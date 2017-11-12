@extends('layouts.sub_template')
@section('title', 'Proyek')

@section('sub_content')
  <div id="root">
    <index></index>
    <modal></modal>
  </div>
@endsection

@push('js')
<script type="text/javascript" src="{{ url('js/proyek.js') }}"></script>
<script>
  $('#plus').click(function(){
    $('#form-modal').modal('show');
  })
</script>
@endpush
