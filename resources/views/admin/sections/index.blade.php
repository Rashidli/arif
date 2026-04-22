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
                            <h4 class="card-title">Bölmələr</h4>
                            <a href="{{route('sections.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Şəkil</th>
                                            <th>Tip</th>
                                            <th>Başlıq (Az)</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sections as $section)
                                        <tr>
                                            <th scope="row">{{$section->id}}</th>
                                            <td>
                                                @if($section->image)
                                                    <img src="{{ asset('storage/' . $section->image) }}" alt="" style="height: 50px; border-radius: 4px;">
                                                @endif
                                            </td>
                                            <td><code>{{$section->type}}</code></td>
                                            <td>{{$section->translate('az')->title ?? '-'}}</td>
                                            <td>{{$section->status ? 'Aktiv' : 'Deaktiv'}}</td>
                                            <td>
                                                <a href="{{route('sections.edit', $section->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{route('sections.destroy', $section->id)}}" method="post" style="display: inline-block">
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
                                {{ $sections->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
