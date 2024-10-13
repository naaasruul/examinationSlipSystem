@include('commons.student_header')

<h1>My Result</h1>

<p class="fs-4">{{$class->year}} {{$class->className}}</p>
<ul class="list-group">
  <li class="list-group-item">
    <a href="{{route('result',['studentId'=>$user->ic,'examType'=>1])}}" class="btn btn-light"><i class="bi bi-chevron-right"></i></a>
    Exam 1
  </li>
  <li class="list-group-item">
    <a class="btn btn-light"><i class="bi bi-chevron-right"></i></a>
    Exam 2
  </li>
  <li class="list-group-item">
    <a class="btn btn-light"><i class="bi bi-chevron-right"></i></a>
    Exam 3
  </li>
</ul>
