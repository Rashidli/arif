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
                                    <h4 class="card-title mb-0">Sözlər</h4>
                                    <a href="{{route('words.create')}}" class="btn btn-primary">+ Yeni söz</a>
                                </div>

                                <!-- Search Form -->
                                <form action="{{ route('words.index') }}" method="GET" class="mb-4">
                                    <div class="input-group" style="max-width: 400px;">
                                        <input type="text" name="search" class="form-control" placeholder="Söz və ya tərcümə axtar..." value="{{ $search ?? '' }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Axtar
                                        </button>
                                        @if($search)
                                        <a href="{{ route('words.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        @endif
                                    </div>
                                    @if($search)
                                    <small class="text-muted mt-1 d-block">{{ $words->count() }} nəticə tapıldı "{{ $search }}" üçün</small>
                                    @endif
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover">

                                        <thead>
                                        <tr>
                                            <th style="width: 50px;">№</th>
                                            <th>AZ</th>
                                            <th>EN</th>
                                            <th>RU</th>
                                            <th style="width: 100px;">Əməliyyat</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($words as $index => $word)

                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td style="word-break: break-word;">{{ $word->translate('az')->title ?? '-' }}</td>
                                                <td style="word-break: break-word;">{{ $word->translate('en')->title ?? '-' }}</td>
                                                <td style="word-break: break-word;">{{ $word->translate('ru')->title ?? '-' }}</td>
                                                <td>
                                                    <a href="{{route('words.edit',$word->id)}}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
{{--                                    {{ $words->links('vendor.pagination.bootstrap-5') }}--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
