@extends('layout.master')

@section('title', 'All Regions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">All Regions</h4>
    <a href="{{ route('add.region') }}" class="btn btn-primary">
        <i class="ri-add-line align-middle me-1"></i> Add New Region
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Region Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($regions as $key => $region)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $region->name }}</td>
                    <td>{{ $region->created_at?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <a href="{{ route('edit.region', $region->id) }}" class="btn btn-warning btn-sm">
                            <i class="ri-edit-2-line"></i>
                        </a>
                        <a href="{{ route('delete.region', $region->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Delete this region?')">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
