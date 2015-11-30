<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Http\Requests;
use A3LWebInterface\Weblog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class WeblogController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($parameters = false)
    {
        if (!\Auth::User()->isAllowed('view_weblog')) {
            return Redirect::to('/');
        }

        if ($parameters || !empty(Input::all())):
            if (!$parameters) {
                $parameters = Input::all();
            } else {
                $parameters = explode('&', $parameters);
                $keys = array_map(function ($v) {
                    return explode('=', $v)[0];
                }, $parameters);
                $values = array_map(function ($v) {
                    return explode('=', $v)[1];
                }, $parameters);
                $parameters = array_combine($keys, $values);
            }

            $weblogs = Weblog::where(function ($query) use ($parameters) {
                foreach ($parameters as $key => $value):
                    if (!empty($value)):
                        switch ($key):
                            case 'e': // Editor
                                $query->where('editor_id', $value);
                                break;
                            case 't': // Table
                                $query->where('table', $value);
                                break;
                            case 'a': // Action
                                $query->where('type', $value);
                                break;
                            case 'o': // Object
                                $query->where('object_id', $value);
                                break;
                            case 'p': // Player
                                $query->where('player_id', $value);
                                break;
                            case 'c': // Comment
                                $query->where('comment', 'LIKE', '%' . $value . '%');
                                break;
                        endswitch;
                    endif;
                endforeach;
            })->get();
        else:
            $weblogs = Weblog::all();
        endif;
        return view('weblog/list')->with(['weblogs' => $weblogs]);
    }

}
