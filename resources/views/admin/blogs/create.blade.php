@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Yeni Məqalə</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Məqalələr</a></li>
                                <li class="breadcrumb-item active">Yeni</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('blogs.store') }}" method="post" enctype="multipart/form-data">
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
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Başlıq @if($lang == 'az')<span class="text-danger">*</span>@endif</label>
                                                        <input class="form-control form-control-lg" type="text" value="{{ old($lang . '_title') }}" name="{{ $lang }}_title" placeholder="Məqalə başlığı...">
                                                        @error("{$lang}_title")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Qısa Mətn</label>
                                                        <textarea class="form-control" rows="3" name="{{ $lang }}_short_description" placeholder="Qısa təsvir...">{{ old($lang . '_short_description') }}</textarea>
                                                        @error("{$lang}_short_description")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Tam Mətn @if($lang == 'az')<span class="text-danger">*</span>@endif</label>
                                                        <textarea id="editor_{{ $lang }}" class="form-control" name="{{ $lang }}_description" rows="6">{{ old($lang . '_description') }}</textarea>
                                                        @error("{$lang}_description")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Şəkil Title Tag</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_img_title" value="{{ old($lang . '_img_title') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Şəkil Alt Tag</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_img_alt" value="{{ old($lang . '_img_alt') }}">
                                                    </div>
                                                </div>

                                                <div class="col-12"><hr></div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Meta Title</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_meta_title" value="{{ old("{$lang}_meta_title") }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Meta Description</label>
                                                        <textarea class="form-control" name="{{ $lang }}_meta_description" rows="2">{{ old("{$lang}_meta_description") }}</textarea>
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
                                <h5 class="card-title mb-0">Parametrlər</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kateqoriya <span class="text-danger">*</span></label>
                                    <select name="blog_category_id" class="form-select" required>
                                        <option value="">Seçin...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('blog_category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Şəkil <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="image" accept="image/*">
                                    <small class="text-muted">Ölçü: 800x500 px</small>
                                    @error('image')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">YouTube Video</label>
                                    <input class="form-control" type="text" name="youtube_video" value="{{ old('youtube_video') }}" placeholder="https://www.youtube.com/watch?v=...">
                                    <small class="text-muted">YouTube video linkini daxil edin</small>
                                    @error('youtube_video')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="statusSwitch" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwitch">Aktiv</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featuredSwitch" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featuredSwitch">Seçilmiş</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_slider" value="1" id="sliderSwitch" {{ old('is_slider') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sliderSwitch">Hero Slider</label>
                                    </div>
                                    <small class="text-muted">Ana səhifədə hero sliderda göstərilsin</small>
                                </div>

                                <div class="mb-3" id="sliderOrderGroup" style="{{ old('is_slider') ? '' : 'display: none;' }}">
                                    <label class="form-label">Slider Sırası</label>
                                    <input type="number" class="form-control" name="slider_order" value="{{ old('slider_order', 0) }}" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Yadda Saxla</button>
                                    <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary">Geri</a>
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

<script>
document.getElementById('sliderSwitch').addEventListener('change', function() {
    document.getElementById('sliderOrderGroup').style.display = this.checked ? 'block' : 'none';
});
</script>
