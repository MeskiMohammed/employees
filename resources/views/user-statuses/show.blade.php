@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Status Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('user-statuses.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $userStatus->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $userStatus->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $userStatus->description }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $userStatus->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $userStatus->updated_at }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('user-statuses.edit', $userStatus->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('user-statuses.destroy', $userStatus->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user status?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
