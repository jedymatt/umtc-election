<?php

namespace Tests\Feature\Admin;

use App\Enums\ElectionType;
use App\Livewire\Admin\CreateElectionForm;
use App\Models\Admin;
use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateElectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.create'));
        $response->assertOk();
    }

    public function test_livewire_create_form_component_is_visible(): void
    {
        $user = Admin::factory()->create();

        $this->actingAs($user, 'admin')->get(route('admin.elections.create'))
            ->assertSeeLivewire(CreateElectionForm::class);
    }

    public function test_livewire_create_form_component_only_allow_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.elections.create'))
            ->assertDontSeeLivewire(CreateElectionForm::class);

        Livewire::actingAs($user)
            ->test(CreateElectionForm::class)
            ->assertUnauthorized();
    }

    public function test_create_dsg_election()
    {
        $user = Admin::factory()->create();
        $department = Department::inRandomOrder()->first();
        Livewire::actingAs($user, 'admin')
            ->test(CreateElectionForm::class)
            ->set([
                'title' => 'Unique Example',
                'type' => ElectionType::Dsg->value,
                'department_id' => $department->id,
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'description' => fake()->sentence(),
            ])
            ->call('submit')
            ->assertOk()
            ->assertHasNoErrors();

        $this->assertDatabaseHas('elections', [
            'title' => 'Unique Example',

            // fragile values
            'type' => ElectionType::Dsg->value,
            'department_id' => $department->id,
        ]);
    }

    public function test_create_dsg_election_fail_if_no_department(): void
    {
        $user = Admin::factory()->create();
        Livewire::actingAs($user, 'admin')
            ->test(CreateElectionForm::class)
            ->set([
                'title' => 'Unique Example',
                'type' => ElectionType::Dsg->value,
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'description' => fake()->sentence(),
            ])
            ->call('submit')
            ->assertHasErrors();

        $this->assertDatabaseMissing('elections', [
            'title' => 'Unique Example',
        ]);
    }

    public function test_create_cdsg_election(): void
    {
        $user = Admin::factory()->create();
        Livewire::actingAs($user, 'admin')
            ->test(CreateElectionForm::class)
            ->set([
                'title' => 'Unique Example',
                'type' => ElectionType::Cdsg->value,
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'description' => fake()->sentence(),
            ])
            ->call('submit')
            ->assertOk()
            ->assertHasNoErrors();

        $this->assertDatabaseHas('elections', [
            'title' => 'Unique Example',
            'type' => ElectionType::Cdsg->value,
            'department_id' => null,
        ]);
    }

    public function test_create_cdsg_fail_if_has_department(): void
    {
        $user = Admin::factory()->create();
        $department = Department::inRandomOrder()->first();
        Livewire::actingAs($user, 'admin')
            ->test(CreateElectionForm::class)
            ->set([
                'title' => 'Unique Example',
                'type' => ElectionType::Cdsg->value,
                'department_id' => $department->id,
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'description' => fake()->sentence(),
            ])
            ->call('submit')
            ->assertHasErrors();
    }

    public function test_switch_selected_type_before_creating_cdsg()
    {
        $user = Admin::factory()->create();
        $department = Department::inRandomOrder()->first();
        Livewire::actingAs($user, 'admin')
            ->test(CreateElectionForm::class)
            ->set([
                'title' => 'Unique Example',
                'type' => ElectionType::Dsg->value,
                'department_id' => $department->id,
                'start_at' => now()->addDay(),
                'end_at' => now()->addDays(2),
                'description' => fake()->sentence(),
            ])
            ->set('type', ElectionType::Cdsg->value)
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('elections', [
            'title' => 'Unique Example',
            'department_id' => null,
        ]);
    }
}
