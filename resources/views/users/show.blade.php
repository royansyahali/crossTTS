<ul>
    @foreach ($user->puzzles as $puzzle)
    <li>{{$puzzle->name}}</li>
    @endforeach
</ul>