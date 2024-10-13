@include('commons.teacher_header')

<h1>My Classes</h1>
<div class="row mt-5 g-4">
<div class="col-3 row">
    <div class="col-12 border-end d-flex flex-column h-0 align-items-center">
        @foreach($myClasses as $className => $classes)
            <button class="btn w-100 d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$className}}" aria-expanded="false" aria-controls="collapse{{$className}}">
                <h5>{{ $className }}</h5> <i class="fa-solid fa-chevron-down"></i>
            </button>

            <div class="collapse w-100" id="collapse{{$className}}">
                <!-- Show years for the class -->
                @foreach($classes->sortBy('year') as $class) <!-- Sort classes by year -->
                    <button class="btn w-100 d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseYear{{$class->year}}{{$class->classCode}}" aria-expanded="false" aria-controls="collapseYear{{$class->year}}{{$class->classCode}}">
                        <span>Year {{ $class->year }}</span> <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <div class="collapse w-100" id="collapseYear{{$class->year}}{{$class->classCode}}">
                        <!-- list of student -->
                        <ul class="list-group">
                            @foreach($students as $student)
                                @if($student->classCode == $class->id && $class->year == $student->year && $student->role == 1)
                                    <a class="list-group-item list-group-item-action studentLink" id="{{$student->ic}}">
                                        <img src="https://t3.ftcdn.net/jpg/05/79/55/26/360_F_579552668_sZD51Sjmi89GhGqyF27pZcrqyi7cEYBH.jpg" style="width: 30px; height:30px;" class="img-fluid" alt="...">
                                        {{$student->name}}
                                    </a>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>


    <div class="col-9 m-0">
        <div class="d-flex justify-content-between">
            <h3>Grade book</h3>
            <span class="d-flex gap-2 align-items-center justify-content-center">
                <img id="studentPhoto" src="https://t3.ftcdn.net/jpg/05/79/55/26/360_F_579552668_sZD51Sjmi89GhGqyF27pZcrqyi7cEYBH.jpg" style="width: 30px; height:30px;" class="img-fluid" alt="...">
                <p id="studentName" class="m-0">name</p>
            </span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Exam 1</th>
                    <th scope="col">Exam 2</th>
                    <th scope="col">Exam 3</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <p id="exam1"></p>
            <tbody>
                @foreach($subjects as $subject)
                <form action="{{route('submit-mark',['subjectCode'=>$subject->subjectCode])}}" method="post">

                    @csrf
                    <tr>
                        <th>{{$subject->subjectName}}</th>
                        <input type="hidden" class="studentIc" name="studentIc">
                        <td><input name="{{$subject->subjectCode}}_exam1" id="{{$subject->subjectCode}}_exam1" value="" type="text" class="form-control"></td>
                        <td><input name="{{$subject->subjectCode}}_exam2" id="{{$subject->subjectCode}}_exam2" value="" type="text" class="form-control"></td>
                        <td><input name="{{$subject->subjectCode}}_exam3" id="{{$subject->subjectCode}}_exam3" value="" type="text" class="form-control"></td>
                        <td><button type="submit" class="btn btn-primary">Submit</td>
                    </tr>
                </form>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
<script>
    $(function() {
        $('.studentLink').on('click', function() {
            var studentId = this.id;
            $.ajax({
                type: "get",
                url: `/marks/${studentId}`,
                success: function(response) {
                    $("#studentName").text(response.name);
                    $(".studentIc").attr('value', response.ic);
                    // Loop through the marks in the response and populate the form
                    response.marks.forEach(function(mark) {
                        $(`#${mark.subjectCode}_exam1`).val(mark.exam1);
                        $(`#${mark.subjectCode}_exam2`).val(mark.exam2);
                        $(`#${mark.subjectCode}_exam3`).val(mark.exam3);
                    });
                }
            });
        })
        // $(".studentLink").on('click', function() {
        //     var studentId = this.id; // Get the student ID from the clicked element
        //     $.ajax({
        //         type: "get",
        //         url: `/marks/${studentId}`,
        //         success: function(response) {
        //             console.log(response)
        //             // Update the student's name in the grade book header
        //             $("#studentName").text(response.name);
        //             $("#studentIc").attr('value',response.ic);
        //             response.marks.forEach(function(mark) {
        //                 $(`#${mark.subjectCode}_exam1`).attr('value',mark.exam1)
        //                 $(`#${mark.subjectCode}_exam2`).attr('value',mark.exam2)
        //                 $(`#${mark.subjectCode}_exam3`).attr('value',mark.exam3)
        //             });
        //         }
        //     });
        // });
    });
</script>
@include('commons.footer')