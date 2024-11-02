@extends('frontend.layouts.master')

@section('content')

 <!-- Breadcumb Area -->
 <div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Contact</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<!-- Message Now Area -->
<div class="message_now_area section_padding_100" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="popular_section_heading mb-50 text-center">
                    <h5 class="mb-3">Stay Conneted with us</h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="single-contact-info mb-30">
                    <i class="icofont-phone"></i>
                    <p>{{$settings->phone}}</p>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="single-contact-info mb-30">
                    <i class="icofont-ui-email"></i>
                    <p>{{$settings->email}}</p>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="single-contact-info mb-30">
                    <i class="icofont-map"></i>
                    <p>{{$settings->address}}</p>
                </div>
            </div>

            <div class="col-12">
                <div class="contact_from mb-50">
                    <form action="{{route('contact.us.submit')}}" method="POST" id="main_contact_form">
                        @csrf
                        <div class="contact_input_area">
                            <div id="success_fail_info"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="f_name" id="f-name" placeholder="First Name" required value="{{old('f_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="l_name" id="l-name" placeholder="Last Name" required value="{{old('l_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Your E-mail" required value="{{old('email')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required value="{{old('subject_name')}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Your Message *" required>{{old('message')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Message Now Area -->

@endsection
