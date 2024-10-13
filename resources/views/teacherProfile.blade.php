@include('commons.teacher_header')
<h1>Teacher Profile</h1>
<div class="container">
@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-12 d-flex justify-content-center ">
            <div class="position-relative">
                <form action="{{route('editProfilePicture')}}" method="post" enctype="multipart/form-data" id="profilePictureForm">
                    @csrf
                    <img class="profilePicture my-3 " src="{{$user->profilePicture ? asset('assets/profile_pictures/' . $user->profilePicture) : 'https://www.spongebobshop.com/cdn/shop/products/SB-Standees-Spong-3_1200x.jpg?v=1603744568'}}" alt="Profile Picture">

                    <label for="profilePicture" class="btn btn-primary profilePictureBtn rounded-circle"><i class="bi bi-camera"></i></label>
                    <input type="file" name="profilePicture" id="profilePicture" class="d-none" onchange="document.getElementById('profilePictureForm').submit();">
                </form>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" value="{{$user->name}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">ID </label>
                <input type="text" aria-label="Disabled input example" disabled value="{{$user->ic}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-1">
            <div class="mb-3">
                <label class="form-label">Year</label>
                <input type="text" aria-label="Disabled input example" disabled value="{{ $class->year}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-5">
            <div class="mb-3">
                <label class="form-label">Teacher class</label>
                <input type="text" aria-label="Disabled input example" disabled value="{{ $class->className}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" value="{{$user->phone_number}}" class="form-control" id="">
            </div>
        </div>

        <div class="col-6">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center mt-3">
            <button class="btn btn-primary">Submit</button>
        </div>



    </div>
</div>
@include('commons.footer')