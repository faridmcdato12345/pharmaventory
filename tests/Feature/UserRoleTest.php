<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRoleTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function a_user_has_one_role(){
       $this->withoutExceptionHandling();
       $role = factory(Role::class)->create();
       $user = factory(User::class)->create(['role_id'=>$role->id]);
       $this->assertInstanceOf(Role::class,$user->roles);
   }
   /** @test */
   public function a_role_can_be_added(){
       $this->withoutExceptionHandling();
       $this->post('/api/roles',['name'=>'test role']);
       $role = Role::first();
       $this->assertEquals('test role',$role->name);
   }
   /** @test */
   public function a_role_can_be_patched(){
       $this->withoutExceptionHandling();
       $role = factory(Role::class)->create();
       $this->patch('/api/roles/' . $role->id , [
           'name' => 'admin',
       ]);
       $role = Role::first();
       $this->assertEquals('admin',$role->name);

   }
   /** @test */
   public function a_role_can_be_deleted(){
       $this->withoutExceptionHandling();
       $role = factory(Role::class)->create();
       $this->delete('/api/roles/' . $role->id);
       $this->assertCount(0,Role::all());
   }
}
