@extends('layouts.app')

@section('title','Оформление заказа')


@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{route('home')}}" class="text-body hover:text-pink text-xs">Главная</a></li>
                <li><a href="{{route('cart')}}" class="text-body hover:text-pink text-xs">Корзина покупателя</a></li>
                <li><span class="text-body text-xs">Оформление заказа</span></li>
            </ul>

            <section>
                <!-- Section heading -->
                <h1 class="mb-8 text-lg lg:text-[42px] font-black">Оформление заказа</h1>

                <!-- Orders list -->
                <div class="w-full space-y-4 text-white text-sm text-left">

                    <form action="{{route('order.handle')}}" method="POST"
                          class="grid xl:grid-cols-3 items-start gap-6 2xl:gap-8 mt-12">
                        @csrf

                        <div class="p-6 2xl:gap-8 rounded-[20px] bg-card">
                            <h3 class="mb-6 text-md 2xl:text-lg font-bold">Контактная информация</h3>
                            <div class="space-y-3">
                                <x-forms.text-input
                                    name="customer[first_name]"
                                    type="text"
                                    placeholder="Имя"
                                    value="{{old('customer.first_name')}}"
                                    :isError="$errors->has('customer.first_name')"
                                >
                                </x-forms.text-input>

                                @error('customer.first_name')
                                <x-forms.error>
                                    {{$message}}
                                </x-forms.error>
                                @enderror

                                <x-forms.text-input
                                    name="customer[last_name]"
                                    type="text"
                                    placeholder="Фамилия"
                                    value="{{old('customer.last_name')}}"
                                    :isError="$errors->has('customer.last_name')"
                                >
                                </x-forms.text-input>

                                @error('customer.last_name')
                                <x-forms.error>
                                    {{$message}}
                                </x-forms.error>
                                @enderror

                                <x-forms.text-input
                                    name="customer[email]"
                                    type="text"
                                    placeholder="E-mail"
                                    value="{{old('customer.email')}}"
                                    :isError="$errors->has('customer.email')"
                                >
                                </x-forms.text-input>

                                @error('customer.email')
                                <x-forms.error>
                                    {{$message}}
                                </x-forms.error>
                                @enderror

                                <x-forms.text-input
                                    name="customer[phone]"
                                    type="text"
                                    placeholder="Телефон"
                                    value="{{old('customer.phone')}}"
                                    :isError="$errors->has('customer.phone')"
                                >
                                </x-forms.text-input>

                                @error('customer.phone')
                                <x-forms.error>
                                    {{$message}}
                                </x-forms.error>
                                @enderror

                                @guest
                                    <div x-data="{createAccount:false}">
                                        <div class="py-3 text-body">Вы можете создать аккаунт посл оформления заказа
                                        </div>
                                        <div class="form-checkbox">
                                            <input type="checkbox"
                                                   name="create_account"
                                                   id="checkout-create-account"
                                                   value="1"
                                                {{--                                                   @checked(old('create_account'))--}}
                                            >
                                            <label for="checkout-create-account" class="form-checkbox-label"
                                                   @click="createAccount=!createAccount"></label>
                                        </div>

                                        <div
                                            x-show="createAccount"
                                            x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-out duration-150"
                                            x-transition:leave-start="opacity-0"
                                            x-transition:leave-end="opacity-100"
                                            class="mt-4 space-y-3"
                                        >
                                            <x-forms.text-input
                                                name="password"
                                                type="password"
                                                placeholder="Пароль"
                                                :isError="$errors->has('password')"
                                            >
                                            </x-forms.text-input>

                                            @error('password')
                                            <x-forms.error>
                                                {{$message}}
                                            </x-forms.error>
                                            @enderror

                                            <x-forms.text-input
                                                name="password_confirmation"
                                                type="password"
                                                placeholder="Пароль"
                                                :isError="$errors->has('password_confirmation')"
                                            >
                                            </x-forms.text-input>

                                            @error('password_confirmation')
                                            <x-forms.error>
                                                {{$message}}
                                            </x-forms.error>
                                            @enderror
                                        </div>
                                    </div>
                                @endguest
                            </div>
                        </div>

                        <!--  Shipping and payment  -->
                        <div class="space-y-6 2xl:space-y-8">
                            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Способ доставки</h3>
                                <div class="space-y-5">
                                    @foreach($deliveries as $delivery)
                                        <div class="space-y-3">
                                            <div class="form-radio">
                                                <input type="radio" name="delivery_type_id"
                                                       id="delivery-method-address-{{$delivery->id}}"
                                                       value="{{$delivery->id}}"
                                                       @checked($loop->first||old('delivery_id')===$delivery->id)
                                                >
                                                <label for="delivery-method-address-{{$delivery->id}}"
                                                       class="form-radio-label">
                                                    {{$delivery->title}}
                                                </label>
                                            </div>

                                            @if($delivery->with_address)
                                                <x-forms.text-input
                                                    name="customer[city]"
                                                    type="text"
                                                    placeholder="Город"
                                                    value="{{old('customer.city')}}"
                                                    :isError="$errors->has('customer.city')"
                                                >
                                                </x-forms.text-input>

                                                @error('customer.city')
                                                <x-forms.error>
                                                    {{$message}}
                                                </x-forms.error>
                                                @enderror

                                                <x-forms.text-input
                                                    name="customer[address]"
                                                    type="text"
                                                    placeholder="Адрес"
                                                    value="{{old('customer.address')}}"
                                                    :isError="$errors->has('customer.address')"
                                                >
                                                </x-forms.text-input>

                                                @error('customer.address')
                                                <x-forms.error>
                                                    {{$message}}
                                                </x-forms.error>
                                                @enderror

                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Метод оплаты</h3>
                                <div class="space-y-5">
                                    @foreach($payments as $payment)
                                            <div class="form-radio">
                                                <input type="radio" name="payment_method_id"
                                                       id="payment-method-{{$payment->id}}"
                                                       value="{{$payment->id}}"
                                                       @checked($loop->first||old('payment_method_id')===$payment->id)
                                                >
                                                <label for="payment-method-{{$payment->id}}"
                                                       class="form-radio-label">
                                                    {{$payment->title}}
                                                </label>
                                            </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                            <h3 class="mb-6 text-md 2xl:text-lg font-bold">Заказ</h3>
                            <table class="w-full border-spacing-y-3 text-body text-xxs text-left">
                                <thead class="text-[12px] text-body uppercase">
                                <tr>
                                    <th scope="col" class="pb-2 border-b border-body/60">Товар</th>
                                    <th scope="col" class="px-2 pb-2 border-b border-body/60">Кол-во</th>
                                    <th scope="col" class="px-2 pb-2 border-b border-body/60">Сумма</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td scope="row" class="pb-3 border-b border-body/10">
                                            <h4 class="font-bold">
                                                <a href="{{route('product',$item->product)}}"class="inline-block text-white hover:bg-card/20">
                                                    {{$item->product->title}}
                                                </a>
                                            </h4>

                                            @if($item->optionValues->isNotEmpty())
                                                <ul>
                                                    @foreach($item->optionValues as $value)
                                                         <li class="text-body">
                                                             {{$value->option->title}}:{{$value->title}}
                                                         </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{$item->quantity}}шт.</td>
                                        <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">{{$item->amount}}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <div class="text-xxs font-semibold text-right"> Всего: {{cart()->amount()}}</div>

                            <div class="mt-8">
                                <table class="w-full text-left">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-md 2xl:text-lg font-black">Итого:</th>
                                            <td  class="text-md 2xl:text-lg font-black">{{cart()->amount()}}</td>
                                        </tr>
                                    </tbody>

                                </table>
                                <button type="submit" class="w-full btn btn-pink">Оформить заказ</button>
                            </div>
                        </div>
                    </form>


                </div>
            </section>

        </div>
    </main>
@endsection
