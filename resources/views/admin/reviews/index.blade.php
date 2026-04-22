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
                            <h4 class="card-title">Müştəri Rəyləri</h4>
                            <a href="{{route('reviews.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Şəkil</th>
                                            <th>Ad</th>
                                            <th>Vəzifə</th>
                                            <th>Reytinq</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reviews as $review)
                                        <tr>
                                            <th scope="row">{{$review->id}}</th>
                                            <td>
                                                @if($review->image)
                                                    <img src="{{asset('storage/'.$review->image)}}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" alt="">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: #e0e0e0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{$review->name}}</td>
                                            <td>{{$review->position ?? '-'}}</td>
                                            <td>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}" style="color: #ffc107;"></i>
                                                @endfor
                                            </td>
                                            <td>{{$review->is_active ? 'Active' : 'Deactive'}}</td>
                                            <td>
                                                <a href="{{route('reviews.edit', $review->id)}}" class="btn btn-primary" style="margin-right: 15px">Edit</a>
                                                <form action="{{route('reviews.destroy', $review->id)}}" method="post" style="display: inline-block">
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
                                {{ $reviews->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
