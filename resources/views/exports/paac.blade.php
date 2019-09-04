<table rules="all">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <th>{{$user->username}}</th>
                <th>{{$user->email}}</th>
            </tr>
        @endforeach
    </tbody>
</table>