<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;

class AdminTest extends TestCase {
    use RefreshDatabase;

    public function test_authorized_admin_can_access_index_page() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/admin');

        $response->assertViewIs('admin.index');
    }
    
    public function test_unauthorized_admin_cannot_access_index_page_and_is_redirected() {
        $response = $this
            ->followingRedirects()
            ->get('/admin');

        $response->assertViewIs('admin.login');
    }

    public function test_authorized_customer_cannot_access_index_page_and_is_redirected() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/admin');

        $response->assertViewIs('admin.login');
    }
    
    public function test_authorized_admin_can_view_products() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);
        $products = Product::factory()->create();

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/admin/products');
        
        $response->assertViewIs('admin.products');
        $response->assertSee(array_column($products->toArray(), 'id'));
    }

    public function test_unauthorized_admin_cannot_view_products() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);
        $products = Product::factory()->create();

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/admin/products');
        
        $response->assertViewIs('admin.login');
    }

    public function test_authorized_admin_can_add_product() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);
        Storage::fake('product_images');

        $product_name = 'Product Name';
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post('/admin/products', [
                'name' => $product_name,
                'color' => 'Red',
                'type' => 'Short Sleeve',
                'size' => 'Large',
                'price' => 23.99,
                'stock' => 0,
                'product_image' => UploadedFile::fake()->image('avatar.jpg')
            ]);
        
        $response->assertOk();
        $response->assertViewIs('admin.products');

        $this->assertDatabaseHas('products', [
            'name' => $product_name
        ]);
        
        $product = Product::first();
        
        // We can't perfectly test for the image name because the name is suffixed with a timestamp
        // Therefore 'avatar.jpg' becomes 'avatar_168737463.jgp
        // $this->assertEquals($product->image, 'avater.jpg');

        // But we can check if a subset of the name exists
        $this->assertTrue(Str::contains($product->image, ['avatar', '.jpg']));
    }

    public function test_unauthorized_admin_cannot_add_product() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);
        Storage::fake('product_images');

        $product_name = 'Product Name';
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post('/admin/products', [
                'name' => $product_name,
                'color' => 'Red',
                'type' => 'Short Sleeve',
                'size' => 'Large',
                'price' => 23.99,
                'stock' => 0,
                'product_image' => UploadedFile::fake()->image('avatar.jpg')
            ]);
        
        $response->assertViewIs('admin.login');

        $this->assertDatabaseMissing('products', [
            'name' => $product_name
        ]);
    }

    public function test_authorized_admin_can_edit_product_without_image() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);
        $product = Product::factory()->create([
            'name' => 'Old Name'
        ]);

        $new_name = 'New Name';

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->put('/admin/products', [
                'id' => $product->id,
                'name' => $new_name,
                'color' => $product->color,
                'size' => $product->size,
                'type' => $product->type,
                'price' => $product->price,
                'stock' => $product->out_of_stock
            ]);
        
        $response->assertOk();
        $response->assertViewIs('admin.products');
        $product = $product->fresh();
        $this->assertEquals($product->name, $new_name);
    }
    
    public function test_unauthorized_admin_cannot_edit_product_without_image() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);
        $product = Product::factory()->create([
            'name' => 'Old Name'
        ]);

        $new_name = 'New Name';

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->put('/admin/products', [
                'id' => $product->id,
                'name' => $new_name,
                'color' => $product->color,
                'size' => $product->size,
                'type' => $product->type,
                'price' => $product->price,
                'stock' => $product->out_of_stock
            ]);
        
        $response->assertViewIs('admin.login');
        $product = $product->fresh();
        $this->assertNotEquals($product->name, $new_name);
    }
    
    public function test_authorized_admin_can_edit_product_with_image() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);
        $product = Product::factory()->create([
            'image' => 'stock.jpg'
        ]);

        Storage::fake('product_images');

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->put('/admin/products', [
                'id' => $product->id,
                'name' => $product->name,
                'color' => $product->color,
                'size' => $product->size,
                'type' => $product->type,
                'price' => $product->price,
                'stock' => $product->out_of_stock,
                'product_image' => UploadedFile::fake()->image('avatar.jpg')
            ]);
        
        $response->assertOk();
        $response->assertViewIs('admin.products');

        $product = $product->fresh();
        
        // We can't perfectly test for the image name because the name is suffixed with a timestamp
        // Therefore 'avatar.jpg' becomes 'avatar_168737463.jgp
        // $this->assertEquals($product->image, 'avater.jpg');

        // But we can check if a subset of the name exists
        $this->assertTrue(Str::contains($product->image, ['avatar', '.jpg']));
    }
    
    public function test_unauthorized_admin_cannot_edit_product_with_image() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);
        $product = Product::factory()->create([
            'image' => 'stock.jpg'
        ]);

        Storage::fake('product_images');

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->put('/admin/products', [
                'id' => $product->id,
                'name' => $product->name,
                'color' => $product->color,
                'size' => $product->size,
                'type' => $product->type,
                'price' => $product->price,
                'stock' => $product->out_of_stock,
                'product_image' => UploadedFile::fake()->image('avatar.jpg')
            ]);
        
        $response->assertViewIs('admin.login');

        $product = $product->fresh();
        
        // We can't perfectly test for the image name because the name is suffixed with a timestamp
        // Therefore 'avatar.jpg' becomes 'avatar_168737463.jgp
        // $this->assertEquals($product->image, 'avater.jpg');

        // But we can check if a subset of the name exists
        $this->assertFalse(Str::contains($product->image, ['avatar']));
    }

    public function test_authorized_admin_can_delete_product() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $product_name = 'Product name';

        $product = Product::factory()->create([
            'name'=> $product_name
        ]);
        
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->delete('/admin/products', [
                'id' => $product->id
            ]);
        
        $response->assertViewIs('admin.products');
        $this->assertDatabaseMissing('products', [
            'name' => $product_name
        ]);
    }
    
    public function test_unauthorized_admin_cannot_delete_product() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);

        $product_name = 'Product name';

        $product = Product::factory()->create([
            'name'=> $product_name
        ]);
        
        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->delete('/admin/products', [
                'id' => $product->id
            ]);
        
        $response->assertViewIs('admin.login');
        $this->assertDatabaseHas('products', [
            'name' => $product_name
        ]);
    }

    public function test_authorized_admin_can_view_orders() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);
        $order = Order::factory()->create([
            'user_id' => User::factory(),
        ]);

        $orderProduct = OrderProduct::factory()->create([
            'order_id' => $order->id,
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/admin/orders');

        $response->assertViewIs('admin.orders.index');
        $response->assertSee($order->id);
    }
    
    public function test_unauthorized_admin_cannot_view_orders() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);
        $order = Order::factory()->create([
            'user_id' => User::factory(),
        ]);

        $orderProduct = OrderProduct::factory()->create([
            'order_id' => $order->id,
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get('/admin/orders');

        $response->assertViewIs('admin.login');
    }
    
    public function test_authorized_admin_can_view_order_details() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);
        $order = Order::factory()->create([
            'user_id' => User::factory(),
        ]);

        $orderProduct = OrderProduct::factory()->create([
            'order_id' => $order->id,
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/orders/{$order->id}");

        $response->assertViewIs('admin.orders.show');
        $response->assertSee($order->address);
    }
    
    public function test_unauthorized_admin_cannot_view_order_details() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);
        $order = Order::factory()->create([
            'user_id' => User::factory(),
        ]);

        $orderProduct = OrderProduct::factory()->create([
            'order_id' => $order->id,
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/orders/{$order->id}");

        $response->assertViewIs('admin.login');
    }
    
    public function test_authorized_admin_can_view_customers() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create([]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/customer");

        $response->assertViewIs('admin.customer.index');
        $response->assertSee($anotherUser->name);
    }
    
    public function test_unauthorized_admin_cannot_view_customers() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);

        $anotherUser = User::factory()->create([]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/customer");

        $response->assertViewIs('admin.login');
    }
    
    public function test_authorized_admin_can_view_customer_details() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create([]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/customer/{$anotherUser->id}");

        $response->assertViewIs('admin.customer.show');
        $response->assertSee($anotherUser->name);
    }
    
    public function test_unauthorized_admin_cannot_view_customer_details() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);

        $anotherUser = User::factory()->create([]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/customer/{$anotherUser->id}");

        $response->assertViewIs('admin.login');
    }
    
    public function test_admin_cannot_view_another_admins_details() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create(['role' => 'ADMIN']);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->get("/admin/customer/{$anotherUser->id}");

        $response->assertViewIs('landing');
    }
    
    public function test_admin_cannot_upgrade_admin_to_admin() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create(['role'=> 'ADMIN']);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/admin/customer", ['id' => $anotherUser->id]);
        
        $response->assertViewIs('landing');
    }
    
    public function test_admin_cannot_upgrade_customer_with_items_in_cart_to_admin() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create(['role'=> 'CUSTOMER']);
        Cart::factory()->create([
            'user_id' => $anotherUser->id
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/admin/customer", ['id' => $anotherUser->id]);
        
        $response->assertViewIs('landing');
        $anotherUser = $anotherUser->fresh();
        $this->assertEquals($anotherUser->role, 'CUSTOMER');
    }
    
    public function test_admin_cannot_upgrade_customer_that_has_order_to_admin() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create(['role'=> 'CUSTOMER']);
        Order::factory()->create([
            'user_id' => $anotherUser->id
        ]);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/admin/customer", ['id' => $anotherUser->id]);
        
        $response->assertViewIs('landing');
        $anotherUser = $anotherUser->fresh();
        $this->assertEquals($anotherUser->role, 'CUSTOMER');
    }
    
    public function test_authorized_admin_can_upgrade_customer_with_no_cart_items_or_order_to_admin() {
        $user = User::factory()->create([
            'role' => 'ADMIN'
        ]);

        $anotherUser = User::factory()->create(['role'=> 'CUSTOMER']);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/admin/customer", ['id' => $anotherUser->id]);
        
        $response->assertViewIs('admin.customer.index');
        $anotherUser = $anotherUser->fresh();
        $this->assertEquals($anotherUser->role, 'ADMIN');
    }
    
    public function test_unauthorized_admin_cannot_upgrade_customer_with_no_cart_items_or_order_to_admin() {
        $user = User::factory()->create([
            'role' => 'CUSTOMER'
        ]);

        $anotherUser = User::factory()->create(['role'=> 'CUSTOMER']);

        $response = $this
            ->followingRedirects()
            ->actingAs($user)
            ->post("/admin/customer", ['id' => $anotherUser->id]);
        
        $response->assertViewIs('admin.login');
        $anotherUser = $anotherUser->fresh();
        $this->assertEquals($anotherUser->role, 'CUSTOMER');
    }
}