<?php

namespace Tests\Feature;

use App\Type;
use App\Unit;
use App\User;
use App\Brand;
use App\Potency;
use App\Product;
use App\Storage;
use App\Category;
use Carbon\Carbon;
use Tests\TestCase;
use App\ProductType;
use App\Classification;
use App\Product_Received;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $class;
    protected $type;
    protected $unit;
    protected $storage;
    protected $potency;
    protected $brand;
    protected $categogy;
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
        $this->foriegnKeyData();
        $this->post('/api/products',$this->data());
        $product = Product::first();
        $this->assertEquals('Test name',$product->name);
        $this->assertEquals('Test description',$product->description);
        $this->assertEquals(100,$product->retail_price);
        $this->assertEquals(100,$product->purchase_price);
        $this->assertEquals(1000,$product->quantity);
        $this->assertEquals('1',$product->unit_id);
        $this->assertEquals('1',$product->user_id);
        $this->assertEquals('1',$product->potency_id);
        $this->assertEquals('1',$product->packaging_id);
        $this->assertEquals('1',$product->brand_id);
        $this->assertEquals('1',$product->category_id);
        $this->assertEquals('1',$product->storage_id);
        $this->assertEquals('11111',$product->barcode);
        $this->assertEquals('05-14-1990',$product->expiration->format('m-d-Y'));
    }
    /** @test */
    public function fields_are_required(){
        collect(['description','retail_price','quantity'])->each(function($field){
            $response = $this->post('/api/products',array_merge($this->data(),[$field => '']));
            $response->assertSessionHasErrors($field);
            $this->assertCount(0,Product::all());
        });
    }
    /** @test */
    public function expiration_date_is_properly_stored(){
        $this->foriegnKeyData();
        $response = $this->post('/api/products',$this->data());
        $this->assertCount(1,Product::all());
        $this->assertInstanceOf(Carbon::class,Product::first()->expiration);
        $this->assertEquals('05-14-1990',Product::first()->expiration->format('m-d-Y'));
    }
    /** @test */
    public function an_authorized_user_can_retreive_product(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create();
        $response = $this->get('/api/products/' . $product->id . '?api_token=' . $this->user->api_token);
       
        $response->assertJson([
            'name'=> $product->name,
            'description' => $product->description,
            'retail_price'=>$product->retail_price,
            'purchase_price'=>$product->purchase_price,
            'quantity'=>$product->quantity,
            'unit_id'=>$product->unit_id,
            'user_id'=>$product->user_id,
            'potency_id'=>$product->potency_id,
            'packaging_id'=>$product->packaging_id,
            'brand_id'=>$product->brand_id,
            'category_id'=>$product->category_id,
            'storage_id'=>$product->storage_id,
            'class_id'=>$product->class_id,
            'type_id'=>$product->type_id,
            'barcode'=>$product->barcode,
            
        ]);
    }
    /** @test */
    public function a_product_can_be_patched(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create();
        $response = $this->patch('/api/products/' . $product->id, $this->data());
        $product = $product->first();
        $this->assertEquals('Test name',$product->name);
        $this->assertEquals('Test description',$product->description);
        $this->assertEquals('100',$product->retail_price);
        $this->assertEquals('100',$product->purchase_price);
        $this->assertEquals('1000',$product->quantity);
        $this->assertEquals('11111',$product->barcode);
        $this->assertEquals('1',$product->unit_id);
        $this->assertEquals('1',$product->user_id);
        $this->assertEquals('1',$product->potency_id);
        $this->assertEquals('1',$product->packaging_id);
        $this->assertEquals('1',$product->brand_id);
        $this->assertEquals('1',$product->category_id);
        $this->assertEquals('1',$product->storage_id);
        $this->assertEquals('05-14-1990',$product->expiration->format('m-d-Y'));
    }
    /** @test */
    public function an_authorized_user_can_delete_product(){
        $this->foriegnKeyData();
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
            'potency_id'=>1,
            'packaging_id'=>1,
            'brand_id'=>1,
            'storage_id'=>1,
            'category_id'=>1,
            'name'=>'Test name',
            'description'=>'Test description',
            'retail_price' => 100,
            'purchase_price'=>100,
            'barcode'=>11111,
            'quantity' => 1000,
            'expiration' => '05/14/1990',
            'api_token' => $this->user->api_token,
        ];
    }
    /***** test for classification */

    /** @test */
    public function a_classification_can_be_added(){
        $this->withoutExceptionHandling();
        $class = $this->post('/api/classification',$this->theData());
        $this->assertCount(1,Classification::all());
    }
    /** @test */
    public function a_classification_can_be_retreived(){
        $this->withoutExceptionHandling();
        $class = factory(Classification::class)->create();
        $response = $this->get('/api/classification/' . $class->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'name' => $class->name,
        ]);
    }
    private function theData(){
        return [
            'name' => 'Test Name',
            'api_token' => $this->user->api_token,
        ];
    }
    /** @test */
    public function a_classification_can_be_patch(){
        $class = factory(Classification::class)->create();
        $response = $this->patch('/api/classification/' . $class->id, $this->theData());
        $class = $class->first();
        $this->assertEquals('Test Name',$class->name);
    }
    /** @test */
    public function a_classification_can_be_deleted(){
        $class = factory(Classification::class)->create();
        $this->delete('/api/classification/' . $class->id . '?api_token= ' .$this->user->api_token);
        $this->assertCount(0,Classification::all());
    }
    /** @test */
    public function a_type_can_be_added(){
        $this->post('/api/product_type',$this->theData());
        $type = ProductType::first();
        $this->assertEquals('Test Name',$type->name);
    }
    /** @test */
    public function a_type_can_be_patch(){
        $this->withoutExceptionHandling();
        $type = factory(ProductType::class)->create();
        $this->patch('/api/product_type/'.$type->id,$this->theData());
        $type = $type->first();
        $this->assertEquals('Test Name', $type->name);
    }
    /** @test */
    public function a_type_can_be_deleted(){
        $type = factory(ProductType::class)->create();
        $this->delete('/api/product_type/'. $type->id . '?api_token=' . $this->user->api_token );
        $this->assertCount(0,ProductType::all());
    }
    /** @test */
    public function a_unit_can_be_added(){
        $this->post('/api/unit',$this->theData());
        $unit = Unit::first();
        $this->assertEquals('Test Name',$unit->name);
    }
    /** @test */
    public function a_unit_can_be_patched(){
        $unit = factory(Unit::class)->create();
        $this->patch('/api/unit/'.$unit->id,$this->theData());
        $unit = Unit::first();
        $this->assertEquals('Test Name',$unit->name);
    }
    /** @test */
    public function a_unit_can_be_deleted(){
        $unit = factory(Unit::class)->create();
        $response = $this->delete('/api/unit/' . $unit->id . '?api_token=' . $this->user->api_token);
        $this->assertCount(0,Unit::all());
    }
    /** @test */
    public function a_product_belongs_to_classification(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['class_id' => $this->class->id]);
        $this->assertInstanceOf(Product::class,$this->class->products);
    }
    /** @test */
    public function a_classification_has_many_product(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['class_id' => $this->class->id]);
        $this->assertInstanceOf(Classification::class,$product->classifications);
    }
    /** @test */
    public function a_product_belongs_to_type(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['type_id' => $this->type->id]);
        $this->assertInstanceOf(Product::class,$this->type->products);
    }
    /** @test */
    public function a_type_has_many_products(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['type_id' => $this->type->id]);
        $this->assertInstanceOf(ProductType::class,$product->types);
    }
    /** @test */
    public function a_product_belongs_to_unit(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['unit_id' => $this->unit->id]);
        $this->assertInstanceOf(Product::class,$this->unit->products);
    }
    /** @test */
    public function a_unit_has_one_product(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['unit_id' => $this->unit->id]);
        $this->assertInstanceOf(Unit::class,$product->units);
    }
    /** @test */
    public function a_product_belongs_to_storage(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['storage_id' => $this->storage->id]);
        $this->assertInstanceOf(Product::class,$this->storage->products);
    }
    /** @test */
    public function a_storage_has_one_products(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['storage_id' => $this->storage->id]);
        $this->assertInstanceOf(Storage::class,$product->storages);
    }
    /** @test */
    public function a_product_belongs_to_potency(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['potency_id' => $this->potency->id]);
        $this->assertInstanceOf(Product::class,$this->potency->products);
    }
    /** @test */
    public function a_potency_has_one_product(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['potency_id' => $this->potency->id]);
        $this->assertInstanceOf(Potency::class,$product->potencies);
    }
    /** @test */
    public function a_product_belongs_to_brand(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['brand_id' => $this->brand->id]);
        $this->assertInstanceOf(Product::class,$this->brand->products);
    }
    /** @test */
    public function a_brand_has_one_product(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['brand_id' => $this->brand->id]);
        $this->assertInstanceOf(Brand::class,$product->brands);
    }
    /** @test */
    public function a_product_belongs_to_category(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['category_id' => $this->category->id]);
        $this->assertInstanceOf(Product::class,$this->category->products);
    }
    /** @test */
    public function a_category_has_one_product(){
        $this->foriegnKeyData();
        $product = factory(Product::class)->create(['category_id' => $this->category->id]);
        $this->assertInstanceOf(Category::class,$product->categories);
    }

    private function foriegnKeyData(){
        $this->class = factory(Classification::class)->create();
        $this->type = factory(ProductType::class)->create();
        $this->unit = factory(Unit::class)->create();
        $this->storage = factory(Storage::class)->create();
        $this->potency = factory(Potency::class)->create();
        $this->brand = factory(Brand::class)->create();
        $this->category = factory(Category::class)->create();
    }
}
