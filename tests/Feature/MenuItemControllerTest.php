<?php



namespace Tests\Feature;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MenuItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsNestedMenuStructure()
    {
        // Create menu items with the desired nested structure
        $menuItem1 = MenuItem::factory()->create([
            'name' => 'All events',
            'url' => '/events',
            'parent_id' => null,
        ]);
        $menuItem2 = MenuItem::factory()->create([
            'name' => 'Laracon',
            'url' => '/events/laracon',
            'parent_id' => $menuItem1->id,
        ]);
        $menuItem3 = MenuItem::factory()->create([
            'name' => 'Illuminate your knowledge of the laravel code base',
            'url' => '/events/laracon/workshops/illuminate',
            'parent_id' => $menuItem2->id,
        ]);
        $menuItem4 = MenuItem::factory()->create([
            'name' => 'The new Eloquent - load more with less',
            'url' => '/events/laracon/workshops/eloquent',
            'parent_id' => $menuItem2->id,
        ]);
        $menuItem5 = MenuItem::factory()->create([
            'name' => 'Reactcon',
            'url' => '/events/reactcon',
            'parent_id' => $menuItem1->id,
        ]);
        $menuItem6 = MenuItem::factory()->create([
            'name' => '#NoClass pure functional programming',
            'url' => '/events/reactcon/workshops/noclass',
            'parent_id' => $menuItem5->id,
        ]);
        $menuItem7 = MenuItem::factory()->create([
            'name' => 'Navigating the function jungle',
            'url' => '/events/reactcon/workshops/jungle',
            'parent_id' => $menuItem5->id,
        ]);

        // Send a GET request to the index endpoint
        $response = $this->get('/menu-items');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response contains the expected nested menu structure
        $response->assertJson([
            [
                'id' => $menuItem1->id,
                'name' => $menuItem1->name,
                'url' => $menuItem1->url,
                'parent_id' => $menuItem1->parent_id,
                'children' => [
                    [
                        'id' => $menuItem2->id,
                        'name' => $menuItem2->name,
                        'url' => $menuItem2->url,
                        'parent_id' => $menuItem2->parent_id,
                        'children' => [
                            [
                                'id' => $menuItem3->id,
                                'name' => $menuItem3->name,
                                'url' => $menuItem3->url,
                                'parent_id' => $menuItem3->parent_id,
                                'children' => [],
                            ],
                            [
                                'id' => $menuItem4->id,
                                'name' => $menuItem4->name,
                                'url' => $menuItem4->url,
                                'parent_id' => $menuItem4->parent_id,
                                'children' => [],
                            ],
                        ],
                    ],
                    [
                        'id' => $menuItem5->id,
                        'name' => $menuItem5->name,
                        'url' => $menuItem5->url,
                        'parent_id' => $menuItem5->parent_id,
                        'children' => [
                            [
                                'id' => $menuItem6->id,
                                'name' => $menuItem6->name,
                                'url' => $menuItem6->url,
                                'parent_id' => $menuItem6->parent_id,
                                'children' => [],
                            ],
                            [
                                'id' => $menuItem7->id,
                                'name' => $menuItem7->name,
                                'url' => $menuItem7->url,
                                'parent_id' => $menuItem7->parent_id,
                                'children' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}

?>