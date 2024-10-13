@include('commons.teacher_header')
<h1>Teacher Profile</h1>
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <img class="profilePicture my-3 " src="https://www.spongebobshop.com/cdn/shop/products/SB-Standees-Spong-3_1200x.jpg?v=1603744568" alt="">
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