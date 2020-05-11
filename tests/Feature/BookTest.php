<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Book;
use Hash;
use JWTAuth;
use Log;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    protected $user;

    protected function authenticate(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        $this->user = $user;
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    public function testGetAll()
    {
        $this->seed();
        // 获取Token
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/book',[]);
        $response->assertStatus(200);
        $this->assertEquals('test',$response->json()[0]['name']);
    }

    public function testGetOne()
    {
        $this->seed();
        $book_id = 1;
        // 获取Token
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/book/'.$book_id,[]);
        $response->assertStatus(200);
        $this->assertEquals('test',$response->json()['name']);
    }

    public function testCreate()
    {
        // 获取Token
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','api/book',[
            'name' => 'test',
            'content' => 'test',
            'price' => 99,
        ]);
        $response->assertStatus(201);
    }

    public function testUpdate(){
        $token = $this->authenticate();
        $this->seed();
        $book_id = 1;
        // 调用路由并断言响应
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','api/book/'.$book_id,[
            'name' => 'test2',
            'content' => 'test',
            'price' => 99,
        ]);
        //Log::Info('update_error'. $book->id. $book->name);
        $response->assertStatus(200);
        // 断言标题是一个新的标题
        $book = Book::find(1);
        $this->assertEquals('test2',$book->name);
    }

    public function testDelete(){
        $token = $this->authenticate();
        $this->seed();
        $book_id = 1;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','api/book/'.$book_id);
        $response->assertStatus(200);
        // 断言被删除后用户没有食谱
        //Log::Info('delete_error'. $book->id. $book->name);
        $book = Book::find(1);
        $this->assertEquals(null,$book);
    }
}
