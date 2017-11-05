@extends('layouts.sub_template')
@section('title', 'Proyek')

@section('sub_content')
  <div id="proyek">
    <index></index>
  </div>
@endsection

@push('js')
<script type="text/javascript" src="{{ url('js/proyek.js') }}"></script>
@endpush
