<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Str;
use Tests\TestCase;

class LinksTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_read_link_list()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('links.index'));

        $response->assertViewIs('links.index');

        $response->assertViewHas([
            'links' => auth()->user()->links,
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_not_read_link_list()
    {
        $response = $this->get(route('links.index'));

        $response->assertRedirect(route('login.create'));
    }

    public function test_user_can_read_create_link()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/links/create');

        $response->assertViewIs('links.create');

        $response->assertStatus(200);

    }

    public function test_user_can_not_read_create_link()
    {
        $response = $this->get('/links/create');

        $response->assertRedirect(route('login.create'));

    }

    public function test_url_field_is_required()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('links.store'), [
                'url' => '',
            ]);

        $response->assertSessionHasErrors([
            'url' => 'The url field is required.'
        ]);
    }

    public function test_url_field_has_url_rule()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('links.store'), [
                'url' => 'hello',
            ]);

        $response->assertSessionHasErrors([
            'url' => 'The url must be a valid URL.'
        ]);
    }

    public function test_user_can_delete_link()
    {
        $user = User::factory()->create();

        $link = Link::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->delete(route('links.destroy', $link->slug));

        $this->assertDeleted($link);

        $response->assertRedirect(route('links.index'));

    }

    public function test_store_method()
    {
        $user = User::factory()->create();

        $data=['url' => 'https://google.com',];

        $response = $this->actingAs($user)->post(route('links.store'),$data);

        $this->assertDatabaseHas('links',['url'=>$data['url']]);

        $this->assertDatabaseCount('links', 1);

        $response->assertRedirect(route('links.index'));
    }

    public function test_handle_method()
    {

        $user = User::factory()->create();

        $link = Link::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->get(route('links.handle', $link->slug));

        $response->assertRedirect($link->url);

    }

    public function test_slug_must_be_unique()
    {
        $user = User::factory()->create();

        $link = Link::factory()->for($user)->create();

        $new_link = Link::factory()->state(['slug' => $link->slug])->make()->toArray();

        $this->assertDatabaseMissing('links', $new_link);

        $this->actingAs($user)->
        withSession(['wrong' => 'something is wrong please try again!'])
            ->get(route('links.create'));

    }


}
