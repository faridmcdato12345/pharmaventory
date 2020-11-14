<?php

namespace Tests\Feature;

use App\Unit;
use App\User;
use App\Brand;
use App\Invoice;
use App\Potency;
use App\Product;
use App\Storage;
use App\Category;
use Tests\TestCase;
use App\ProductType;
use App\Classification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        
    }
    /** @test */
    public function a_invoice_can_be_added(){
        $this->withoutExceptionHandling();
        $this->post('/api/invoices',[
            'quantity'=>'sample quantity',
            'product_id'=>'1',
            'invoice_number'=>'123412',
            'api_token' => $this->user->api_token,
        ]);
        $invoice = Invoice::first();
        $this->assertEquals('sample quantity',$invoice->quantity);
        $this->assertEquals('1',$invoice->product_id);
        $this->assertEquals('123412',$invoice->invoice_number);
    }
    /** @test */
    public function a_invoice_can_be_shown(){
        $this->withoutExceptionHandling();
        $invoice = factory(Invoice::class)->create();
        $response = $this->get('/api/invoices/' . $invoice->id . '?api_token=' .$this->user->api_token);
        $response->assertJson([
            'quantity' => $invoice->quantity,
            'product_id'=>$invoice->product_id,
            'invoice_number'=>$invoice->invoice_number,
        ]);
    }
    /** @test */
    public function a_invoice_has_many_product(){
        $class = factory(Classification::class)->create();
        $type = factory(ProductType::class)->create();
        $unit = factory(Unit::class)->create();
        $storage = factory(Storage::class)->create();
        $potency = factory(Potency::class)->create();
        $brand = factory(Brand::class)->create();
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $invoice = factory(Invoice::class)->create(['product_id'=>$product->id]);
        $this->assertInstanceOf(Product::class,$invoice->products);
    }
}
