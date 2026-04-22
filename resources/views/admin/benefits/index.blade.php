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
                            <h4 class="card-title">Üstünlüklər</h4>
                            <a href="{{route('benefits.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Şəkil</th>
                                            <th>Başlıq (Az)</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($benefits as $benefit)
                                        <tr>
                                            <th scope="row">{{$benefit->id}}</th>
                                            <td>
                                                @if($benefit->image)
                                                    <img src="{{ asset('storage/' . $benefit->image) }}" alt="" style="height: 50px; border-radius: 4px;">
                                                @endif
                                            </td>
                                            <td>{{$benefit->translate('az')->title ?? '-'}}</td>
                                            <td>{{$benefit->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('benefits.edit', $benefit->id)}}" class="btn btn-primary" style="margin-right: 15px">Edit</a>
                                                <form action="{{route('benefits.destroy', $benefit->id)}}" method="post" style="display: inline-block">
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $benefits->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
