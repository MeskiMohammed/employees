@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Employee Post</h3>
                    <div class="card-tools">
                        <a href="{{ route('employee-posts.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('employee-posts.store') }}" method="POST">
                        @csrf

                        <label for="">Post Name</label>
                        <input type="text" name="post">
                        <button type="submit" class="btn btn-primary">Create Employee Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
