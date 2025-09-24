@extends('admin.dashboard')

@section('content')
  <!-- Welcome Card -->
        <div class="welcome-card">
            <h2>🎉 Welcome to Collection Store Admin Dashboard!</h2>
            <p class="mb-0">You are logged in as <strong>{{ strtoupper(auth()->user()->u_type) }}</strong> - {{ auth()->user()->name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="stats-card">
                    <div class="icon">👥</div>
                    <div class="number">{{ $stats['total_users'] }}</div>
                    <div class="label">Total Users</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stats-card">
                    <div class="icon">👨‍💼</div>
                    <div class="number">{{ $stats['total_admins'] }}</div>
                    <div class="label">Admins & Managers</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stats-card">
                    <div class="icon">📊</div>
                    <div class="number">{{ $stats['total_all_users'] }}</div>
                    <div class="label">All Users</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="welcome-card">
                    <h3>🚀 Quick Actions</h3>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <a href="#" class="btn btn-primary w-100 mb-2">Add Product</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-info w-100 mb-2">View Orders</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-success w-100 mb-2">Manage Users</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('/') }}" class="btn btn-warning w-100 mb-2">View Store</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="row">
            <div class="col-12">
                <div class="welcome-card">
                    <h3>📋 System Information</h3>
                    <div class="row text-start">
                        <div class="col-md-6">
                            <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                            <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                            <p><strong>Current Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

