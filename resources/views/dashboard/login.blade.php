<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi MP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-primary d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%; border-radius: 15px;">
        <div class="card-body p-5 text-center">
            <div class="mb-4 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.158 7.158 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z"/>
                </svg>
            </div>
            <h3 class="fw-bold mb-1">Koperasi MP</h3>
            <p class="text-muted small mb-4">Akses Dashboard Pengurus</p>
            
            <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                Masuk ke Dashboard
            </a>

            <div class="mt-4">
                <a href="{{ url('/') }}" class="text-decoration-none text-muted small">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>