@php
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
$wishlist_items = Cart::instance('wishlist')->content();
@endphp
@if($wishlist_items->count()>0)
<table class="table table-bordered mb-30">
    <thead>
        <tr>
            <th scope="col"><i class="icofont-ui-delete"></i></th>
            <th scope="col">Image</th>
            <th scope="col">Product</th>
            <th scope="col">Unit Price</th>
            <th scope="col">Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($wishlist_items as $item)
        <tr>
            <th scope="row">
                <i class="icofont-close delete-from-wishlist" data-id="{{$item->rowId}}"></i>
            </th>
            <td>
                <img src="{{$item->model->images->first()->url}}" alt="Product">
            </td>
            <td>
                <a href="{{route('products.details',$item->model->slug)}}">{{$item->name}}</a>
            </td>
            <td>${{$item->price}}</td>
            <td><a href="#"  data-id="{{$item->rowId}}" class="move-to-cart btn btn-primary btn-sm">Add to Cart</a></td>
        </tr>
        @endforeach
    </tbody>
</table>                          
@else
<p class="text-center">You don't have any proudcts in your wishlist D:</p>
@endif
