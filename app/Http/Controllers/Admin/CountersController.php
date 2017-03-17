<?php

namespace App\Http\Controllers\Admin;

use App\Site;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CountersController extends Controller
{
    public function index(Request $request)
    {
        $startCurrentMonth = new Carbon('first day of this month');
        $startCurrentMonth->toDateTimeString();
        $startPrevMonth = new Carbon('first day of previous month');
        $startPrevMonth->toDateTimeString();
        $currentMonths = Site::where('count_words', '>', 0)->where('created_at', '>', $startCurrentMonth)->count();
        $prevMonths = Site::where('count_words', '>', 0)->where('created_at', '>', $startPrevMonth)
            ->where('created_at', '<', $startCurrentMonth)->count();
        if ($request->has('to') && $request->has('from')) {
            $items = Site::where('count_words', '>', 0)
                ->where('created_at', '>', $request->get('from'))
                ->where('created_at', '<', $request->get('to'))->latest()->paginate(20);
        } else {
            $items = Site::where('count_words', '>', 0)->latest()->paginate(20);
        }
        return view('admin.counters.index', compact('items', 'startCurrentMonth', 'startPrevMonth', 'prevMonths', 'currentMonths'));
    }
}
