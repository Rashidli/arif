@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Yeni Üstünlük</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('benefits.index') }}">Üstünlüklər</a></li>
                                <li class="breadcrumb-item active">Yeni</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            <form action="{{ route('benefits.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0 text-white">Dil Versiyaları</h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                                    @foreach(['az', 'en', 'ru'] as $lang)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($loop->first) active @endif" data-bs-toggle="tab" href="#{{ $lang }}" role="tab">
                                                <i class="fas fa-globe me-1"></i> {{ strtoupper($lang) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach(['az', 'en', 'ru'] as $lang)
                                        <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $lang }}" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Başlıq <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" value="{{ old($lang . '_title') }}" name="{{ $lang }}_title" placeholder="Üstünlük başlığı...">
                                                        @error("{$lang}_title")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Açıqlama <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="5" name="{{ $lang }}_description" placeholder="Üstünlük açıqlaması...">{{ old($lang . '_description') }}</textarea>
                                                        @error("{$lang}_description")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Şəkil</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Şəkil <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="image" accept="image/*">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Parametrlər</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                        <label class="form-check-label">Aktiv</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Yadda Saxla</button>
                                    <a href="{{ route('benefits.index') }}" class="btn btn-outline-secondary">Geri</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.includes.footer')
