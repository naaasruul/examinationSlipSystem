<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Examination Slip</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/d46a78d0a5.js" crossorigin="anonymous"></script>
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand " href="{{route('studentMain')}}"><img class="logoSrai me-2" src="{{asset('images/logoSrai.png')}}" alt=""><span class="align-middle">Srai 19</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-between " id="navbarNavAltMarkup">
      <div class="navbar-nav ">
        <a class="nav-link active" aria-current="page" href="{{route('studentMain')}}">Home</a>
        <a class="nav-link" href="{{route('studentResult')}}">Result</a>
        <a class="nav-link" href="#">Analysis</a>
      </div>
      <div class="d-flex gap-3 me-4">
        <a href="{{route('studentProfile')}}" class="nav-link">
          <i class="fa-regular  fa-user fa-lg"></i> 
        </a> <span class="vr"></span>
        <form action="{{route('logout')}}" method="post">
          @csrf
          <button type="submit" class="nav-link align-bottom"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        </form>
      </div>
    </div>
  </div>
</nav>

<body>
  <div class="container mt-5">
    