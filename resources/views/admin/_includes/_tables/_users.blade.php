<div class="page-header">
    <h1>Users Page</h1>
</div>
<table class="table">
    <thead>
    <tr>
        <th>User Name</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Addresses</th>
        <th>Orders</th>
    </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <span class="table-element">{{ $user->username }}</span>
                </td>
                <td>
                    <span class="table-element">{{ $user->first_name }}</span>
                </td>
                <td>
                    <span class="table-element">{{ $user->last_name }}</span>
                </td>
                <td>
                    <span class="table-element">{{ $user->email }}</span>
                </td>
                <td>
                    <a href="{{ action('Admin\UsersController@addresses', ['user' => $user->id]) }}" class="btn btn-primary">Addresses</a>
                </td>
                <td>
                    <a href="{{ action('Admin\UsersController@orders', ['user' => $user->id]) }}" class="btn btn-primary">Orders</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="mid_center">
        {{ $users->links() }}
    </div>
</div><!-- /.row -->

