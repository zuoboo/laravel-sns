<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ArticleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // データベースをリセット
    // トレイト　継承と似たPHPの機能で、汎用性の高いメソッドなどをトレイトとしてまとめておき、他の複数のクラスで共通して使える
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)->assertViewIs('articles.index');
    }
    // 未ログインであれば、ログイン画面にリダイレクトテスト
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));
        $response->assertRedirect(route('login'));
    }
    // ログイン済み状態であれば、記事投稿画面が表示されるテスト
    public function testAuthCreate()
    {
        // テスト書き方 AAA(Arrange-Act-Assert 準備・実行・検証)
        // テストに必要なUserモデルを準備
        $user = factory(User::class)->create();

        // ログインして記事投稿画面にアクセスすることを実行
        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        // レスポンスを検証
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}
