<?php

namespace App\Services;

use App\Helpers\General;
use App\Models\Assignment;
use App\Models\ChecklistItem;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function store(Request $request)
    {
        $this->task->company_id = Project::find($request->project_id)->company_id;
        $this->task->project_id = $request->project_id;
        $this->task->employee_id = $request->employee_id;
        $this->task->creator_id = auth()->user()->getId();
        $this->task->milestone_id = $request->milestone_id;
        $this->task->name = $request->name;
        $this->task->description = $request->description;
        $this->task->tags = $request->tags ? General::clearTagifyTags($request->tags) : null;
        $this->task->start_date = $request->start_date;
        $this->task->end_date = $request->end_date;
        $this->task->status_id = $request->status_id;
        $this->task->save();

        if ($request->employee_id) {
            $assignment = new Assignment;
            $assignment->task_id = $this->task->id;
            $assignment->employee_id = $request->employee_id;
            $assignment->date = date('Y-m-d H:i:s');
            $assignment->save();
        }

        if ($request->checklist) {
            $checklist = General::clearFormRepeater($request->checklist);
            foreach ($checklist as $item) {
                $newChecklistItem = new ChecklistItem;
                $newChecklistItem->task_id = $this->task->id;
                $newChecklistItem->creator_id = auth()->user()->getId();
                $newChecklistItem->name = $item;
                $newChecklistItem->save();
            }
        }

        return $this->task;
    }

}
