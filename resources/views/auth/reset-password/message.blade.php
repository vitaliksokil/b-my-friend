@extends('main')
@section('content')
    <div class="container p-4">
        @isset($success)
            <div class="alert alert-success" role="alert">
                {{$success}}
            </div>
        @endisset
        @isset($error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endisset
    </div>
@endsection
