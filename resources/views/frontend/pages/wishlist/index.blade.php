@extends('frontend.layouts.master')

@section('content')
<!-- Breadcumb Area -->
<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Wishlist</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Wishlist</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<!-- Wishlist Table Area -->
<div class="wishlist-table section_padding_100 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-table wishlist-table">
                    <div class="table-responsive" id="wishlist_items">
                        @include('frontend.pages.wishlist.wishlist_items')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wishlist Table Area -->
@endsection

@section('scripts')

<script>
    $('.move-to-cart').on('click', function(e) {
      e.preventDefault();
      var rowId = $(this).data('id');
      var token = "{{ csrf_token() }}";
      var path = "{{ route('user.wishlist.move') }}";
  
      $.ajax({
        url: path,
        type: "POST",
        data: {
          _token: token,
          product_id: rowId,
        },
        beforeSend: function() {
          $(this).html('<i class="fas fa-spinner fa-spin"></i> Moving to cart...');
        },
        success: function(data) {
          if (data['status']) {
            $('body #cart_counter').html(data['cart_count']);
            $('body #wishlist_items').html(data['wishlist_items']);
            $('body #header-ajax').html(data['header-ajax']);
            swal({
              title: "Good job!",
              text: data['message'],
              icon: "success",
              button: "Ok!",
            });
          }
          else{
            swal({
              title: "Invalid adding",
              text: "try again!",
              icon: "warning",
              button: "Ok!",
            });
          }
        },
        error: function(err) {
          swal({
            title: "Error!",
            text: "Something went wrong!",
            icon: "error",
            button: "Ok!",
          });
        }
      });
    });
</script>

<script>
    $('.delete-from-wishlist').on('click', function(e) {
      e.preventDefault();
      var product_id = $(this).data('id');
      var token = "{{ csrf_token() }}";
      var path = "{{ route('user.wishlist.destroy',':product_id') }}".replace(':product_id', product_id);
  
      $.ajax({
        url: path,
        type: "DELETE",
        data: {
          _token: token,
          product_id: product_id,
        },
        beforeSend: function() {
          $(this).html('<i class="fas fa-spinner fa-spin"></i> Moving to cart...');
        },
        success: function(data) {
          if (data['status']) {
            $('body #cart_counter').html(data['cart_count']);
            $('body #wishlist_items').html(data['wishlist_items']);
            $('body #header-ajax').html(data['header-ajax']);
            swal({
              title: "Good job!",
              text: data['message'],
              icon: "success",
              button: "Ok!",
            });
          }
          else{
            swal({
              title: "Invalid removing",
              text: "try again!",
              icon: "warning",
              button: "Ok!",
            });
          }
        },
        error: function(err) {
          swal({
            title: "Error!",
            text: "Something went wrong!",
            icon: "error",
            button: "Ok!",
          });
        }
      });
    });
</script>

@endsection