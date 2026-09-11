@extends('layout.master')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">User Management</h4>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            + Create User
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="20%">Name</th>
                            <th width="20%">Email</th>
                            <th width="15%">Roles</th>
                            <th width="20%">Assignment</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)

                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                {{-- Roles --}}
                                <td>
                                    @forelse($user->roles as $role)

                                        @if($role->name === 'superadmin')
                                            <span class="badge bg-danger">
                                                SuperAdmin
                                            </span>

                                        @elseif($role->name === 'admin')
                                            <span class="badge bg-warning text-dark">
                                                Admin
                                            </span>

                                        @elseif($role->name === 'region_officer')
                                            <span class="badge bg-purple text-white" style="background-color: #6f42c1;">
                                                Region Officer
                                            </span>

                                        @elseif($role->name === 'warehouse_officer')
                                            <span class="badge bg-info text-white">
                                                Warehouse Officer
                                            </span>

                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @endif

                                    @empty
                                        <span class="text-muted">No Role</span>
                                    @endforelse
                                </td>

                                {{-- Assignment (Region/Warehouse) --}}
                                <td>
                                    @if($user->hasRole('region_officer') && $user->region)
                                        <small class="text-muted d-block">Region:</small>
                                        <strong>{{ $user->region->name }}</strong>
                                    @elseif($user->hasRole('warehouse_officer') && $user->warehouse)
                                        <small class="text-muted d-block">Warehouse:</small>
                                        <strong>{{ $user->warehouse->name }}</strong>
                                        <br>
                                        <small class="text-muted">({{ $user->warehouse->region->name }})</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td>

                                    {{-- Protect SuperAdmin --}}
                                    @if($user->hasRole('superadmin'))

                                        <span class="badge bg-secondary">
                                            Protected
                                        </span>

                                    @else

                                        {{-- Edit --}}
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="btn btn-sm btn-warning me-1">
                                            Edit
                                        </a>

                                        {{-- Prevent self-delete --}}
                                        @if(auth()->id() !== $user->id)

                                            <form action="{{ route('users.destroy', $user->id) }}"
                                                  method="POST"
                                                  style="display:inline-block;"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>

                                        @else
                                            <span class="text-muted small">
                                                (You)
                                            </span>
                                        @endif

                                    @endif

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
