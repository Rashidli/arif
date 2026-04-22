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
                            <h4 class="card-title">Texniki Dəstək Elementləri</h4>
                            <a href="{{route('support_items.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>İkon</th>
                                            <th>Başlıq (Az)</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($supportItems as $item)
                                        <tr>
                                            <th scope="row">{{$item->id}}</th>
                                            <td>
                                                @if($item->icon)
                                                    <img src="{{ asset('storage/' . $item->icon) }}" alt="" style="height: 40px;">
                                                @endif
                                            </td>
                                            <td>{{$item->translate('az')->title ?? '-'}}</td>
                                            <td>{{$item->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('support_items.edit', $item->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('support_items.destroy', $item->id)}}" method="post" style="display: inline-block">
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
                                {{ $supportItems->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
