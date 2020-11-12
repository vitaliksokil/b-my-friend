@extends('main')
@section('content')
    <div class="container mt-5">
        @if($errors->any())
            <div class="alert alert-danger mb-5">{{ $errors->first() }}</div>
        @endif

        <form action="{{route('change-password')}}" method="post">
            @csrf
            <input type="hidden" name="email" value="{{$email}}">
            <input type="hidden" name="token" value="{{$token}}">

            <div class="form-group">
                <label for="newPass">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="newPass">
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="newPass">Confirm Your Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="newPass">
                @error('password_confirmation')
                     <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
