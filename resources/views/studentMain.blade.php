@include('commons.student_header')
@include('commons.user_header')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link program active" id="class" href="#">Class</a>
    </li>
    <li class="nav-item">
        <a class="nav-link program" id="teacher" href="#">Teacher</a>
    </li>
</ul>

<div class="mt-4 animate__animated animate__backInLeft" id="program-content">
    @if($program == 'teacher')
    <!-- Teacher content -->
    <div class="row">
        @foreach($teachers as $teacher)
        <div class="col-6">
            <div class="card mb-3 animate__animated animate__backInLeft">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img style="width: 100%; height:100%; object-fit:cover;"
                            src="{{ $teacher->profilePicture ? asset('assets/profile_pictures/' . $teacher->profilePicture) : 'https://via.placeholder.com/360' }}"
                            class="img-fluid rounded-start" alt="{{ $teacher->name }}'s Profile Picture">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher->name }}</h5>
                            <p class="card-text">{{ $teacher->address ?? 'No address' }}.</p>
                            <p class="card-text"><small class="text-body-secondary">{{ $teacher->phone_number ?? 'No phone number' }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
    @elseif($program == '')
    <!-- Class content -->
    <div class="d-flex justify-content-between align-items-end animate__animated animate__backInLeft">
        <h2>{{ $user->year }} {{ $class->className }}</h2>
        <div class="d-flex flex-column">
            @foreach($teachers as $teacher)
            <div class="d-flex align-items-center mb-2">
                <img class="me-2" style="width: 40px; height: 40px; border-radius: 100%;"
                    src="{{ $teacher->profilePicture ? asset('assets/profile_pictures/' . $teacher->profilePicture) : 'https://via.placeholder.com/40' }}"
                    alt="{{ $teacher->name }}'s Profile Picture">
                <p class="mb-0"><b>{{ $teacher->name }}</b></p>
            </div>
            @endforeach
        </div>
    </div>

    <table class="table table-striped  table-bordered  animate__animated animate__backInLeft">
        <thead>
            <tr>
                <th class="table-info" scope="col"><b>Name</b></th>
                <th class="table-info" scope="col"><b>Phone Number</b></th>
                <th class="table-info" scope="col"><b>Address</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach($allStudent as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>{{$student->phone_number}}</td>
                <td>{{$student->address}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>
<script>
    $(function() {
        $('.program').on('click', function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            // Remove 'active' class from all links
            $('.nav-link').removeClass('active');

            var programId = this.id;
            console.log(programId)
            $.ajax({
                type: "GET",
                url: `/studentMain/${programId}`,
                success: function(response) {
                    // Replace the specific section, not the entire page
                    $('#program-content').html($(response).find('#program-content').html());
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });

            // Add 'active' class to the clicked link
            $(this).addClass('active');
        });
    });
</script>


@include('commons.footer')