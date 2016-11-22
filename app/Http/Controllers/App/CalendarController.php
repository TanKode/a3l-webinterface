<?php

namespace App\Http\Controllers\App;

use App\Event;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function getIndex()
    {
        $calendar = \Calendar::addEvents(Event::all())
            ->setOptions([
                'lang' => config('app.locale'),
                'header' => [
                    'left' => 'title',
                    'center' => '',
                    'right' => 'prev,today,next',
                ],
            ])->setCallbacks([
                'viewRender' => 'function(){ calendar.fn.viewRender(); }',
                'eventClick' => 'function(calEvent, jsEvent, view){ return calendar.fn.eventClick(calEvent, jsEvent, view); }',
            ]);

        return view('app.calendar.index')->with([
            'calendar' => $calendar,
        ]);
    }

    public function postAddEvent()
    {
        $this->authorize('edit', Event::class);

        $data = \Input::all();
        $validator = \Validator::make($data, Event::$rules['create']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Event::create($data);

        return redirect('app/calendar');
    }

    public function getDeleteEvent(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();

        return redirect('app/calendar');
    }
}
