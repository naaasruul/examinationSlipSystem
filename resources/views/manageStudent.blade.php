@include('commons.admin_header')
<div class="row">
    <div class="col-4 border-end ">
        <ul class="list-group list-group ">
            <li class="list-group-item bg-primary text-light">Student Name</li>
            <!-- <li class="list-group-item text-light">
                <div class="d-flex gap-1">
                    <input type="text" name="studentName" class="form-control" placeholder="Search student..">
                    <button class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </li> -->
            @foreach($students as $student)
            <a href="{{route('edit-student',['studentIc'=>$student->ic])}}" class="list-group-item list-group-item-action" id="{{$student->ic}}" aria-current="true">
                {{$student->name}}
            </a>
            @endforeach
            <button type="button" data-bs-toggle="modal" data-bs-target="#addNewStudent" class="list-group-item bg-info text-light list-group-item-action" aria-current="true"><i class="fa-solid fa-plus"></i> Add Student</button>

        </ul>
    </div>
    <div class="col-8">
        @if($selectedStudent)
        <div class="row mx-4">
            <div class="col-3 d-flex flex-column align-items-center">
                <img style="width: 100px; height: 100px; border-radius: 100%; object-fit: cover;"
                    src="{{ $selectedStudent->profilePicture ? asset('assets/profile_pictures/' . $selectedStudent->profilePicture) : 'https://via.placeholder.com/100' }}"
                    alt="{{ $selectedStudent->name }}'s Profile Picture">

                <p>{{ $selectedStudent->name }}</p>
            </div>
            <div class="col-9 row g-3">
                <form action="{{route('update-student',['studentIc'=>$selectedStudent->ic])}}" method="post">
                    @csrf
                    <!-- Name -->
                    <div class="col-12">
                        <label for="studentName">Name</label>
                        <input type="text" name="editStudentName" value="{{$selectedStudent->name}}" class="form-control">
                    </div>

                    <!-- Year -->
                    <div class="col-3">
                        <label for="studentName">Year</label>
                        <select id="inputState" name="editStudentYear" class="form-select">
                            <option value="1" {{ $selectedStudent->year == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $selectedStudent->year == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $selectedStudent->year == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $selectedStudent->year == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $selectedStudent->year == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $selectedStudent->year == 6 ? 'selected' : '' }}>6</option>
                        </select>
                    </div>
                    {{$selectedClass->id}}
                    {{$selectedStudent->classCode}}
                    <!-- Class -->
                    <div class="col-9">
                        <label for="studentName">Class</label>
                        <select id="inputState" name="editStudentClass" class="form-select">
                            <option value="tbt" {{ $selectedClass->classCode ==  "tbt"  ? 'selected' : '' }}>Taubat</option>
                            <option value="mhb" {{ $selectedClass->classCode ==  "mhb"  ? 'selected' : '' }}>Mahabbah</option>
                            <option value="zhd" {{ $selectedClass->classCode ==  "zhd"  ? 'selected' : '' }}>Zuhud</option>
                            <option value="ikh" {{ $selectedClass->classCode ==  "ikh"  ? 'selected' : '' }}>Ikhlas</option>
                            <option value="twkl" {{ $selectedClass->classCode == "twkl"  ? 'selected' : '' }}>Tawakkal</option>
                            <option value="sbr" {{ $selectedClass->classCode ==  "sbr"  ? 'selected' : '' }}>Sabar</option>
                        </select>
                    </div>

                    <!-- IC NO -->
                    <div class="col-12">
                        <label for="studentName">IC Number</label>
                        <input type="text" disabled value="{{$selectedStudent->ic}}" class="form-control">
                        <input type="hidden" name="editStudentIc" value="{{$selectedStudent->ic}}" class="form-control">
                    </div>

                    <!-- Phone -->
                    <div class="col-12">
                        <label for="studentName">Phone Number</label>
                        <input type="text" name="editStudentPhoneNumber" value="{{$selectedStudent->phone_number}}" class="form-control">
                    </div>

                    <!-- Address -->
                    <div class="col-12">
                        <label for="studentName">Address</label>
                        <div class="form-floating">
                            <textarea class="form-control" name="editStudentAddress" value='{{$selectedStudent->address}}' id="floatingTextarea">{{$selectedStudent->address}}</textarea>
                        </div>
                    </div>

                    <div class="col-12 mt-3  ">
                        <button type="submit" class="btn w-100 btn-primary">Submit</button>
                    </div>
                </form>
                <form class="col-12 " action="{{ route('deleteStudent', $student->ic) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn w-100 btn-danger">Delete</button>
                </form>
            </div>

        </div>
        @else
        <div class="row mx-4">
            <div class="col-3 d-flex flex-column align-items-center">
                <img style="width: 100px; height:100px; border-radius:100%; object-fit:cover; " src="https://static.wikia.nocookie.net/cartoons/images/e/ed/Profile_-_SpongeBob_SquarePants.png/revision/latest?cb=20240420115914" alt="">
                <p>Student</p>
            </div>

            <div class="col-9 row g-3">
                <!-- Name -->
                <div class="col-12">
                    <label for="studentName">Name</label>
                    <input type="text" class="form-control">
                </div>

                <!-- Year -->
                <div class="col-3">
                    <label for="studentName">Year</label>
                    <select id="inputState" class="form-select">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                    </select>
                </div>

                <!-- Class -->
                <div class="col-9">
                    <label for="studentName">Class</label>
                    <select id="inputState" class="form-select">
                        <option>Taubat</option>
                        <option>Mahabbah</option>
                        <option>Zuhud</option>
                        <option>Ikhlas</option>
                        <option>Tawakkal</option>
                        <option>Sabar</option>
                    </select>
                </div>

                <!-- IC NO -->
                <div class="col-12">
                    <label for="studentName">IC Number</label>
                    <input type="text" class="form-control">
                </div>


                <!-- Phone -->
                <div class="col-12">
                    <label for="studentName">Phone Number</label>
                    <input type="text" class="form-control">
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label for="studentName">Address</label>
                    <div class="form-floating">
                        <textarea class="form-control" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea"></label>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-end ">
                    <button class="btn btn-primary">Submit</button>
                </div>


            </div>
        </div>
        @endif

    </div>
</div>

<div class="modal fade" id="addNewStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add new teacher</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <form action="{{route('add-student')}}" method="post">
                        @csrf
                        <!-- Name -->
                        <div class="col-12">
                            <label for="studentName">Name</label>
                            <input type="text" name="newStudentName" id="newStudentName" class="form-control">
                        </div>

                        <!-- Year -->
                        <div class="col-3">
                            <label for="newStudentYear">Year</label>
                            <select name="newStudentYear" id="newStudentYear" class="form-select">
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
                            <label for="studentName">Class</label>
                            <select id="newStudentClass" name="newStudentClass" class="form-select">
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
                            <label for="studentName">IC Number</label>
                            <input type="text" name="newStudentIc" id="newStudentIc" value="" class="form-control">
                        </div>

                        <!-- Password -->
                        <div class="col-6">
                            <label for="studentName">Password</label>
                            <input type="text" name="newStudentPassword" id="newStudentPassword" class="form-control">
                        </div>

                        <!-- Phone -->
                        <div class="col-12">
                            <label for="studentName">Phone Number</label>
                            <input type="text" name="newStudentPhoneNumber" id="newStudentPhoneNumber" class="form-control">
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="studentName">Address</label>
                            <div class="form-floating">
                                <textarea class="form-control" id="newStudentAddress" name="newStudentAddress"></textarea>
                                <label for="floatingTextarea"></label>
                            </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Student</button>
            </div>
            </form>
        </div>
    </div>
</div>

@include('commons.footer')