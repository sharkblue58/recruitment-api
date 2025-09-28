<?php
namespace App\Services;
use Stripe\StripeClient;

class StripeService {
    public StripeClient $client;
    public function __construct(){
        $this->client = new StripeClient(config('services.stripe.secret'));
    }
    public function createProductAndPrice(string $name, int $amount, string $currency='usd', string $interval='month', array $productMetadata = []){
        $product = $this->client->products->create([
            'name' => $name,
            'metadata' => $productMetadata,
        ]);
        $price = $this->client->prices->create([
            'unit_amount' => $amount*100,
            'currency' => $currency,
            'recurring' => ['interval' => $interval],
            'product' => $product->id,
        ]);
        return ['product' => $product, 'price' => $price];
    }

    public function createRefund(string $chargeId, int $amount=0, array $params = []){
        $data = array_merge(['charge' => $chargeId], $params);
        if($amount>0) $data['amount'] = $amount;
        return $this->client->refunds->create($data);
    }

    
}
