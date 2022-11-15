<?php

namespace Services;


use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Tests\TestCase;
use Throwable;

class TelegramBotApiTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws Telegram\Exceptions\TelegramBotApiException
     */
    public function it_send_message_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST.'*'=>Http::response(['ok'=>true],200)
        ]);

        $result = TelegramBotApi::sendMessage('',1,'Testing');

        $this->assertTrue($result);
    }

    /**
     * @test
     * @return void
     */
    public function it_send_message_success_by_fake_instance():void
    {
        TelegramBotApi::fake()
            ->returnTrue();

        $result = app(TelegramBotApiContract::class)::sendMessage('',1,'Testing');

        $this->assertTrue($result);
    }


}
