<?php

namespace App\Jobs\Checkout;

use App\Events\Checkout\SaleCreated;
use App\File;
use App\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file, $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file, $email)
    {
        $this->file = $file;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sale = new Sale;

        $sale->fill([
            'identifier' => uniqid(true),
            'buyer_email' => $this->email,
            'sale_price' => $this->file->price,
            'sale_commission' => $this->file->calculateCommission(),
        ]);

        $sale->file()->associate($this->file);
        $sale->user()->associate($this->file->user);

        $sale->save();

        event(new SaleCreated($sale));
    }
}
