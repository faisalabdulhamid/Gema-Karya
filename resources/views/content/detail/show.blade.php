@extends('layouts.sub_template')
@section('title', $proyek->nama)

@section('sub_content')
  <div id="root">
    <index></index>
  </div>
@endsection

@push('js')
<script type="text/javascript" src="{{ url('js/detail-proyek.js') }}"></script>
<script>
  $('#plus').click(function(){
    $('#form-modal').modal('show');
  })
</script>
@endpush
