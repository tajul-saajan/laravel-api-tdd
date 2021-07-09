<?php

namespace Tests\Feature\Http\Controllers\Api;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_create_a_product()
    {
        $faker = Factory::create();
        // when
        $response = $this->json('POST','/api/products', [
            'name' => $name = $faker->company(),
            'slug' => Str::slug($name),
            'price' => $price = random_int(10,100),
        ]);

        // then
        $response->assertJsonStructure(['name', 'slug', 'price', 'created_at'])
            ->assertJson([
                'name'=>$name,
                'slug'=> Str::slug($name),
                'price'=>$price
            ])
            ->assertStatus(201);
        $this->assertDatabaseHas('products',[
            'name'=> $name,
            'slug' => Str::slug($name),
            'price' => $price,
        ]);
    }
}
