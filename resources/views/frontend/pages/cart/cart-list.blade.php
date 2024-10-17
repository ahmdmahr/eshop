<table class="table table-bordered mb-30">
    <thead>
        <tr>
            <th scope="col"><i class="icofont-ui-delete"></i></th>
            <th scope="col">Image</th>
            <th scope="col">Product</th>
            <th scope="col">Unit Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            use App\Models\Product;
            use Gloudemans\Shoppingcart\Facades\Cart;
            $cart_items = Cart::instance('shopping')->content();
        @endphp
        @foreach ($cart_items as $item)
            
        <tr>
            <th scope="row">
                <i class="icofont-close delete-from-cart" data-id="{{$item->rowId}}"></i>
            </th>
            <td>
                <img src="{{$item->model->images->first()->url}}" alt="Product">
            </td>
            <td>
                <a href="{{route('products.details',$item->model->slug)}}">{{$item->name}}</a>
            </td>
            <td>${{$item->price}}</td>
            <td>
                <div class="quantity">
                    <input type="number" data-id="{{$item->rowId}}" class="qty-text" id="qty-input-{{$item->rowId}}" step="1" min="1" max="99" name="quantity" value="{{$item->qty}}">
                    <input type="hidden" data-id="{{$item->rowId}}" data-product-stock="{{$item->model->stock}}" id="update-cart-{{$item->rowId}}">
                </div>
            </td>
            <td>${{$item->subtotal()}}</td>
        </tr>

        @endforeach
    </tbody>
</table>