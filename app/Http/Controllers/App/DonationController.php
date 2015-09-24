<?php
namespace App\Http\Controllers\App;

use App\Accounting;
use App\Donation;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;

class DonationController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', Donation::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.donation.index')->with([
            'donations' => Donation::all(),
        ]);
    }

    public function postStore()
    {
        $data = array_filter(\Input::only('donator_id', 'euro_amount', 'bamboo_amount', 'method', 'description'));
        $validator = \Validator::make($data, Donation::$rules);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $donation = new Donation($data);
        $donation->booker_id = \Auth::User()->id;
        $donation->save();

        $donator = $donation->donator;
        $donator->bamboo_coins += $donation->bamboo_amount;
        $donator->save();

        Accounting::create([
            'booker_id' => \Auth::User()->id,
            'amount' => $data['euro_amount'],
            'description' => 'Spende (#'.$donation->id.') über '.$donation->method.' von '.$donator->username.'.'
        ]);
        \Notifynder::category('coins.added')
            ->from($donation->booker_id)
            ->to($donation->donator_id)
            ->url('#')
            ->extra(['bamboo_amount' => $donation->bamboo_amount])
            ->send();
        return redirect('app/donation');
    }
}
