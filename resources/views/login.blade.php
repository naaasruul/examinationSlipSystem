@include('commons.header')
<div class="loginContainer">
    <h1>Login</h1>
    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif
    <form action="{{route('login-user')}}" method="post">
        @csrf
        <div class="my-3">
            <label for="IC No" class="form-label">IC No.</label>
            <input type="text" class="form-control" id="ic" name="ic" placeholder="XXXXXX-XX-XXXX">
        </div>
        <div class="my-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id='password' class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

@include('commons.footer')