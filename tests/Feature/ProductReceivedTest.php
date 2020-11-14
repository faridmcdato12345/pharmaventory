<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use App\Product_Received;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductReceivedTest extends TestCase
{
    use RefreshDatabase;
   /** @test */
   public function a_product_received_can_be_stored(){
       $this->withoutExceptionHandling();
       $this->post('/api/product/received',[
           'quantity'=>100,
           'product_id'=>1,
        ]);
       $received = Product_Received::first();
       $this->assertEquals('100',$received->quantity);
       $this->assertEquals('1',$received->product_id);
   }
   /** @test */
   public function a_product_received_can_be_show(){
       $this->withoutExceptionHandling();
       $received = factory(Product_Received::class)->create();
       $response = $this->get('/api/product/received/' . $received->id);
       $response->assertJson([
        'quantity' => $received->quantity,
        'product_id' => $received->product_id,
       ]);
   }
   /** @test */
   public function a_product_received_belongs_to_product(){
       $this->withoutExceptionHandling();
       $this->foriegnKeys();
       $product = factory(Product::class)->create();
       $received = factory(Product_Received::class)->create(['product_id'=>$product->id]);
       $this->assertInstanceOf(Product::class,$received->products);
   }
}
