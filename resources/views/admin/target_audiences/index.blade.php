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
                            <h4 class="card-title">Hədəf Auditoriyaları</h4>
                            <a href="{{route('target_audiences.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Şəkil</th>
                                            <th>Başlıq (Az)</th>
                                            <th>Elementlər</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($audiences as $audience)
                                        <tr>
                                            <th scope="row">{{$audience->id}}</th>
                                            <td>
                                                @if($audience->image)
                                                    <img src="{{ asset('storage/' . $audience->image) }}" alt="" style="height: 50px; border-radius: 4px;">
                                                @endif
                                            </td>
                                            <td>{{$audience->translate('az')->title ?? '-'}}</td>
                                            <td>
                                                <a href="{{route('target_items.index', $audience->id)}}" class="btn btn-info btn-sm">
                                                    Elementlər ({{$audience->items->count()}})
                                                </a>
                                            </td>
                                            <td>{{$audience->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('target_audiences.edit', $audience->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('target_audiences.destroy', $audience->id)}}" method="post" style="display: inline-block">
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
                                {{ $audiences->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
