@include('admin.includes.header')
<style>
    .stat-card {
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
</style>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">San</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Statistics Cards -->
            <div class="row">
                <!-- Məqalələr -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="ri-newspaper-line"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Məqalələr</p>
                                    <h3 class="mb-0">{{ $stats['blogs'] ?? 0 }}</h3>
                                </div>
                            </div>
                            <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-outline-primary mt-3">Bax</a>
                        </div>
                    </div>
                </div>

                <!-- Contacts -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-danger bg-opacity-10 text-danger me-3">
                                    <i class="ri-mail-line"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Mesajlar</p>
                                    <h3 class="mb-0">{{ $stats['contacts'] ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-danger">Bu gün: {{ $stats['contacts_today'] ?? 0 }}</span>
                                <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-outline-danger">Bax</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary me-3">
                                    <i class="ri-user-line"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">İstifadəçilər</p>
                                    <h3 class="mb-0">{{ $stats['users'] ?? 0 }}</h3>
                                </div>
                            </div>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary mt-3">Bax</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>

    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script>
                    © San
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Santexnik
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>

@include('admin.includes.footer')
