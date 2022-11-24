<nav class="2xl:flex gap-8">

    {{--СПОСОБ ДЛЯ КАСТОМИЗИРУЕГО МЕНЮ ЧЕРЕЗ БАЗУ--}}

    @foreach($menu->all() as $item)
        <a href="{{$item->link()}}" class="text-white hover:text-pink @if($item->isActive()) font-bold @endif">
            {{$item->label()}}
        </a>
    @endforeach

{{--    <a href="{{route('home')}}" class="text-white hover:text-pink font-bold">Главная</a>--}}
{{--    <a href="{{route('catalog')}}" class="text-white hover:text-pink font-bold">Каталог товаров</a>--}}
{{--    <a href="#" class="text-white hover:text-pink font-bold">Корзина</a>--}}
</nav>
