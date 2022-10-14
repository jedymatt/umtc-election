<?php

namespace App\Http\Requests\Admin;

use App\Services\EventService;
use Illuminate\Foundation\Http\FormRequest;

class StoreDsgElectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $event = $this->route('event');

        $admin = $this->user('admin');

        return empty(EventService::createDsgElectionFailureMessage($event, $admin));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:elections',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
            'department_id' => 'required|integer',
        ];
    }
}
