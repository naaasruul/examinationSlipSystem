@include('commons.teacher_header')
<h1>{{$subject->subjectName}} ({{$year}} {{$className->className}})</h1>

<div class="mt-4">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Student ID</th>
            <th scope="col">Name</th>
            <th scope="col">Year</th>
            <th scope="col">Class</th>
            <th scope="col">Mark</th>
            </tr>
        </thead>
        <tbody>
            <!-- {{$students}} -->
        @foreach($students as $student)
            <tr>
            <td>{{ $student->ic }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->year }}</td>
                <td>{{ $student->studentClass->className   }}</td>
                <td>
                    <input type="number" class="form-control" name="marks[{{ $student->studentId }}]" placeholder="Enter mark">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@include('commons.footer')