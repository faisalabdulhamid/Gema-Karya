@extends('layouts.template')

@section('content')
  {{-- NAVIGATION --}}
  <div class="ui inverted menu">
    <div class="ui container">
      <a href="#" class="header item">
        {{ config('application.nama_perusahaan')}}
      </a>
    </div>
  </div>
  {{-- End NAVIGATION --}}

  <div>
    {{-- SIDEBAR LEFT --}}
    <div class="ui left demo vertical inverted labeled icon sidebar menu visible">
      <a class="item" href="{{ route('home') }}">
        <i class="home icon"></i>
        Home
      </a>
      <a class="item" href="{{ route('proyek.index') }}">
        <i class="browser layout icon"></i>
        Proyek
      </a>
      </a>
      <a class="item" href="{{ route('resiko.index') }}">
        <i class="block layout icon"></i>
        Resiko
      </a>
      <a class="item" href="{{ route('bahan-baku.index') }}">
        <i class="block layout icon"></i>
        Bahan
      </a>
      <a class="item" href="{{ route('pekerjaan.index') }}">
        <i class="block layout icon"></i>
        Pekerjaan
      </a>
      <a class="item" href="{{ route('pegawai.index') }}">
        <i class="block layout icon"></i>
        Pegawai
      </a>
    </div>
    {{-- END SIDEBAR LEFT --}}

    @yield('sub_content')

    @yield('modal')
  </div>

  {{-- FOOTER --}}
  <div class="ui inverted vertical footer segment">
    <div class="ui center aligned container">
      <div class="ui horizontal inverted small divided link list">
        <a class="item" href="#">Site Map</a>
        <a class="item" href="#">Contact Us</a>
        <a class="item" href="#">Terms and Conditions</a>
        <a class="item" href="#">Privacy Policy</a>
      </div>
    </div>
  </div>
  {{-- END FOOTER --}}
@endsection

@push('js')
<script>
$("#btn-modal").click(function(){
  console.log("modal");
  $('.ui.basic.modal').modal('show');
})
</script>
@endpush
