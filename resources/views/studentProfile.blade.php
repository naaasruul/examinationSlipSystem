@include('commons.student_header')
<h1>Student Profile</h1>
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
                    <img class="profilePicture my-3 " src="{{$user->profilePicture ? asset('assets/profile_pictures/' . $user->profilePicture) : 'https://via.placeholder.com/150'}}" alt="Profile Picture">

                    <label for="profilePicture" class="btn btn-primary profilePictureBtn rounded-circle"><i class="bi bi-camera"></i></label>
                    <input type="file" name="profilePicture" id="profilePicture" class="d-none" onchange="document.getElementById('profilePictureForm').submit();">
                </form>
            </div>
        </div>
    </div>
    <form class="row" action="{{route('edit-admin-profile',['adminId'=>$user->ic])}}" method="post">
        @csrf
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text"  name="profileName" value="{{$user->name}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">ID </label>
                <input type="text" aria-label="Disabled input example" disabled value="{{$user->ic}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">Class</label>
                <input type="text" aria-label="Disabled input example" disabled value="{{ $class->className}}" class="form-control" id="">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text"  name="profilePhoneNumber" value="{{$user->phone_number}}" class="form-control" id="">
            </div>
        </div>

        <div class="col-6">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                <textarea class="form-control" name="profileAddress" id="exampleFormControlTextarea1" rows="3">{{$user->address}}</textarea>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center mt-3">
            <button  type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

</div>
@include('commons.footer')