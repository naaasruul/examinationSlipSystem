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

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/d46a78d0a5.js" crossorigin="anonymous"></script>

  <!-- jQuery -->
  <script src="{{asset('js/jquery.min.js')}}"></script>

  <!-- Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

  <!-- Charts.css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">

  <style>
    @media print{
      /* Hide non-essential elements for printing (e.g., buttons) */
    .btn,
    .d-flex,
    footer,
    form,
    nav,
    .formResult {
      display: none;
    }
    }
  </style>
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand " href="{{route('adminMain')}}"><img class="logoSrai me-2" src="{{asset('images/logoSrai.png')}}" alt=""><span class="align-middle">Srai 19</span></a>
    <div class="collapse navbar-collapse d-flex justify-content-between " id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto mb-2 mb-lg-0 ">
        <a class="nav-link active" href="{{route('adminMain')}}">Home</a>
        <a class="nav-link" href="{{route('adminReport')}}">Report</a>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('manageStudent')}}">Student</a></li>
            <li><a class="dropdown-item" href="{{route('manageTeacher')}}">Teacher</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{route('manageClass')}}">Class</a></li>
          </ul>
        </li>


      </div>
      <div class="d-flex gap-3 me-4">
        <a href="{{route('admin-profile')}}" class="nav-link">
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