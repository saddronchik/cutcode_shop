<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{

    protected $signature = 'shop:refresh';

    protected $description = 'Refresh';

    public function handle()
    {
        if(app()->isProduction()){
            return self::FAILURE;
        }

        //при кешировании на главной странице остаются прошлые записи

        $this->call('cache:clear');

        Storage::deleteDirectory('public/images/products');
        Storage::deleteDirectory('public/images/brands');

        $this->call('migrate:fresh',[
            '--seed'=>true
        ]);



        return self::SUCCESS;
    }
}
