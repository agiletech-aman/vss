@extends('layout.master')

@section('title', 'Add Region')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Add New Region</h4>
    <a href="{{ route('all.region') }}" class="btn btn-dark">
        <i class="ri-arrow-go-back-line"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('store.region') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Region Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter region name" required>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="ri-check-line"></i> Save Region
            </button>
        </form>
    </div>
</div>
@endsection
