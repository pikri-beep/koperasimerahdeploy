<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi MP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">KOPERASI <span class="text-dark">MP</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm fw-bold">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3 text-dark">Sistem Informasi <br><span class="text-primary">Koperasi MP</span></h1>
                    <p class="lead text-muted mb-4">Kelola penarikan saldo dan pemantauan modal dengan lebih transparan, aman, dan mudah melalui dashboard digital kami.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <!-- <a href="#fitur" class="btn btn-primary btn-lg px-4 shadow">Mulai Sekarang</a>
                        <a href="#fitur" class="btn btn-outline-secondary btn-lg px-4">Pelajari Fitur</a> -->
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://img.freepik.com/free-vector/financial-administration-abstract-concept-vector-illustration-financial-management-corporate-accounting-budget-planning-company-resource-allocation-investment-policy-abstract-metaphor_335657-2933.jpg" class="img-fluid rounded-4 shadow-sm" alt="Ilustrasi Koperasi">
                </div>
            </div>
        </div>
    </header>

    <section id="fitur" class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Layanan Utama Kami</h2>
                <p class="text-muted">Fitur khusus yang dirancang untuk memudahkan anggota kelompok.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                        <div class="card-body">
                            <div class="mb-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
                                </svg>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Penarikan Dana</h5>
                            <p class="card-text text-muted">Ajukan penarikan saldo simpananmu kapan saja dengan proses verifikasi yang cepat dan tercatat otomatis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                        <div class="card-body">
                            <div class="mb-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5Z"/>
                                </svg>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Manajemen Modal</h5>
                            <p class="card-text text-muted">Pantau rincian setoran modal secara real-time dan pantau pertumbuhan simpanan kelompokmu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0 small">© 2026 Koperasi MP - Tugas Kelompok Pengembangan Web</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>