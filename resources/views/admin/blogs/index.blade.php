@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{session('message')}}</div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Məqalələr</h4>
                                <a href="{{route('blogs.create')}}" class="btn btn-primary">
                                    <i class="mdi mdi-plus"></i> Yeni Məqalə
                                </a>
                            </div>

                            {{-- Filters --}}
                            <form method="GET" action="{{ route('blogs.index') }}" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" placeholder="Başlıq axtar..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="category" class="form-select">
                                            <option value="">Bütün kateqoriyalar</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-select">
                                            <option value="">Bütün statuslar</option>
                                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktiv</option>
                                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Deaktiv</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="featured" class="form-select">
                                            <option value="">Featured</option>
                                            <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Bəli</option>
                                            <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Xeyr</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="mdi mdi-magnify"></i> Axtar
                                        </button>
                                        <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary">
                                            <i class="mdi mdi-refresh"></i> Sıfırla
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Başlıq</th>
                                            <th>Kateqoriya</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td>{{$blog->id}}</td>
                                            <td>{{$blog->title}}</td>
                                            <td>{{$blog->category?->name ?? '-'}}</td>
                                            <td>{{$blog->is_active ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('blogs.edit',$blog->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('blogs.destroy', $blog->id)}}" method="post" style="display: inline-block">
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $blogs->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
