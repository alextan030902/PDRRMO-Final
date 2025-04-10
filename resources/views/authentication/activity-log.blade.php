@extends('layouts.app')

@section('content')

<div class="page-title accent-background py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Activity Log</h1>
        <nav class="breadcrumbs">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('pdrrmo.index') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid mt-4">
    @if($logs->isEmpty())
        <div class="alert alert-info" role="alert">
            No activities recorded yet.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Admin Name</th>
                            <th>Action</th>
                            <th>Model</th>
                            <th>Changes</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->user_name }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->model }}</td>
                                <td>
                                    @php
                                        $changes = json_decode($log->changes, true);
                                    @endphp

                                    @if($changes && is_array($changes))
                                        <ul class="mb-0">
                                            @foreach ($changes as $field => $value)
                                                <li><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong>: {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection
