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
  <script src="https://kit.fontawesome.com/d46a78d0a5.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand " href="{{route('teacherMain')}}"><img class="logoSrai me-2" src="{{asset('images/logoSrai.png')}}" alt=""><span class="align-middle">Srai 19</span></a>
    <div class="collapse navbar-collapse d-flex justify-content-between " id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto mb-2 mb-lg-0 ">
        <a class="nav-link active" href="{{route('teacherMain')}}">Home</a>
        <a class="nav-link" href="{{route('teacher-marks')}}">Marks</a>
      </div>
      <div class="d-flex gap-3 me-4">
        <a href="{{route('teacher-profile')}}" class="nav-link">
          <i class="fa-regular  fa-user fa-lg"></i>
        </a>
        <span class="vr"></span>
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