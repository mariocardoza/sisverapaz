<table rules="all">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
            <th>{{$user->username}}</th>
            <th>{{$user->email}}</th>
            </tr>
        @endforeach
    </tbody>
</table>