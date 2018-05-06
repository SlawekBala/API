Twoje zamówienie:<br>
<hr>
@foreach($order->orderItems as $item)
    {{$item->product->name}}<br>
@endforeach