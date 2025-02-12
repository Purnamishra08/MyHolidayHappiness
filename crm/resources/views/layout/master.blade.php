<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <link rel="icon" type="image/png" href="{{ asset('/img/synergy-fav.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

     <title>@yield('title')</title>

    <meta name="description" content="@yield('description')">

    <meta name="keywords" content="@yield('keywords')">

    <link rel="canonical" href="{{Request::url()}}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css" rel="stylesheet">
    @yield('css')

  </head>

  <body>

    @include('layout.header')

    @yield('content')



   @include('layout.footer')

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/script.js?v=1') }}"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js" integrity="sha512-QTnb9BQkG4fBYIt9JGvYmxPpd6TBeKp6lsUrtiVQsrJ9sb33Bn9s0wMQO9qVBFbPX3xHRAsBHvXlcsrnJjExjg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire(
                'Success!',
                "{!! Session::get('success') !!}",
                'success'
              );
      </script>
      @endif
    @yield('script')


  </body>

</html>