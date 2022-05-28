<?php

namespace App\Http\Requests\Admin;

use App\Services\EventService;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;

class StoreCdsgElectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var Event event */
        $event = $this->route('event');

        $admin = $this->user('admin');

        return empty(EventService::createCdsgElectionFailureMessage($event, $admin)) || !$event->hasConflictedElections();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before:end_at',
            'end_at' => 'required|date|after:start_at',
            'candidates' => 'nullable|array',
            'candidates.*.user_id' => 'integer',
            'candidates.*.position_id' => 'integer',
        ];
    }
}
