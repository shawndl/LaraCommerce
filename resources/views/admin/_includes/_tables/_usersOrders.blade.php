
<div class="page-header">
    <h1>Users Orders</h1>
    <h3>Orders for {{ $user->fullName() }}</h3>
</div>
@if($user->orders->count() > 0)
    <table class="table">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Items Ordered</th>
            <th>Shipped</th>
            <th>View</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user->orders as $order)
            <tr>
                <td class="table-element">{{ $order->id }}</td>
                <td class="table-element">{{ $user->fullName() }}</td>
                <td class="table-element">{{ $order->total }}</td>
                <td class="table-element">{{ $order->products->count() }}</td>
                <td class="table-element">{{ $order->shipped }}</td>
                <td><a class="btn btn-primary" href="">View Order</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <h4>There are no records for any addresses for this user</h4>
@endif