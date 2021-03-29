@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Books {{$book->title}}</div>
                <div class="card-body">
                    {!!$book->about!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
