<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Event;
use App\Services\ElectionService;
use App\Services\EventService;
use Closure;
use Illuminate\Http\Request;

class EnsureCanCreateElection
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('admin.events.dsg-elections.create')) {
            /** @var Event $event */
            $event = $request->route('event');

            /** @var Admin $admin */
            $admin = $request->user();

            $failureMessage = EventService::createDsgElectionFailureMessage($event, $admin);

            if (!empty($failureMessage)) {
                return back()->with('warning', $failureMessage . '!');
            }
        }

        if ($request->routeIs('admin.events.cdsg-elections.create')) {
            /** @var Event $event */
            $event = $request->route('event');

            /** @var Admin $admin */
            $admin = $request->user();

            $failureMessage = EventService::createCdsgElectionFailureMessage($event, $admin);

            if (!empty($failureMessage)) {
                return back()->with('warning', $failureMessage . '!');
            }
        }

        return $next($request);
    }
}
