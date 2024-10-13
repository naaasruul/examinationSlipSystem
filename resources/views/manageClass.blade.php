@include('commons.admin_header')
<h1>Classes</h1>
<div class="mt-4" id="program-content">
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
                @foreach($classes as $class)
                    @if($class->year == $year)  <!-- Filter classes by year -->
                        <div class="d-flex flex-column card mb-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span>{{ $class->className }}</span>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal{{ $class->classCode }}">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Modal for each class -->
                        <div class="modal fade" id="classModal{{ $class->classCode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Class Name</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('edit-class', ['classCode' => $class->classCode]) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="text" class="form-control" name="className" value="{{ $class->className }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endfor
    </div>
</div>

@include('commons.footer')
