<?php

namespace Tests\Feature;

use Tests\TestCase;

class RemoveProductApiTest extends TestCase
{
    protected $product;

    protected $products;

    protected function setUp(): void
    {
        parent::setUp();
        $response = $this->get('/api/products?api_token=' . env('API_TOKEN'));
        $this->products = $array = json_decode($response->getContent());
        $this->product = reset($array);
    }

    /** @test */
    public function api_success_with_token()
    {
        $response = $this->delete('/api/products/'.$this->product->id);
        $response->assertStatus(204);
        $this->assertDatabaseCount('products', count($this->products) -1);
    }
}
