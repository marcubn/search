<?php

namespace Tests\Feature;

use Tests\TestCase;

class ListProductsApiTest extends TestCase
{

    /**
     * @test
     */
    public function api_fails_without_token()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(401);
    }

    /** @test */
    public function api_success_with_token()
    {
        $response = $this->get('/api/products?api_token='.env('API_TOKEN'));

        $response->assertStatus(200);
    }

    /** @test */
    public function api_get_all_required_data()
    {
        $response = $this->get('/api/products?api_token='.env('API_TOKEN'));
        // probably a better way to match this but i have a brain freeze
        $this->assertDatabaseCount('products', count(json_decode($response->content())));
    }

    /** @test */
    public function api_check_product_response()
    {
        $response = $this->get('/api/products?api_token='.env('API_TOKEN'));
        $response->assertJsonStructure([
            [
                'id',
                'product_id',
                'name',
                'description',
                'brand',
                'price',
                'stock',
                'created_at',
                'updated_at'
            ],
        ]);
    }
}
