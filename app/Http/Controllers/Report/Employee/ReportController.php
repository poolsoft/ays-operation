<?php

namespace App\Http\Controllers\Report\Employee;

use App\Http\Controllers\Controller;
use App\Models\CallAnalysis;
use App\Models\Employee;
use App\Models\JobAnalysis;
use App\Models\Queue;
use App\Models\QueueAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\General;

class ReportController extends Controller
{
    public function comparisonReport()
    {
        return view('pages.report.employee.comparison');
    }

    public function comparisonReportShow(Request $request)
    {
        $callAnalyses = CallAnalysis::
        with('employee')->
        whereIn('employee_id', $request->employees)->
        whereBetween('date', [
            $request->start_date,
            $request->end_date,
        ])->
        get();

        $jobAnalyses = JobAnalysis::
        with('employee')->
        whereIn('employee_id', $request->employees)->
        whereBetween('date', [
            $request->start_date,
            $request->end_date,
        ])->
        get();

        $comparisons = [];

        foreach ($callAnalyses as $callAnalysis) {

            $comparisons['call'][] = [
                "employee_id" => $callAnalysis->employee->id,
                "employee" => $callAnalysis->employee,
                "total_success_call_rate" => $callAnalyses->where('employee_id', $callAnalysis->employee_id)->sum('total_success_call') * 100 / ($callAnalyses->sum('total_success_call') / count($request->employees)),
                "total_success_call" => $callAnalyses->where('employee_id', $callAnalysis->employee_id)->sum('total_success_call'),
                "incoming_success_call" => $callAnalyses->where('employee_id', $callAnalysis->employee_id)->sum('incoming_success_call'),
                "outgoing_success_call" => $callAnalyses->where('employee_id', $callAnalysis->employee_id)->sum('outgoing_success_call')
            ];
        }

        foreach ($jobAnalyses as $jobAnalysis) {

            $comparisons['job'][] = [
                "employee_id" => $jobAnalysis->employee->id,
                "employee" => $jobAnalysis->employee,
                "job_activity_rate" => $jobAnalyses->where('employee_id', $jobAnalysis->employee_id)->sum('job_activity_count') * 100 / ($jobAnalyses->sum('job_activity_count') / count($request->employees)),
                "job_complete_rate" => $jobAnalyses->where('employee_id', $jobAnalysis->employee_id)->sum('job_complete_count') * 100 / ($jobAnalyses->sum('job_complete_count') / count($request->employees)),
                "job_activity_count" => $jobAnalyses->where('employee_id', $jobAnalysis->employee_id)->sum('job_activity_count'),
                "job_complete_count" => $jobAnalyses->where('employee_id', $jobAnalysis->employee_id)->sum('job_complete_count')
            ];
        }

        $calls = collect($comparisons['call'])->unique('employee_id')->sortByDesc('total_success_call_rate');
        $jobs = collect($comparisons['job'])->unique('employee_id')->sortByDesc('job_complete_rate');

        $comparisons = [];

        foreach ($request->employees as $employee) {
            $comparisons[] = [
                'employee' => Employee::find($employee),
                'total_rate' => @($calls->where('employee_id', $employee)->first()['total_success_call_rate'] + $jobs->where('employee_id', $employee)->first()['job_activity_rate']) / 2,
                "job_activity_count" => @$jobs->where('employee_id', $employee)->first()['job_activity_count'],
                "job_complete_count" => @$jobs->where('employee_id', $employee)->first()['job_complete_count'],
                "total_success_call" => @$calls->where('employee_id', $employee)->first()['total_success_call'],
                "incoming_success_call" => @$calls->where('employee_id', $employee)->first()['incoming_success_call'],
                "outgoing_success_call" => @$calls->where('employee_id', $employee)->first()['outgoing_success_call']
            ];
        }

        $comparisons = collect($comparisons)->sortByDesc('total_rate')->all();

        return view('pages.report.employee.comparison-show', [
            'comparisons' => $comparisons,
            'request' => $request
        ]);
    }
}
