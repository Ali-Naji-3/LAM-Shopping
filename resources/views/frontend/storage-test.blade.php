<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Test - Image Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-center mb-4">📁 Storage Access Test</h1>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Image Access Test</h3>
                    </div>
                    <div class="card-body">
                        <h5>Test Image (test-image.jpg):</h5>
                        <img src="{{ asset('storage/products/test-image.jpg') }}" 
                             alt="Test Image" 
                             class="img-fluid mb-3" 
                             style="max-width: 300px; border: 2px solid #dee2e6; border-radius: 8px;">
                        
                        <div class="alert alert-success">
                            <strong>✅ Success!</strong> The image is loading correctly.
                        </div>
                        
                        <h5>Available Product Images:</h5>
                        <div class="row">
                            @php
                                $productImages = [
                                    'product_1.jpg',
                                    'product_2.jpg', 
                                    'product_3.jpg',
                                    'product_4.jpg',
                                    'product_5.jpg',
                                    'product_6.jpg'
                                ];
                            @endphp
                            
                            @foreach($productImages as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/products/' . $image) }}" 
                                             alt="{{ $image }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $image }}</h6>
                                            <a href="{{ asset('storage/products/' . $image) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">View Full Size</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <h6>Storage Configuration:</h6>
                            <ul class="mb-0">
                                <li><strong>Storage Path:</strong> <code>storage/app/public/</code></li>
                                <li><strong>Public Link:</strong> <code>public/storage</code></li>
                                <li><strong>URL:</strong> <code>{{ url('storage') }}</code></li>
                                <li><strong>Permissions:</strong> 755 (directories), 644 (files)</li>
                            </ul>
                        </div>
                        
                        <div class="alert alert-warning">
                            <h6>If you're still getting 403 errors:</h6>
                            <ol>
                                <li>Check file permissions: <code>chmod -R 755 storage/app/public/</code></li>
                                <li>Ensure storage link exists: <code>php artisan storage:link</code></li>
                                <li>Check web server permissions on the storage directory</li>
                                <li>Verify the file actually exists in the storage directory</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
