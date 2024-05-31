<nav>
    <ul>
        @if(\Illuminate\Support\Facades\Auth::check())
            <li><a href="/profile">Профиль пользователя</a></li>
        @else
            <li><a href="/login">Залогиниться</a></li>
            <li><a href="/register">Зарегистрироваться</a></li>
        @endif
        <li><a href="/books">Список книг</a></li>
        <li><a href="/authors">Список авторов</a></li>
    </ul>
</nav>
