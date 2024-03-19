<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Livewire\Profile\UpdateProfileInformationForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->name, $component->state['name']);
        $this->assertEquals($user->email, $component->state['email']);
        $this->assertEquals($user->department_id, $component->state['department_id']);
    }

    public function test_current_profile_information_without_department_is_available()
    {
        $this->actingAs($user = User::factory()->create([
            'department_id' => null,
        ]));

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->name, $component->state['name']);
        $this->assertEquals($user->email, $component->state['email']);
        $this->assertEquals($user->department_id, $component->state['department_id']);
    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test Name', 'department_id' => 1])
            ->call('updateProfileInformation');

        $this->assertEquals('Test Name', $user->fresh()->name);
        $this->assertEquals(1, $user->fresh()->department_id);
    }

    public function test_profile_information_email_should_not_be_changed()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['name' => 'Test Name', 'email' => 'sample@admin.com', 'department_id' => 1])
            ->call('updateProfileInformation');

        $this->assertNotEquals('sample@admin.com', $user->fresh()->email);
    }
}
