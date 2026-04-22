@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Ayarlar</h4>
                    </div>
                </div>
            </div>

            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif

            <form action="{{ route('settings.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp Ayarlari
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">WhatsApp Linki</label>
                                    <input class="form-control" type="text" name="whatsapp" value="{{ $settings['whatsapp'] }}" placeholder="https://wa.me/994501234567">
                                    <small class="text-muted">Numune: https://wa.me/994501234567 (olke kodu ile, + isaresi olmadan)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="fas fa-map-marker-alt me-2"></i> Xerite Ayarlari
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Google Map Embed Kodu</label>
                                    <textarea class="form-control" name="map_embed" rows="6" placeholder="<iframe src='...'></iframe>">{{ $settings['map_embed'] }}</textarea>
                                    <small class="text-muted">Google Maps-dan "Embed a map" secib iframe kodunu bura yapishdirin</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="fas fa-code me-2"></i> Developer
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Developer Adi</label>
                                    <input class="form-control" type="text" name="developer_name" value="{{ $settings['developer_name'] }}" placeholder="Developer adi">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Developer Linki</label>
                                    <input class="form-control" type="text" name="developer_link" value="{{ $settings['developer_link'] }}" placeholder="https://example.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-1"></i> Yadda Saxla
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.includes.footer')
