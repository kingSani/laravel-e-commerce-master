<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_authorized_user_can_view_cart() {
        $user = User::factory()->create();
        $cart = Cart::factory()->count(5)->create([
            'user_id'=>$user->id
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/cart');
        
        $response->assertOk();
        $response->assertSee(array_column($cart->toArray(), 'content'));
    }

    public function test_unauthorized_user_cannot_view_cart_and_is_redirected() {
        $response = $this
            ->followingRedirects()
            ->get('/cart');

        $response->assertViewIs('auth.login');
    }

    public function test_user_can_view_all_products() {
        $products = Product::factory()->count(5)->create();

        $response = $this
            ->followingRedirects()
            ->get('/products');

        $response->assertOk();
        $response->assertSee(array_column($products->toArray(), 'name'));
    }
    
    public function test_user_can_view_product_in_stock() {
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $response = $this
            ->followingRedirects()
            ->get("/products/{$product->id}");

        $response->assertOk();
        $response->assertSee($product->name);
    }
    
    public function test_user_cannot_view_product_out_of_stock() {
        $product = Product::factory()->create([
            'out_of_stock' => 1 // Yes
        ]);

        $response = $this
            ->followingRedirects()
            ->get("/products/{$product->id}");

        $response->assertViewIs("products.index");
    }

    public function test_unauthorized_user_cannot_add_product_to_cart_and_is_redirected() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $response = $this
            ->followingRedirects()
            ->post("/products/{$product->id}");

        $user = $user->fresh();
        $this->assertEquals(count($user->cart), 0);
        $response->assertViewIs('auth.login');
    }

    public function test_authorized_user_can_add_product_to_cart() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/products/{$product->id}");

        $user = $user->fresh();
        $this->assertEquals($user->cart[0]->product_id, $product->id);

    }

    public function test_authorized_user_can_add_cart_quantity() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);
        
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/products/{$product->id}");
        
        $cart = $cart->fresh();
        $this->assertEquals($cart->quantity, 2);
    }
    

    public function test_unauthorized_user_cannot_add_cart_quantity_and_is_redirected() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);
        
        
        $response = $this
            ->followingRedirects()
            ->post("/products/{$product->id}");
        
        $cart = $cart->fresh();
        $this->assertEquals($cart->quantity, 1);
        $response->assertViewIs('auth.login');
    }
    
    public function test_authorized_user_can_reduce_cart_quantity() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
        
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->delete("/products/{$product->id}");
        
        $cart = $cart->fresh();
        $this->assertEquals($cart->quantity, 1);
    }
    
    public function test_unauthorized_user_cannot_reduce_cart_quantity_and_is_redirected() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);
        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
        
        $response = $this
            ->followingRedirects()
            ->delete("/products/{$product->id}");
        
        $cart = $cart->fresh();
        $this->assertEquals($cart->quantity, 2);
        $response->assertViewIs('auth.login');
    }
    
    public function test_authorized_user_can_remove_product_from_cart() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->delete("/products/{$product->id}");

        $user = $user->fresh();
        $this->assertEquals(count($user->cart), 0);

    }
    
    public function test_unauthorized_user_cannot_remove_product_from_cart_and_is_redirected() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response = $this
            ->followingRedirects()
            ->delete("/products/{$product->id}");

        $user = $user->fresh();
        $this->assertEquals(count($user->cart), 1);
        $response->assertViewIs('auth.login');

    }

    public function test_authorized_user_can_view_profile() {
        $user = User::factory()->create();

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/profile');

        $response->assertViewIs('profile.index');
    }

    public function test_unauthorized_user_cannot_view_profile_and_is_redirected() {
        $response = $this
            ->followingRedirects()
            ->get('/profile');

        $response->assertViewIs('auth.login');
    }

    public function test_user_can_search_for_products() {
        $products = Product::factory()->count(5)->create();
        $response = $this->json("get", "/api/products");
        $response->assertStatus(200);

        // Add assertion to check response
    }

    public function test_authorized_user_with_items_in_cart_can_view_checkout() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/cart/checkout');
        
        $response->assertViewIs('cart.checkout');
    }

    public function test_authorized_user_without_items_in_cart_cannot_view_checkout() {
        $user = User::factory()->create();
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/cart/checkout');

        $response->assertViewIs('products.index');
    }
    
    public function test_unauthorized_user_cannot_view_checkout_and_is_redirected() {
        $response = $this
            ->followingRedirects()
            ->get('/cart/checkout');

        $response->assertViewIs('auth.login');
    }
    
    public function test_authorized_user_with_items_in_cart_can_checkout() {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'out_of_stock' => 0 // No
        ]);

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post('/cart/checkout', [
                'address' => 'test address'
            ]);

        $response->assertViewIs('profile.index');
    }
    
    public function test_unauthorized_user_cannot_checkout_and_is_redirected() {
        $response = $this
            ->followingRedirects()
            ->post('/cart/checkout', [
                'address' => 'i am unauthorized'
            ]);

        $response->assertViewIs('auth.login');
    }

    public function test_authorized_user_can_view_orders_in_profile_page_after_checkout () {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
        ]);

        $orderProduct = OrderProduct::factory()->create([
            'order_id' => $order->id,
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/profile');

        $response->assertViewIs('profile.index');
        // add assertion to check equality of orders
    }
}
