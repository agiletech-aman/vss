@extends('layout.master')

@section('title', 'Fire / Smoke / Rodent Alerts')

@section('content')

<h4 class="fw-bold mb-3">Fire / Smoke / Rodent – Camera Summary</h4>

<!-- FILTER -->
<form method="GET" class="row g-2 mb-3 align-items-center">

    <!-- LOCATION -->
    <div class="col-md-4">
        <input type="text"
               name="location"
               class="form-control"
               placeholder="Search by Location"
               value="{{ request('location') }}">
    </div>

    <!-- FILTER -->
    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            Filter
        </button>
    </div>

    <!-- RESET -->
    <div class="col-md-2">
        <a href="{{ route('alerts.camera.alerts') }}"
           class="btn btn-outline-secondary w-100">
            Reset
        </a>
    </div>

</form>

<div class="text-muted mb-2">
    Showing {{ $alerts->count() }} of {{ $total }} records
</div>

<!-- TABLE -->
<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="min-width:200px;">Location</th>
                        <th style="width:140px;">Total Cameras</th>
                        <th style="width:120px;" class="text-danger">🔥 Fire</th>
                        <th style="width:120px;" class="text-warning">💨 Smoke</th>
                        <th style="width:120px;" class="text-success">🐀 Rodent</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alerts as $row)
                        <tr>
                            <td>{{ $row['location'] ?? '-' }}</td>

                            <td class="fw-semibold">
                                {{ $row['totalCameraCount'] ?? 0 }}
                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    {{ $row['fireCount'] ?? 0 }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ $row['smokeCount'] ?? 0 }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $row['rodentCount'] ?? 0 }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No alert data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- PAGINATION -->
<div class="mt-3">
    {{ $alerts->appends(request()->query())->links('pagination::simple-bootstrap-5') }}
</div>

@endsection
