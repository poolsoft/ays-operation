<?php

namespace App\Http\Controllers\Project\Project\Milestone;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\Task;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function create(Request $request)
    {
        $milestone = (new MilestoneService(new Milestone))->store($request);
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        Task::where('milestone_id', $request->milestone_id)->update(['milestone_id' => null]);
        Milestone::find($request->milestone_id)->delete();
        return redirect()->back();
    }
}
