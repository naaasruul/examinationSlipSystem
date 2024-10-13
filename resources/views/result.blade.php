<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examination Results</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <!-- Add this CSS for print media -->
    <style>
        @media print {
            /* Ensure the body background is white */
            body {
                background-color: white;
                display: flex;
                flex-direction: column;
                width: 100%;
                align-items: center;
            }
            .container{
                margin: 0;
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            /* Hide non-essential elements for printing (e.g., buttons) */
            .btn, .d-flex ,footer{
                display: none;
            }
        }
    </style>
    
    <body class="bg-light">
        <div class="container mt-5">
            <div class="d-flex container  flex-column align-items-center" style="width: 70%;">
                <img class="" style="width: 60px; height:60px" src="{{asset('images/logoSrai.png')}}" alt="">
                <p class="fs-6 m-0"><b>Sekolah Rendah Agama Intergrasi Seksyen 19</b></p>
                <p>EXAMINATION RESULT FOR EXAM {{$examType}}</p>
                
                <div class="card mx-5 mb-3 w-100" >
                    <div class="card-body ">
                        <div style="background-color: white;" class="row ">
                        <div class="col-6">
                            <p><b>IC: </b>{{$user->ic}}</p>
                        </div>
                        <div class="col-6">
                            <p><b>YEAR: </b><span class="text-uppercase">{{$user->year}}</span></p>
                        </div>
                        <div class="col-6">
                            <p><b>NAME: </b><span class="text-uppercase">{{$user->name}}</span></p>
                        </div>
                        <div class="col-6">
                            <p><b>CLASS: </b><span class="text-uppercase">{{$user->year}} {{$class->className}} </span></p>
                        </div>

                    </div>
                </div>
            </div>

            <table class="table border">
                <thead>
                    <tr class="table-info">
                        <th scope="col">CODE</th>
                        <th scope="col">SUBJECT</th>
                        <th scope="col">MARKS</th>
                        <th scope="col">GRADE</th>
                        <th scope="col">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <!-- Display the subject code -->
                        <td>{{ $result->subjectCode }}</td>

                        <!-- Assuming the subject name is also subjectCode (you can replace this if you have a subject name field) -->
                        <td>{{ $result->subjectName }}</td>

                        <!-- Dynamically fetch the exam type using the exam number passed from the controller -->
                        <td>
                            @php
                            // Dynamically select the exam based on the $examType
                            $marks = $result->{'exam' . $examType};
                            @endphp
                            {{ $marks }}
                        </td>

                        <!-- Calculate the grade based on marks -->
                        <td>
                            @php
                            // Example grading system
                            if ($marks >= 90) {
                            $grade = 'A+';
                            } elseif ($marks >= 80) {
                            $grade = 'A';
                            } elseif ($marks >= 70) {
                            $grade = 'B+';
                            } elseif ($marks >= 60) {
                            $grade = 'B';
                            } elseif ($marks >= 50) {
                            $grade = 'C';
                            } else {
                            $grade = 'F';
                            }
                            @endphp
                            {{ $grade }}
                        </td>

                        <!-- Determine the status (e.g., Pass/Fail) -->
                        <td>
                            @if($marks >= 50)
                            Pass
                            @else
                            Fail
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="card mx-5 mb-3 w-100">
                <div class="card-body">
                    <div class="row">
                        <!-- Total Subjects -->
                        <div class="col-6 mb-2">
                            <p><b>Total Subjects: </b>{{ $totalSubjects }}</p>
                        </div>

                        <!-- Total Marks -->
                        <div class="col-6 mb-2">
                            <p><b>Total Marks: </b>{{ $totalMarks }} / {{ $totalSubjects * 100 }}</p>
                        </div>

                        <!-- Percentage -->
                        <div class="col-6 mb-2">
                            <p><b>Percentage: </b>{{ number_format($percentage, 2) }}%</p>
                        </div>

                        <!-- Subjects Passed -->
                        <div class="col-6 mb-2">
                            <p><b>Subjects Passed: </b>{{ $passedSubjects }} / {{ $totalSubjects }}</p>
                        </div>

                        <!-- Status -->
                        <div class="col-12 mb-2">
                            <p><b>Status: </b>
                                @if($passedSubjects == $totalSubjects)
                                <span class="text-success">Passed All</span>
                                @elseif($passedSubjects >= ($totalSubjects / 2))
                                <span class="text-warning">Partial Pass</span>
                                @else
                                <span class="text-danger">Failed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 flex-row">
                <a href="{{route('studentMain')}}" class="btn btn-primary">Back</a>
                <button onclick="window.print()" class="btn btn-primary">Print</button>
            </div>
        </div>


@include('commons.footer')