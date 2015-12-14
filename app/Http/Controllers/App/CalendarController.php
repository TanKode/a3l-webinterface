<?php
namespace App\Http\Controllers\App;

use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
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
                'viewRender' => "function() {
                    jQuery('.fc-right').addClass('btn-toolbar');
                    jQuery('.fc-button-group').addClass('btn-group').removeClass('fc-button-group');
                    jQuery('.fc-button').addClass('btn btn-primary').removeClass('fc-button fc-state-default fc-corner-left fc-state-disabled fc-state-active');
                }",
                'eventClick' => "function(calEvent, jsEvent, view) {
                    console.log('Event: ', calEvent);
                    var \$modal = $('#md-event');
                    \$modal.find('.event-name').text(calEvent.title);
                    \$modal.find('.event-start').text(calEvent.start.format('DD.MM.YYYY'));
                    \$modal.find('.event-end').text(calEvent.end == null ? calEvent.start.format('DD.MM.YYYY') : calEvent.end.format('DD.MM.YYYY'));
                    \$modal.find('.event-link').html('<a href=\"' + calEvent.url + '\" target=\"_blank\">' + calEvent.url + '</a>');
                    \$modal.find('.event-description').html(calEvent.description);
                    \$modal.find('.modal-header').css({backgroundColor: calEvent.backgroundColor})
                        .find('.modal-title').css({color: calEvent.textColor}).text(calEvent.title);

                    var \$delete = \$modal.find('.event-delete');
                    if(\$delete.length == 1) {
                        \$delete.attr('href', \$delete.data('href') + '/' + calEvent.id);
                    }
                    \$modal.modal('show');
                    return false;
                }",
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
