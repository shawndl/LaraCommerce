<div class="page-header">
    <h1>Orders Page</h1>
</div>
<table class="table">
    <thead>
    <tr>
        <th>Order ID</th>
        <th>User</th>
        <th>Total</th>
        <th>Items Ordered</th>
        <th>View</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>
                <span class="table-element">{{ $order->id }}</span>
            </td>
            <td>
                <span class="table-element">{{ $order->user->fullName() }}</span>
            </td>
            <td>
                <span class="table-element">{{ $order->total }}</span>
            </td>
            <td>
                <span class="table-element">{{ $order->products->count() }}</span>
            </td>
            <td>
                <a class="btn btn-primary" href="{{ action('Admin\OrdersController@show', ['id' => $order->id]) }}">View</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
    <div class="mid_center">
        {{ $orders->links() }}
    </div>
</div><!-- /.row -->
