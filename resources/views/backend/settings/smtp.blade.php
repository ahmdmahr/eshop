@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>SMTP Settings</h2>
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
                        <form action="{{route('admin.smtp.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <div class="row clearfix">
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_DRIVER">
                                <div class="col-3">
                                   <label for="">Type</label>
                                </div>
                                <div class="col-9">
                                <select name="MAIL_DRIVER" id="" class="form-control" onchange="checkMailDriver();">
                                        <option value="sendmail" {{env('MAIL_DRIVER') == 'sendmail'?'selected':''}}>SendMail</option>
                                        <option value="smtp" {{env('MAIL_DRIVER') == 'smtp'?'selected':''}}>SMTP</option>
                                        <option value="mailgun" {{env('MAIL_DRIVER') == 'mailgun'?'selected':''}}>Mailgun</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div id="smtp">
                            <div class="col-12">
                            <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_HOST">
                                <div class="col-3">
                                    Mail Host
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="MAIL_HOST" value="{{env('MAIL_HOST')}}">
                                </div>
                            </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_PORT">
                                    <div class="col-3">
                                        Mail Port
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAIL_PORT" value="{{env('MAIL_PORT')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_USERNAME">
                                    <div class="col-3">
                                        Mail UserName
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAIL_USERNAME" value="{{env('MAIL_USERNAME')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_PASSWORD">
                                    <div class="col-3">
                                        Mail Password
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAIL_PASSWORD" value="{{env('MAIL_PASSWORD')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_PASSWORD">
                                    <div class="col-3">
                                        Mail Encryption
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAIL_ENCRYPTION" value="{{env('MAIL_ENCRYPTION')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_FROM_ADDRESS">
                                    <div class="col-3">
                                        Mail From Address
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAIL_FROM_ADDRESS" value="{{env('MAIL_FROM_ADDRESS')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAIL_FROM_NAME">
                                    <div class="col-3">
                                        Mail From Name
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAIL_FROM_NAME" value="{{env('MAIL_FROM_NAME')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mailgun">
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAILGUN_DOMAIN">
                                    <div class="col-3">
                                        MailGun Domain
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAILGUN_DOMAIN" value="{{env('MAILGUN_DOMAIN')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                <input type="hidden" name="env[]" value="MAILGUN_SECRET">
                                    <div class="col-3">
                                        MailGun Secret
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="MAILGUN_SECRET" value="{{env('MAILGUN_SECRET')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
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
    $(document).ready(function(){
        checkMailDriver();
    });
    function checkMailDriver(){
        if($(`select[name=MAIL_DRIVER]`).val() == 'mailgun'){
            $('#mailgun').show();
            $('#smtp').hide();
        }
        else{
            $('#smtp').show();
            $('#mailgun').hide();
        }
    }

</script>

@endsection