@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Users <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-outline-secondary"><i class="icon-plus"></i> Create User</a></h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                    <p class="float-right">Total Users:{{$users->count()}}</p>
                </div>            
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>User</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Is Verified</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                            
                                <tbody>
                                    @foreach ($users as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <img src="{{$item->photo}}" alt="user photo" style="border-radius:50%;max-height:150px;
                                            max-width:150px">
                                        </td>
                                        <td>{{$item->full_name}}</td>
                                        {{-- {{ $item->photo }}  --}}
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->role}}</td>
                                        <td>
                                            <input type="checkbox"  name="verified" value="{{$item->id}}" data-toggle="switchbutton"  {{$item->is_verified == '1'?'checked':''}} data-onlabel="Yes" data-offlabel="No" 
                                            data-size="sm"
                                            data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        <td>
                                            <input type="checkbox"  name="toogle" value="{{$item->id}}" data-toggle="switchbutton"  {{$item->status == 'active'?'checked':''}} data-onlabel="Active" data-offlabel="Inactive" 
                                            data-size="sm"
                                            data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        <td>
                                            <a href="{{route('admin.users.edit',$item->id)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary mr-2" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                            <a href="#" data-toggle="modal" data-target="#userID{{$item->id}}"  data-toggle="tooltip" class="btn btn-sm btn-outline-secondary mr-2" title="edit" data-placement="bottom"><i class="fas fa-eye"></i></a>

                                            <form  action="{{route('admin.users.destroy',$item->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$item->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                            </form>
                                        </td>

                                        <div class="modal fade" id="userID{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <div class="w-100 d-flex flex-column align-items-center">
                                                            <img src="{{$item->photo}}" alt="User Photo" style="border-radius: 50%; margin: 2% 0; max-height: 150px; max-width: 150px;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $item->full_name }}</h5>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <strong>Username:</strong>
                                                            <p class="mb-0">{{ $item->username }}</p>
                                                        </div>
                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Email:</strong>
                                                                <p class="mb-0">{{ $item->email }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Phone:</strong>
                                                                <p class="mb-0">{{ $item->phone }}</p>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <strong>Address:</strong>
                                                                <p class="mb-0">{{ $item->address }}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <strong>Role:</strong>
                                                                <p class="mb-0">{{ $item->role }}</p>
                                                            </div>
                                                        </div>
                                

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Status:</strong>
                                                                <p class="badge badge-warning">{{ $item->status }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Verified:</strong>
                                                                <p class="badge badge-primary">{{ $item->is_verified?'Yes':'No' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                   
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('.dltBtn').click(function (e){
        var form=$(this).closest('form');
        var dataID=$(this).data('id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });
    });
</script>
<script>
    $('input[name=toogle]').change(function(){
        var mode = $(this).prop('checked');
        var id = $(this).val();
        // alert(mode);
        $.ajax({
            url:"{{ route('admin.users.status') }}",
            type:"POST",
            data:{
                _token:'{{ csrf_token() }}',
                'id':id
            },
            success:function(response){
                if(response.status){
                    alert(response.success)
                }
                else{
                    alert('Please try again!')
                }
            }
        })
    });
</script>

<script>
    $('input[name=verified]').change(function(){
        var mode = $(this).prop('checked');
        var id = $(this).val();
        // alert(mode);
        $.ajax({
            url:"{{ route('admin.users.verification') }}",
            type:"POST",
            data:{
                _token:'{{ csrf_token() }}',
                'id':id
            },
            success:function(response){
                if(response.status){
                    alert(response.success)
                }
                else{
                    alert('Please try again!')
                }
            }
        })
    });
</script>
@endsection