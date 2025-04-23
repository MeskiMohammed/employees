@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee Posts</h3>
                    <div class="card-tools">
                        <a href="{{ route('employee-posts.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Employee Post
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employeePosts as $employeePost)
                                <tr>
                                    <td>{{ $employeePost->id }}</td>
                                    <td>{{ $employeePost->post }}</td>
                                    <td>{{ $employeePost->created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('employee-posts.show', $employeePost->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('employee-posts.edit', $employeePost->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('employee-posts.destroy', $employeePost->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No employee posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $employeePosts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
