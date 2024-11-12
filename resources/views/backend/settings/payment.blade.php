@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Payment Settings</h2>
                </div> 
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-md-12">
                @include('backend.layouts.notification')
                
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
                        <form action="{{route('admin.paypal.settings.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_method" value="paypal">
                            <div class="row clearfix">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Paypal Client ID</label>
                                        <input type="hidden" name="paypal[]" value="PAYPAL_CLIENT_ID">
                                        <input type="text" name="PAYPAL_CLIENT_ID" value="{{env('PAYPAL_CLIENT_ID')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Paypal Client Secret</label>
                                        <input type="hidden" name="paypal[]" value="PAYPAL_CLIENT_SECRET">
                                        <input type="text" name="PAYPAL_CLIENT_SECRET" value="{{env('PAYPAL_CLIENT_SECRET')}}" class="form-control">
                                    </div>
                                </div>
                                @php
                                    use App\Models\Settings;
                                    $settings = Settings::first();
                                @endphp
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Paypal Sandbox Mode</label>
                                        <input type="checkbox" name="paypal_sandbox" value="1" {{$settings->paypal_sandbox == 1?'checked':''}}>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
