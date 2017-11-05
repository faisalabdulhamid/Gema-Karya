@extends('layouts.template')
@section('title', 'Login '.config('application.nama_perusahaan'))

@section('content')
<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="{{ url('images/logo.jpg') }}" class="image">
      <div class="content">
        {{ config('application.nama_perusahaan') }}
      </div>
    </h2>
    <form class="ui large form">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="Username">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <div class="ui fluid large teal submit button">Login</div>
      </div>

      <div class="ui error message"></div>

    </form>
  </div>
</div>
@endsection

@push('js')
<script>
$(document)
  .ready(function() {
    $('.ui.form')
      .form({
        fields: {
          username: {
            identifier  : 'username',
            rules: [
              {
                type   : 'empty',
                prompt : 'Please enter your Username'
              }
            ]
          },
          password: {
            identifier  : 'password',
            rules: [
              {
                type   : 'empty',
                prompt : 'Please enter your password'
              },
              {
                type   : 'length[6]',
                prompt : 'Your password must be at least 6 characters'
              }
            ]
          }
        }
      })
    ;
  });
</script>
@endpush
