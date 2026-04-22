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
                            <h4 class="card-title">{{ $targetAudience->title }} - Elementlər</h4>
                            <div class="mb-3">
                                <a href="{{route('target_items.create', $targetAudience->id)}}" class="btn btn-primary">+ Yeni Element</a>
                                <a href="{{route('target_audiences.index')}}" class="btn btn-outline-secondary">Geri</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Mətn (Az)</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <th scope="row">{{$item->id}}</th>
                                            <td>{{ Str::limit($item->translate('az')->text ?? '-', 50) }}</td>
                                            <td>{{$item->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('target_items.edit', [$targetAudience->id, $item->id])}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('target_items.destroy', [$targetAudience->id, $item->id])}}" method="post" style="display: inline-block">
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
                                {{ $items->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
