@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit Users</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">Edit Users</li>
                    </ul>
                </div> 
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-md-12">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                           <ul>{{$error}}</ul>
                       @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <form action="{{route('admin.users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Full Name <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Full Name" name="full_name" value="{{$user->full_name}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Username</lable>
                                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{$user->username}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Email</lable>
                                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{$user->email}}">
                                </div>
                            </div>  
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Phone</lable>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{$user->phone}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Address</lable>
                                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{$user->address}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                   <lable for="">Photo <span class="text-danger">*</span></lable>
                                   <br>
                                   <input type="file" name="photo"/>
                                   <br><br>
                                    <img src="{{$user->photo}}" alt="user photo" style="max-height:150px;
                                    max-width:150px">
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">     
                                <label for="status">Role</label>                            
                                <select name="role" class="form-control show-tick">
                                    <option value="">--Role--</option>
                                    <option value="admin" {{$user->role=='admin'?'selected':''}}>Admin</option>
                                    <option value="vendor" {{$user->role=='vendor'?'selected':''}}>Vendor</option>
                                    <option value="customer" {{$user->role=='customer'?'selected':''}}>Customer</option>
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">    
                                <label for="status">Status</label>                            
                                <select name="status" class="form-control show-tick">
                                    <option value="">--Status--</option>
                                    <option value="active" {{$user->status=='active'?'selected':''}}>Active</option>
                                    <option value="inactive" {{$user->status=='inactive'?'selected':''}}>Inactive</option>
                                </select>
                            </div> 
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
      $('#description').summernote();
    });
</script>
@endsection

{{-- you are doing well, but what's the hell --}}