@include('commons.teacher_header')
@include('commons.user_header')
{{$class}}
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Class</a>
  </li>
</ul>

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
                    <a href="{{ route('studentOfClass', ['classid' => $class->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endfor
</div>


@include('commons.footer')