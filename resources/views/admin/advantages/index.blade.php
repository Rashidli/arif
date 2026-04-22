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
                            @if(session('error'))
                                <div class="alert alert-danger">{{session('error')}}</div>
                            @endif
                            <h4 class="card-title">Üstünlüklər (About səhifəsi)</h4>
                            <a href="{{route('advantages.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Tip</th>
                                            <th>Mətn (Az)</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($advantages as $advantage)
                                        <tr>
                                            <th scope="row">{{$advantage->id}}</th>
                                            <td>
                                                @if($advantage->type == 'admin')
                                                    <span class="badge bg-primary">Admin/Sahib</span>
                                                @else
                                                    <span class="badge bg-success">Kirayəçi</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($advantage->translate('az')->text ?? '-', 50) }}</td>
                                            <td>{{$advantage->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('advantages.edit', $advantage->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('advantages.destroy', $advantage->id)}}" method="post" style="display: inline-block">
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
                                {{ $advantages->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
