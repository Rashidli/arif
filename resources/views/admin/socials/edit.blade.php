@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="mb-0">Sosial Şəbəkə Redaktə</h4>
                            <a href="{{ route('socials.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="ri-list-check"></i> Siyahı
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('socials.update', $social->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$social->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq</label>
                                    <input class="form-control" type="text" name="title" value="{{$social->title}}">
                                    @if($errors->first('title')) <small class="form-text text-danger">{{$errors->first('title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Link</label>
                                    <input class="form-control" type="text" name="link" value="{{$social->link}}">
                                    @if($errors->first('link')) <small class="form-text text-danger">{{$errors->first('link')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    @if($social->icon)
                                    <img style="width: 50px; height: 50px;" src="{{asset('storage/' . $social->icon)}}" class="uploaded_image mb-2" alt="{{$social->title}}">
                                    @endif
                                    <div class="form-group">
                                        <label>İkon</label>
                                        <input type="file" name="icon" class="form-control">
                                    </div>
                                    @if($errors->first('icon')) <small class="form-text text-danger">{{$errors->first('icon')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$social->is_active == true ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$social->is_active == false ? 'selected' : ''}}>Deactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary">Yadda saxla</button>
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

{{--<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>--}}
{{--<script>--}}
{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor_az' ) )--}}
{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}

{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor_en' ) )--}}
{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}

{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor_ru' ) )--}}
{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}

{{--</script>--}}
