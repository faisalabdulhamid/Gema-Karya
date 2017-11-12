<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>@yield('title')</title>
  <link rel="stylesheet" type="text/css" href="{{url('dist/semantic.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="stylesheet" type="text/css" href="{{url('dist/components/reset.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/site.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{url('dist/components/container.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/grid.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/header.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/image.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/menu.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{url('dist/components/divider.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/segment.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/form.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/input.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/button.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/list.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/message.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/icon.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/dropdown.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('dist/components/icon.min.css')}}">

  <link rel="stylesheet" href="dist/components/accordion.css">
  <link rel="stylesheet" href="dist/components/ad.css">
  <link rel="stylesheet" href="dist/components/breadcrumb.css">
  <link rel="stylesheet" href="dist/components/card.css">
  <link rel="stylesheet" href="dist/components/checkbox.css">
  <link rel="stylesheet" href="dist/components/comment.css">
  <link rel="stylesheet" href="dist/components/dimmer.css">
  <link rel="stylesheet" href="dist/components/embed.css">
  <link rel="stylesheet" href="dist/components/feed.css">
  <link rel="stylesheet" href="dist/components/flag.css">
  <link rel="stylesheet" href="dist/components/item.css">
  <link rel="stylesheet" href="dist/components/label.css">
  <link rel="stylesheet" href="dist/components/loader.css">
  <link rel="stylesheet" href="dist/components/modal.css">
  <link rel="stylesheet" href="dist/components/nag.css">
  <link rel="stylesheet" href="dist/components/popup.css">
  <link rel="stylesheet" href="dist/components/progress.css">
  <link rel="stylesheet" href="dist/components/rail.css">
  <link rel="stylesheet" href="dist/components/rating.css">
  <link rel="stylesheet" href="dist/components/reveal.css">
  <link rel="stylesheet" href="dist/components/search.css">
  <link rel="stylesheet" href="dist/components/shape.css">
  <link rel="stylesheet" href="dist/components/statistic.css">
  <link rel="stylesheet" href="dist/components/step.css">
  <link rel="stylesheet" href="dist/components/sticky.css">
  <link rel="stylesheet" href="dist/components/tab.css">
  <link rel="stylesheet" href="dist/components/table.css">
  <link rel="stylesheet" href="dist/components/transition.css"> -->
  @stack('css')

  <style type="text/css">
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>

</head>
<body>

  @yield('content')


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="{{url('dist/semantic.js')}}"></script>
  <!-- <script src="{{url('dist/components/sidebar.js')}}"></script>
  <script src="{{url('dist/components/form.js')}}"></script>
  <script src="{{url('dist/components/transition.js')}}"></script>

  <script src="{{url('dist/components/accordion.js')}}"></script>
  <script src="{{url('dist/components/api.js')}}"></script>
  <script src="{{url('dist/components/checkbox.js')}}"></script>
  <script src="{{url('dist/components/dimmer.js')}}"></script>
  <script src="{{url('dist/components/dropdown.js')}}"></script>
  <script src="{{url('dist/components/embed.js')}}"></script>
  <script src="{{url('dist/components/modal.js')}}"></script>
  <script src="{{url('dist/components/nag.js')}}"></script>
  <script src="{{url('dist/components/popup.js')}}"></script>
  <script src="{{url('dist/components/progress.js')}}"></script>
  <script src="{{url('dist/components/rating.js')}}"></script>
  <script src="{{url('dist/components/search.js')}}"></script>
  <script src="{{url('dist/components/site.js')}}"></script>
  <script src="{{url('dist/components/state.js')}}"></script>
  <script src="{{url('dist/components/sticky.js')}}"></script>
  <script src="{{url('dist/components/tab.js')}}"></script>
  <script src="{{url('dist/components/visibility.js')}}"></script> -->
  @stack('js')

</body>
</html>
