<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Tests\TestCase;

class AddProductApiTest extends TestCase
{

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * For the moment the api will return 500 if there is no token (tries to do a redirect to login page) so i will test this
     * @todo To be fixed later on
     * @test
     */
    public function api_fails_without_token()
    {
        $response = $this->post('/api/products');

        $response->assertStatus(500);
    }

    /** @test */
    public function api_success_with_token()
    {
        $response = $this->post('/api/products', [
            "api_token" => env('API_TOKEN'),
            "product_id" => $this->faker->randomNumber(),
            "name" => "bobby",
            "description" => "just a test product",
            "brand" => "apple",
            "price" => 300,
            "stock" => 4
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
                'product_id',
                'name',
                'description',
                'brand',
                'price',
                'stock',
                'created_at',
                'updated_at',
                'id',
        ]);
    }

    /** @test */
    public function api_store_correct_data()
    {
        // get all products
        $response = $this->get('/api/products?api_token='.env('API_TOKEN'));

        // post one more product
        $this->post('/api/products', [
            "api_token" => env('API_TOKEN'),
            "product_id" => $this->faker->randomNumber(),
            "name" => "bobby",
            "description" => "just a test product",
            "brand" => "apple",
            "price" => 300,
            "stock" => 4
        ]);

        // see if the number matches
        $this->assertDatabaseCount('products', count(json_decode($response->content())) + 1);
    }
}
