<?php

namespace Tests\RequestFactories;

use Worksome\RequestFactories\Concerns\HasFactory;
use Worksome\RequestFactories\RequestFactory;

class SignUpFormRequestFactory extends RequestFactory
{
    use HasFactory;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'name'=>$this->faker->name,
            'password'=>$this->faker->password(8)

        ];
    }
}
