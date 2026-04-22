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
                            <h4 class="card-title">Məqalə Kateqoriyaları</h4>
                            <a href="{{route('blog_categories.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Ad (Az)</th>
                                            <th>Status</th>
                                            <th>Seçilmiş</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <th scope="row">{{$category->id}}</th>
                                            <td>{{$category->translate('az')->name ?? '-'}}</td>
                                            <td>
                                                @if($category->status)
                                                    <span class="badge bg-success">Aktiv</span>
                                                @else
                                                    <span class="badge bg-secondary">Deaktiv</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($category->show_on_home)
                                                    <span class="badge bg-success" title="Ana səhifə, Header, Footer-də göstərilir">
                                                        <i class="fas fa-check me-1"></i>Seçilmiş (#{{ $category->home_order }})
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-dark">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('blog_categories.edit', $category->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('blog_categories.destroy', $category->id)}}" method="post" style="display: inline-block">
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
                                {{ $categories->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
