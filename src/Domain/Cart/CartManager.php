<?php


namespace Domain\Cart;


use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(protected CartIdentityStorageContract $identityStorage)
    {

    }

    private function storageData(string $id): array
    {
        $data = [
            'storage_id' => $id
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): Model|Builder
    {
        $cart = Cart::query()
            ->updateOrCreate([
                'storage_id' => $this->identityStorage->get()
            ], $this->storageData($this->identityStorage->get()));


        $cartItem = $cart->cartItems()->updateOrCreate([
            'product_id' => $product->getKey(),
            'string_option_values' => $this->stringedOptionValues($optionValues)
        ], [
            'price' => $product->price,
            'quantity' => DB::raw("quantity + $quantity"),
            'string_option_values' => $this->stringedOptionValues($optionValues)
        ]);

        $cartItem->optionValues()->sync($optionValues);

        return $cart;
    }

    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update(['quantity' => $quantity]);
    }

    public function delete(CartItem $item): void
    {
        $item->delete();
    }

    public function truncate(): void
    {
        $this->get()?->delete();

    }

    public function items()
    {
        if (!$this->get()){
            return collect([]);
        }

        return CartItem::query()
            ->with(['product','optionValues.option'])
            ->whereBelongsTo($this->get())
            ->get();

    }

    public function cartItems()
    {
        return $this->get()->cartItems ?? collect([]);

    }

    public function count():int
    {
        return $this->cartItems()->sum(function ($item){
            return $item->quantity;
        });
    }

    public function amount():Price
    {
        return Price::make(
            $this->cartItems()->sum(function ($item){
                return $item->amount->raw();
            })
        );
    }

    public function get()
    {
        return Cart::query()
            ->with('cartItems')
            ->where('storage_id',$this->identityStorage->get())
            ->when(auth()->check(), fn(Builder $query)=> $query->orWhere('user_id',auth()->id()))
            ->first() ?? false;
    }
}
