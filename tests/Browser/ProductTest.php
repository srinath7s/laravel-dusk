<?php

namespace Tests\Browser;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTest extends DuskTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        \App\Models\Product::truncate();
    }

    public function testCanCreateProduct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                ->type('name', 'Test Product')
                ->type('description', 'This is a test product.')
                ->type('price', '19.99')
                ->press('Save')
                ->assertPathIs('/products')
                ->assertSee('Test Product');
        });

        // Verify the product was created in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 19.99 // This must match exactly with the database value
        ]);
    }

    public function test_validation_errors_on_create()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                ->press('Save')
                ->assertSee('The name field is required.')
                ->assertSee('The description field is required.')
                ->assertSee('The price field is required.');
        });
    }

    public function test_can_view_products()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                ->assertSee('All Products');
        });
    }

    public function test_can_view_single_product()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit("/products/{$product->id}")
                ->assertSee($product->name)
                ->assertSee($product->description);
        });
    }

    public function testCanUpdateProduct()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit("/products/{$product->id}/edit")
                ->type('name', 'Updated Product Name')
                ->press('Update')
                ->assertPathIs('/products')
                ->assertSee('Updated Product Name');
        });
    }

    public function testValidationErrorsOnUpdate()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit("/products/{$product->id}/edit")
                ->type('name', '')
                ->press('Update')
                ->assertSee('The name field is required.');
        });
    }

    public function testCanDeleteProduct()
    {
        $this->browse(function (Browser $browser) {
            $product = Product::factory()->create();
    
            $browser->visit(route('products.index')) 
                    ->assertSee($product->name)
                    ->press('@delete-product-' . $product->id) 
                    ->waitForText('Product deleted successfully.') 
                    ->assertDontSee($product->name);
        });
    }
}
