@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Partner Redaktə</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Partnerlər</a></li>
                                <li class="breadcrumb-item active">Redaktə</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif

            <form action="{{ route('partners.update', $partner->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0 text-white">Partner Məlumatları</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Partner Adı</label>
                                    <input class="form-control" type="text" value="{{ old('name', $partner->name) }}" name="name" placeholder="Partner adı (opsional)">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Link</label>
                                    <input class="form-control" type="url" value="{{ old('link', $partner->link) }}" name="link" placeholder="https://example.com">
                                    @error('link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                @if($partner->image)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $partner->image) }}" alt="" style="max-width: 100%; height: auto; border-radius: 4px;">
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">Partner Loqosu</label>
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
                                        <input class="form-check-input" type="checkbox" name="status" value="1" {{ $partner->status ? 'checked' : '' }}>
                                        <label class="form-check-label">Aktiv</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Yadda Saxla</button>
                                    <a href="{{ route('partners.index') }}" class="btn btn-outline-secondary">Geri</a>
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
