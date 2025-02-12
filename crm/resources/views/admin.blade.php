<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin</title>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

    </head>
    <body>
        <div id="root"></div>
        <script type="text/javascript">
         const domain= "/crm/";
         
           const apiDomain= 'https://myholidayhappiness.com/crm';
           const hrefDomain= "{{URL::to('/')}}";;
       // const domain= window.location.origin;
       // const domain= "{{URL::to('/')}}";
       // const publicDir= '/public';
         const publicDir= "{{URL::to('/public')}}";
        console.log(domain);
        console.log(publicDir);
        </script>
        <script src="{{ asset('js/admin.js') }}?version=16"></script>
    </body>
</html>
