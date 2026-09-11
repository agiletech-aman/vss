@extends('layout.master')

@section('title', 'Add Warehouse')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Add New Warehouse</h4>
    <a href="{{ route('all.warehouse') }}" class="btn btn-dark">
        <i class="ri-arrow-go-back-line"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('store.warehouse') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Region</label>
                    <select name="region_id" class="form-control" required>
                        <option value="">-- Select Region --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Warehouse Name</label>
                    <input type="text" name="warehouse" class="form-control" placeholder="Enter warehouse name" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Enter warehouse location" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success"><i class="ri-check-line"></i> Save Warehouse</button>
        </form>
    </div>
</div>
@endsection
