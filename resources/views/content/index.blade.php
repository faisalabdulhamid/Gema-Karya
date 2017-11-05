@extends('layouts.sub_template')
@section('title', 'Title Template')

@section('sub_content')
  <div class="ui container" style="min-height:100vh;">

    <h4 class="ui horizontal divider header">
      <i class="tag icon"></i>
      Description
    </h4>
    <p>Doggie treats are good for all times of the year. Proven to be eaten by 99.9% of all dogs worldwide.</p>
    <p><button class="ui primary button" id="btn-modal">Modal</button></p>
    <h4 class="ui horizontal divider header">
      <i class="bar chart icon"></i>
      Specifications
    </h4>
    <table class="ui definition table">
      <tbody>
        <tr>
          <td class="two wide column">Size</td>
          <td>1" x 2"</td>
        </tr>
        <tr>
          <td>Weight</td>
          <td>6 ounces</td>
        </tr>
        <tr>
          <td>Color</td>
          <td>Yellowish</td>
        </tr>
        <tr>
          <td>Odor</td>
          <td>Not Much Usually</td>
        </tr>
      </tbody>
    </table>

  </div>
@endsection
