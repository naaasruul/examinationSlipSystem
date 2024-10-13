@include('commons.admin_header')

<div class="container">
    <div class="row">
        @if($students->isEmpty())
            <div class="col-12">
                <h1>No student</h1>
            </div>
        @else
            @foreach($students as $student)
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $student->name }}</h5>

                        {{-- Check if the address is null --}}
                        <p class="card-text">
                        {{$student->studentClass->year}} {{$student->studentClass->className}}
                        </p>

                        <p class="card-text">
                            {{ $student->address ?? 'No address' }} <br>
                            {{ $student->phone_number ?? 'No phone number'}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
@include('commons.footer')