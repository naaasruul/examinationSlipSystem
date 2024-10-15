@include('commons.admin_header')
@include('commons.user_header')
<ul class="nav nav-tabs">
    <li class="nav-item ">
        <a class="nav-link active program" id="" href="">Class</a>
    </li>
    <li class="nav-item">
        <a class="nav-link program" id="teacher" href="#">Teacher</a>
    </li>
</ul>
<div class="mt-4" id="program-content">
    @if($program == '')
    <div class="d-flex flex-column justify-content-between">
        @for ($year = 1; $year <= 6; $year++)
            <div class="d-flex card flex-row p-4 mb-2 mt-4">
                <h2>Year {{ $year }}</h2>
                <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseYear{{ $year }}" aria-expanded="false" aria-controls="collapseYear{{ $year }}">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>    
            </div>

    <!-- Collapsible section for each year -->
    <div class="collapse p-2" id="collapseYear{{ $year }}">
    @foreach($classes->where('year', $year) as $class) <!-- Filter classes by year -->
            <div class="d-flex flex-column card mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span>{{ $class->className }}</span>
                    <a href="{{ route('showStudentOfClass-admin', ['classid' => $class->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
    </div>
    @endfor
</div>




@elseif($program == 'teacher')



<h1>List of teacher</h1>
<table class="mt-3 table table-striped">
    <thead>
        <tr>
            <th scope="col">IC</th>
            <th scope="col">Name</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)

        <tr>
            <th scope="row">{{$teacher->ic}}</th>
            <td>{{$teacher->name}}</td>
            <td>{{$teacher->phone_number}}</td>
            <td>{{$teacher->email}}</td>
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
                url: `/adminMain/${programId}`,
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