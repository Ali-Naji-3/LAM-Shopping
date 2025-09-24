@if (session()->has('success'))
    <div class="bg-green-200 border-green-600 p-4 mb-3 rounded-sm">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="bg-red-200 border-red-600 p-4 mb-3 rounded-sm">
        {{ session('error') }}
    </div>
@endif
