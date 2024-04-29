<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="icon" type="image/png" sizes="16x16" href="storage/images/{{config('app.icon')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>
    {{$param->entreprise->nom}}</title>

    <style>
      ol > li{
        font-size: 25px;
        font-weight: bold;
        font-family: constanian;
      }
    </style>

  @livewireStyles
</head>

<body>

            {{ $slot }} 
             @yield('js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Page Specific JS File -->
  @livewireScripts
</body>
</html>
