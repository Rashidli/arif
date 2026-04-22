@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Yeni Kateqoriya</h4>
                    </div>
                </div>
            </div>

            <form action="{{ route('blog_categories.store') }}" method="post">
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
                                                {{ strtoupper($lang) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach(['az', 'en', 'ru'] as $lang)
                                        <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $lang }}" role="tabpanel">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Ad @if($lang == 'az')<span class="text-danger">*</span>@endif</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_name" value="{{ old($lang . '_name') }}">
                                                @error("{$lang}_name")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0 text-white">Ana Səhifə</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="show_on_home" value="1" {{ old('show_on_home') ? 'checked' : '' }}>
                                        <label class="form-check-label">Seçilmiş kateqoriya</label>
                                    </div>
                                    <div class="alert alert-info py-2 px-3 mt-2 mb-0" style="font-size: 12px;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Bu kateqoriya <strong>Ana səhifədə</strong>, <strong>Header</strong> və <strong>Footer</strong> menyularında göstəriləcək.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sıralama</label>
                                    <input class="form-control" type="number" name="home_order" value="{{ old('home_order', 0) }}" min="0">
                                    <small class="text-muted">Kiçik rəqəm = daha yuxarıda</small>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Yadda Saxla</button>
                                    <a href="{{ route('blog_categories.index') }}" class="btn btn-outline-secondary">Geri</a>
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
