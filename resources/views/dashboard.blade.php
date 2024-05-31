<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Вы вошли в систему.") }}<br>
                    <hr>
                    <ul>
                        <li><a href="/books">Вернуться на страницу "Список книг"</a></li>
                        <li><a href="/authors">Вернуться на страницу "Список авторов"</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
