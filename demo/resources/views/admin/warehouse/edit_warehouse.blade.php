@extends('layout.master')

@section('title', 'Edit Warehouse')

@section('content')

<div class="page-title-box d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Edit Warehouse</h4>
    <a href="{{ route('all.warehouse') }}" class="btn btn-dark">
        <i class="ri-arrow-go-back-line me-1"></i> Back
    </a>
</div>

<div class="card shadow">
    <div class="card-body">

        <form action="{{ route('update.warehouse', $warehouse->id) }}" method="POST">
            @csrf

            <div class="row">

                <!-- Region -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Region</label>
                    <select name="region_id" class="form-select" required>
                        <option value="">-- Select Region --</option>

                        @foreach($regions as $region)
                            <option value="{{ $region->id }}"
                                {{ $warehouse->region_id == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Location -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                           value="{{ $warehouse->location }}" required>
                </div>

                <!-- Warehouse Name -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Warehouse Name</label>
                    <input type="text" name="warehouse" class="form-control"
                           value="{{ $warehouse->warehouse }}" required>
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3">
                Update Warehouse
            </button>

        </form>

    </div>
</div>

@endsection
