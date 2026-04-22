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

                                <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $type === 'contact' ? 'active' : '' }}" href="{{ route('contacts.index', ['type' => 'contact']) }}">
                                            Mesajlar <span class="badge bg-primary">{{ $contactCount }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $type === 'demo' ? 'active' : '' }}" href="{{ route('contacts.index', ['type' => 'demo']) }}">
                                            Demo Müraciətləri <span class="badge bg-success">{{ $demoCount }}</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            @if($type === 'demo')
                                            <tr>
                                                <th>№</th>
                                                <th>Telefon</th>
                                                <th>Email</th>
                                                <th>Şirkət</th>
                                                <th>Tarix</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                            @else
                                            <tr>
                                                <th>№</th>
                                                <th>Ad Soyad</th>
                                                <th>Telefon</th>
                                                <th>Email</th>
                                                <th>Mövzu</th>
                                                <th>Mesaj</th>
                                                <th>Tarix</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                            @endif
                                        </thead>

                                        <tbody>
                                        @forelse($contacts as $contact)
                                            @if($type === 'demo')
                                            <tr>
                                                <td>{{$contact->id}}</td>
                                                <td>{{$contact->phone}}</td>
                                                <td>{{$contact->email}}</td>
                                                <td>{{$contact->company}}</td>
                                                <td>{{$contact->created_at->format('d.m.Y H:i')}}</td>
                                                <td>
                                                    <form action="{{route('contacts.destroy', $contact->id)}}" method="post" style="display: inline-block">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger btn-sm">Sil</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>{{$contact->id}}</td>
                                                <td>{{$contact->name}} {{$contact->surname}}</td>
                                                <td>{{$contact->phone}}</td>
                                                <td>{{$contact->email}}</td>
                                                <td>{{$contact->subject ?? '-'}}</td>
                                                <td>{{Str::limit($contact->message, 50)}}</td>
                                                <td>{{$contact->created_at->format('d.m.Y H:i')}}</td>
                                                <td>
                                                    <form action="{{route('contacts.destroy', $contact->id)}}" method="post" style="display: inline-block">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger btn-sm">Sil</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="{{ $type === 'demo' ? 6 : 8 }}" class="text-center">Məlumat yoxdur</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $contacts->appends(['type' => $type])->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('admin.includes.footer')
