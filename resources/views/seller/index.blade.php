@extends('seller.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">eCommerce</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <h3>{{count($vedorCategories)}} <i class="fas fa-sitemap float-right"></i></h3>
                        <span>Total Categories</span>                            
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                        <div class="progress-bar" data-transitiongoal="64"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <h3>{{count($vendorProducts)}} <i class="fas fa-suitcase float-right"></i></h3>
                        <span>Total Products</span>        
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar" data-transitiongoal="68"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <h3>{{count($vendorCustomers)}} <i class="icon-user-follow float-right"></i></h3>
                        <span>New Customers</span>                    
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                        <div class="progress-bar" data-transitiongoal="67"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <h3>{{count($vendorOrderedItems)}} <i class="fas fa-money-bill-alt float-right"></i></h3>
                        <span>Net Profit</span>       
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                        <div class="progress-bar" data-transitiongoal="89"></div>
                    </div>
                </div>
            </div>
            
        </div>
        


        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Recent Orders</h2>
                        <ul class="header-dropdown">
                            <a href="" class="btn btn-success btn-sm">view all</a>
                        </ul>
                    </div>
                    <div class="body">
                        @if(count($vendorOrderedItems)>0)
                            <div class="table-responsive">
                                <table class="table  table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">S.N</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Payment method</th>
                                            <th>payment status</th>
                                            <th>Total</th>
                                            <th>Condition</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->user->full_name}}</td>
                                            <td>{{$item->user->email}}</td>
                                            <td>{{$item->payment_method}}</td>
                                            <td>{{ucfirst($item->payment_status)}}</td>
                                            <td>${{$item->total}}</td>
                                            @php
                                                $badge = match($item->condition) {
                                                  'pending' => 'badge-info',
                                                  'processing' => 'badge-primary',
                                                  'delivered' => 'badge-success',
                                                   default => 'badge-danger',
                                                 };
                                            @endphp
                                            <td><span class="badge {{$badge}}">{{$item->condition}}</span></td>
                                            <td>
                                                <a href="{{route('admin.orders.show',$item->id)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary mr-2" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                <form  action="{{route('admin.orders.destroy',$item->id)}}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$item->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                           <p>No orders found!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection