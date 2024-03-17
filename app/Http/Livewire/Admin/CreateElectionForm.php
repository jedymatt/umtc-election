<?php

namespace App\Http\Livewire\Admin;

use App\Enums\ElectionType;
use App\Models\Department;
use App\Models\Election;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateElectionForm extends Component
{
    public $title;

    public $description;

    public $start_at;

    public $end_at;

    public $department_id;

    public $type;

    public function mount(): void
    {
        $this->type = ElectionType::Dsg->value;
        $this->department_id = '';
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'type' => ['required', 'string', Rule::enum(ElectionType::class)],
            'department_id' => [
                'integer',
                'exists:departments,id',
                'required_if:type,'.ElectionType::Dsg->value,
                'prohibited_if:type,'.ElectionType::Cdsg->value,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.create-election-form', [
            'electionTypes' => ElectionType::cases(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function submit(): void
    {
        $validated = $this->validate(attributes: ['department_id' => 'department']);

        if ($this->type === ElectionType::Cdsg->value) {
            $validated['department_id'] = null;
        }

        $election = Election::create($validated);

        $this->redirect(route('admin.elections.candidates', $election));
    }

    // listen to type changes
    public function updatedType($value): void
    {
        $this->department_id = $value === ElectionType::Dsg->value ? '' : $this->department_id;
    }
}
