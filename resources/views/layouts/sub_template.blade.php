@extends('layouts.template')

@section('content')
  {{-- NAVIGATION --}}
  <div class="ui inverted menu">
    <div class="ui container">
      <a href="#" class="header item">
        {{ config('app.nama_perusahaan')}}
      </a>
      <a href="#" class="item">Home</a>
    </div>
  </div>
  {{-- End NAVIGATION --}}

  {{-- SIDEBAR LEFT --}}
  <div class="ui left demo vertical inverted labeled icon sidebar menu visible">
    <a class="item">
      <i class="home icon"></i>
      Home
    </a>
    <a class="item">
      <i class="block layout icon"></i>
      Topics
    </a>
    <a class="item">
      <i class="smile icon"></i>
      Friends
    </a>
  </div>
  {{-- END SIDEBAR LEFT --}}

  @yield('sub_content')

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
