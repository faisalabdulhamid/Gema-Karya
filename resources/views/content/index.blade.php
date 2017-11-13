@extends('layouts.sub_template')
@section('title', 'Home')
@push('css')
<style>
  #home .container{
    min-height: 100vh;
    padding: 30px;
  }
</style>
@endpush
@section('sub_content')
  <div id="home">
    <div class="ui container">
      <h1>Selamat Datang</h1>
    </div>
  </div>
@endsection
