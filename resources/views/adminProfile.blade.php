@include('commons.admin_header')
<h1>Admin Profile</h1>
<div class="container">
    <form action="{{route('edit-admin-profile',['adminId'=>$user->ic])}}" method="post">
        @csrf
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <img class="profilePicture my-3 " src="https://www.spongebobshop.com/cdn/shop/products/SB-Standees-Spong-3_1200x.jpg?v=1603744568" alt="">
        </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="profileName" value="{{$user->name}}" class="form-control" id="">
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
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="profilePhoneNumber" value="{{$user->phone_number}}" class="form-control" id="">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                    <textarea class="form-control" name="profileAddress" id="profileAddress" rows="3">{{$user->address}}    </textarea>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>  
        </div>
    </form>
</div>
@include('commons.footer')