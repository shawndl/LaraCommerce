<div class="page-header">
    <h1>Users Addresses</h1>
    <h3>     Addresses for {{ $user->fullName() }}</h3>
</div>
@if($user->addresses->count() > 0)
<table class="table">
    <thead>
    <tr>
        <th>Street Address</th>
        <th>State</th>
        <th>City</th>
        <th>Postal Code</th>
    </tr>
    </thead>
    <tbody>
        @foreach($user->addresses as $address)
            <tr>
                <td class="table-element">{{ $address->address }}</td>
                <td class="table-element">{{ $address->state->abbreviation }}</td>
                <td class="table-element">{{ $address->city }}</td>
                <td class="table-element">{{ $address->postal_code }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <h4>There are no records for any addresses for this user</h4>
@endif