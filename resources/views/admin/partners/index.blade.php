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
                            <h4 class="card-title">Partnerlər</h4>
                            <a href="{{route('partners.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Şəkil</th>
                                            <th>Ad</th>
                                            <th>Link</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($partners as $partner)
                                        <tr>
                                            <th scope="row">{{$partner->id}}</th>
                                            <td>
                                                @if($partner->image)
                                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="" style="height: 50px; border-radius: 4px;">
                                                @endif
                                            </td>
                                            <td>{{$partner->name ?? '-'}}</td>
                                            <td>{{$partner->link ?? '-'}}</td>
                                            <td>{{$partner->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('partners.edit', $partner->id)}}" class="btn btn-primary" style="margin-right: 15px">Edit</a>
                                                <form action="{{route('partners.destroy', $partner->id)}}" method="post" style="display: inline-block">
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
                                {{ $partners->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
