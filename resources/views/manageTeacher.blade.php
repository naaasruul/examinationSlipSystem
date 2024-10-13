@include('commons.admin_header')
<div class="row">
    <div class="col-4 border-end ">
        <ul class="list-group list-group ">
            <li class="list-group-item bg-primary text-light">Teacher Name</li>
            <li class="list-group-item text-light">
                <div class="d-flex gap-1">
                    <input type="text" name="teacherName" class="form-control" placeholder="Search teacher..">
                    <button class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </li>
            @foreach($teachers as $teacher)
            <a href="{{route('edit-teacher',['teacheric'=>$teacher->ic])}}" type="button" class="list-group-item list-group-item-action" id="{{$teacher->ic}}" aria-current="true">
                {{$teacher->name}}
            </a>
            @endforeach
            <button type="button" data-bs-toggle="modal" data-bs-target="#addNewTeacher" class="list-group-item bg-info text-light list-group-item-action" aria-current="true"><i class="fa-solid fa-plus"></i> Add teacher</button>

        </ul>
    </div>
    <div class="col-8">
        @if($selectedTeacher)
        <div class="row mx-4">
            <div class="col-3 d-flex flex-column align-items-center">
                <img style="width: 100px; height:100px; border-radius:100%; object-fit:cover; " src="{{asset('images/defaultprofile.jpg')}}" alt="">
                <p>Teacher</p>
            </div>
            <div class="col-9 row g-3">
                <form action="{{route('update-teacher',['teacheric'=>$selectedTeacher->ic])}}" method="post">
                    @csrf
                    <!-- Name -->
                    <div class="col-12 mb-3">
                        <label for="teacherName">Name</label>
                        <input type="text" value="{{$selectedTeacher->name}}" name="editStudentName" class="form-control">
                    </div>

                    <!-- year -->
                    <div class="col-3 mb-3">
                        <label for="teacherName">Year</label>
                        <select name="editStudentYear" class="form-select">
                            <option {{$selectedTeacher->year == 1 ? 'selected' : ''}} value="1" selected>1</option>
                            <option {{$selectedTeacher->year == 2 ? 'selected' : ''}} value="2">2</option>
                            <option {{$selectedTeacher->year == 3 ? 'selected' : ''}} value="3">3</option>
                            <option {{$selectedTeacher->year == 4 ? 'selected' : ''}} value="4">4</option>
                            <option {{$selectedTeacher->year == 5 ? 'selected' : ''}} value="5">5</option>
                            <option {{$selectedTeacher->year == 6 ? 'selected' : ''}} value="6">6</option>
                        </select>
                    </div>
                    <!-- Class -->
                    <div class="col-9 mb-3">
                        <label for="teacherName">Class</label>
                        <select name="editStudentClass" id="inputState" class="form-select">
                            <option value="tbt" {{ $selectedClass->classCode ==  "tbt"  ? 'selected' : '' }}>Taubat</option>
                            <option value="mhb" {{ $selectedClass->classCode ==  "mhb"  ? 'selected' : '' }}>Mahabbah</option>
                            <option value="zhd" {{ $selectedClass->classCode ==  "zhd"  ? 'selected' : '' }}>Zuhud</option>
                            <option value="ikh" {{ $selectedClass->classCode ==  "ikh"  ? 'selected' : '' }}>Ikhlas</option>
                            <option value="twkl" {{ $selectedClass->classCode == "twkl"  ? 'selected' : '' }}>Tawakkal</option>
                            <option value="sbr" {{ $selectedClass->classCode ==  "sbr"  ? 'selected' : '' }}>Sabar</option>
                        </select>
                    </div>

                    <!-- IC NO -->
                    <div class="col-12 mb-3">
                        <label for="teacherName">IC Number</label>
                        <input type="text" disabled value="{{$selectedTeacher->ic}}" class="form-control">
                        <input type="hidden" name="editStudentIc" value="{{$selectedTeacher->ic}}" class="form-control">
                    </div>

                    <div class="col-12 mb-3">
                        <div class="dropdown w-100">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Subject
                            </button>
                            <!-- {{$selectedTeacher}} -->
                            <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                                @foreach($subjects as $subject)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" name="editTeacherSubjects[]"  type="checkbox" value="{{$subject->subjectCode}}" id="flexCheckDefault"
                                        {{ $selectedTeacher->subjects->contains('subjectCode', $subject->subjectCode) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$subject->subjectName}}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-12 mb-3">
                        <label for="teacherName">Phone Number</label>
                        <input type="text" name="editStudentPhoneNumber" value="{{$selectedTeacher->phone_number}}" class="form-control">
                    </div>

                    <!-- Address -->
                    <div class="col-12 mb-3">
                        <label for="teacherName">Address</label>
                        <div class="form-floating">
                            <textarea name="editStudentAddress" value='{{$selectedTeacher->address}}' class="form-control" placeholder="Leave a comment here" id="floatingTextarea">
                            {{$selectedTeacher->address}}
                            </textarea>
                            <label for="floatingTextarea"></label>
                        </div>
                    </div>

                    <div class="col-12 mb-3 d-flex justify-content-end ">
                        <button class="btn btn-primary">Submit</button>
                    </div>


            </div>
            </form>
        </div>
        @else
        no data
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addNewTeacher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add new teacher</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('add-teacher')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-12">
                            <label for="teacherName">Name</label>
                            <input type="text" name="newTeacherName" value="" class="form-control">
                        </div>

                        <!-- year -->
                        <div class="col-3">
                            <label for="teacherName">Year</label>
                            <select name="newYear" class="form-select">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <!-- Class -->
                        <div class="col-9">
                            <label for="teacherName">Class</label>
                            <select name="newTeacherClass" id="inputState" class="form-select">
                                <option value="tbt" selected>Taubat</option>
                                <option value="mhb">Mahabbah</option>
                                <option value="zhd">Zuhud</option>
                                <option value="ikh">Ikhlas</option>
                                <option value="twkl">Tawakkal</option>
                                <option value="sbr">Sabar</option>
                            </select>
                        </div>


                        <!-- IC NO -->
                        <div class="col-6">
                            <label for="">IC Number</label>
                            <input type="text" name="newTeacherIc" value="" class="form-control">
                        </div>

                        <!-- Password -->
                        <div class="col-6">
                            <label for="teacherName">Password</label>
                            <input type="text" name="newTeacherPassword" value="" class="form-control">
                        </div>

                        <div class="col-12">
                            <div class="dropdown w-100">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Subject
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                                    @foreach($subjects as $subject)
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="newTeacherSubjects[]" value="{{$subject->subjectCode}}" id="subject{{$subject->subjectCode}}">
                                            <label class="form-check-label" for="subject{{$subject->subjectCode}}">
                                                {{$subject->subjectName}}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        <!-- Phone -->
                        <div class="col-12">
                            <label for="teacherName">Phone Number</label>
                            <input type="text" value="" name="newTeacherPhone" class="form-control">
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="teacherName">Address</label>
                            <div class="form-floating">
                                <textarea class="form-control" name="newTeacherAddress" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                                <label for="floatingTextarea"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add teacher</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('commons.footer')