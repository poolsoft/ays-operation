<?php

namespace App\Http\Controllers\Ajax\Project;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function exists(Request $request)
    {
        return !is_null(Timesheet::where('task_id', $request->task_id)->
        where('starter_type', $request->starter_type)->
        where('starter_id', $request->starter_id)->
        where('start_time', '<>', null)->
        where('end_time', null)->
        first()) ? 1 : 0;
    }

    public function getOpenTimesheets(Request $request)
    {
        return response()->json(auth()->user()->timesheets()->with(['task'])->where('end_time', null)->get(), 200);
    }
}
