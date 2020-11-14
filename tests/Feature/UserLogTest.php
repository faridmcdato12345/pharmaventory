<?php

namespace Tests\Feature;

use App\User;
use App\UserLog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_log_can_be_stored(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->post('/api/user/log',[
            'action'=>'sample action',
            'user_id'=>$user->id,
        ]);
        $this->assertCount(1, UserLog::all());
    }
    /** @test */
    public function a_user_log_belongs_to_user(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $userlog = factory(UserLog::class)->create(['user_id'=>$user->id]);
        $this->assertInstanceOf(User::class,$userlog->users);
    }
}
