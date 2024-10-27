<!doctype html>
<html lang="en">

<head>

    @include('frontend.layouts.head')

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Header Area -->
   <header class="header_area" id="header-ajax">
    @include('frontend.layouts.header')
   </header>

    <!-- Header Area End -->

    @yield('content')

    <!-- Footer Area -->
    @include('frontend.layouts.footer')
    <!-- Footer Area  End-->

    @include('frontend.layouts.scripts')

    <script>
        $(document).on('click','.delete-from-cart',function(e){
            e.preventDefault();
            var product_id = $(this).data('id');    
            // alert(product_id);
    
            var token = "{{csrf_token()}}";
            var path = "{{ route('user.cart.destroy', ':product_id') }}".replace(':product_id', product_id);
    
            $.ajax({
                url:path,
                type:"DELETE",
                data:{
                    '_token':token,
                    'product_id':product_id,
                },
                success:function(data){
                    if(data['status']){
                        $('body #header-ajax').html(data['header']);
                        swal({
                        title: "Good job!",
                        text: data['message'],
                        icon: "success",
                        button: "Ok!",
                        });
                    }
                },
                error:function(err){
                    console.log(err);
                }
            });
        });
    </script>

    {{-- Autocomplete --}}

    <script>
        $(document).ready(function() {
            var path = "{{ route('products.autosearch') }}";
            $('#search_text').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                },
                minLength: 1
            });
        });
    </script>

    <script>
        function change_currency(currency_code){
            // alert(currency_code);
            $.ajax({
                type:'POST',
                url: '{{route('currencies.load')}}',
                data: {
                    '_token':'{{csrf_token()}}',
                    'currency_code':currency_code
                },
                success:function(response){
                    if(response['status']){
                        location.reload();
                    }
                    else{
                        alert('server error');
                    }
                }
            });
        }
    </script>

</body>

</html>