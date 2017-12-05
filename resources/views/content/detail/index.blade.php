@extends('layouts.sub_template')
@section('title', $proyek->nama)

@section('sub_content')
  <div id="root">
    
  </div>
@endsection

@push('js')
<script type="text/javascript" src="{{ url('js/detail-proyek.js') }}"></script>
@endpush
