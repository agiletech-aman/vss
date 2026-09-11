@extends('layout.master')

@section('title', 'All Warehouses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">All Warehouses</h4>
    <a href="{{ route('add.warehouse') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add New Warehouse
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Region</th>
                    <th>Warehouse</th>
                    <th>Location</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $key => $warehouse)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $warehouse->region->name ?? 'N/A' }}</td>
                    <td>{{ $warehouse->warehouse }}</td>
                    <td>{{ $warehouse->location }}</td>
                    <td>{{ $warehouse->created_at?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <a href="{{ route('edit.warehouse', $warehouse->id) }}" class="btn btn-warning btn-sm"><i class="ri-edit-2-line"></i></a>
                        <a href="{{ route('delete.warehouse', $warehouse->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Delete this warehouse?')">
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
