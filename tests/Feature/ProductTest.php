<?php

namespace Tests\Feature;

use App\Type;
use App\Unit;
use App\User;
use App\Product;
use Carbon\Carbon;
use Tests\TestCase;
use App\ProductType;
use App\Classification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }
    /** @test */
    public function a_unauthorized_user_will_be_redirected_to_login(){
        $response = $this->post('/api/products',array_merge($this->data(),['api_token'=>'']));
        $response->assertRedirect('/login');
        $this->assertCount(0,Product::all());
    }
    /** @test */
    public function an_authenticated_user_can_add_product(){
        $this->withoutExceptionHandling();
        $this->post('/api/products',$this->data());
        $product = Product::first();
        $this->assertEquals('Test description',$product->description);
        $this->assertEquals('100.00',$product->price);
        $this->assertEquals('1000',$product->quantity);
        $this->assertEquals('1',$product->unit_id);
        $this->assertEquals('1',$product->user_id);
        $this->assertEquals('small',$product->size);
        $this->assertEquals('11111',$product->barcode);
        $this->assertEquals('05-14-1990',$product->expiration->format('m-d-Y'));
    }
    /** @test */
    public function fields_are_required(){
        collect(['description','price','quantity'])->each(function($field){
            $response = $this->post('/api/products',array_merge($this->data(),[$field => '']));
            $response->assertSessionHasErrors($field);
            $this->assertCount(0,Product::all());
        });
    }
    /** @test */
    public function expiration_date_is_properly_stored(){
        $response = $this->post('/api/products',$this->data());
        $this->assertCount(1,Product::all());
        $this->assertInstanceOf(Carbon::class,Product::first()->expiration);
        $this->assertEquals('05-14-1990',Product::first()->expiration->format('m-d-Y'));
    }
    /** @test */
    public function an_authorized_user_can_retreive_product(){
        $product = factory(Product::class)->create();
        $response = $this->get('/api/products/' . $product->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'unit_id'=>$product->unit_id,
            'user_id'=>$product->user_id,
            'barcode'=>$product->barcode,
            'description'=>$product->description,
            'price'=>$product->price,
            'quantity'=>$product->quantity,
            'expiration'=>$product->expiration,
            'size'=>$product->size,
        ]);
    }
    /** @test */
    public function a_product_can_be_patched(){
        $product = factory(Product::class)->create();
        $response = $this->patch('/api/products/' . $product->id, $this->data());
        $product = $product->first();
        $this->assertEquals('Test description',$product->description);
        $this->assertEquals('100.00',$product->price);
        $this->assertEquals('1000',$product->quantity);
        $this->assertEquals('1',$product->unit_id);
        $this->assertEquals('1',$product->user_id);
        $this->assertEquals('small',$product->size);
        $this->assertEquals('11111',$product->barcode);
        $this->assertEquals('05-14-1990',$product->expiration->format('m-d-Y'));
    }
    /** @test */
    public function an_authorized_user_can_delete_product(){
        $product = factory(Product::class)->create();
        $response = $this->delete('/api/products/' . $product->id . '?api_token=' . $this->user->api_token);
        $this->assertCount(0,Product::all());
    }
    private function data(){
        return [
            'unit_id'=>1,
            'user_id'=>1,
            'type_id'=>1,
            'class_id'=>1,
            'supplier_price'=>100.00,
            'barcode'=>11111,
            'description'=>'Test description',
            'price' => 100.00,
            'quantity' => 1000,
            'expiration' => '05/14/1990',
            'size'=>'small',
            'api_token' => $this->user->api_token,
        ];
    }
    /***** test for classification */

    /** @test */
    public function a_classification_can_be_added(){
        $this->withoutExceptionHandling();
        $class = $this->post('/api/classification',['name'=>'class name']);
        $class = Classification::first();
        $this->assertEquals('class name',$class->name);
    }
    /** @test */
    public function a_classification_can_be_patch(){
        $this->withoutExceptionHandling();
        $class = factory(Classification::class)->create();
        $response = $this->patch('/api/classification/' . $class->id,['name'=>'Edited Name']);
        $class = $class->first();
        $this->assertEquals('Edited Name',$class->name);
    }
    /** @test */
    public function a_classification_can_be_deleted(){
        $this->withoutExceptionHandling();
        $class = factory(Classification::class)->create();
        $this->delete('/api/classification/' . $class->id);
        $this->assertCount(0,Classification::all());
    }
    /** @test */
    public function a_type_can_be_added(){
        $this->withoutExceptionHandling();
        $this->post('/api/product_type',['name'=>'type test']);
        $type = ProductType::first();
        $this->assertEquals('type test',$type->name);
    }
    /** @test */
    public function a_type_can_be_patch(){
        $this->withoutExceptionHandling();
        $type = factory(ProductType::class)->create();
        $this->patch('/api/product_type/'.$type->id,['name'=>'Edited name']);
        $type = ProductType::first();
        $this->assertEquals('Edited name', $type->name);
    }
    /** @test */
    public function a_type_can_be_deleted(){
        $this->withoutExceptionHandling();
        $type = factory(ProductType::class)->create();
        $this->delete('/api/product_type/'.$type->id);
        $this->assertCount(0,ProductType::all());
    }
    /** @test */
    public function a_unit_can_be_added(){
        $this->withoutExceptionHandling();
        $this->post('/api/unit',['name'=>'unit test']);
        $this->assertCount(1,Unit::all());
    }
    /** @test */
    public function a_unit_can_be_patched(){
        $this->withoutExceptionHandling();
        $unit = factory(Unit::class)->create();
        $this->patch('/api/unit/'.$unit->id,['name'=>'Edited unit']);
        $unit = Unit::first();
        $this->assertEquals('Edited unit',$unit->name);
    }
    /** @test */
    public function a_unit_can_be_deleted(){
        $this->withoutExceptionHandling();
        $unit = factory(Unit::class)->create();
        $this->delete('/api/unit/'.$unit->id);
        $this->assertCount(0,Unit::all());
    }
}
