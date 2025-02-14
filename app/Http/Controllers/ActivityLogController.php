<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Log";
        $breadcrumb = "Log";
        if ($request->ajax()) {
            $data = Activity::query();
            if ($search = $request->input('search.value')) {
                $data->where(function ($data) use ($search) {
                    $data->where('log_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('log_name', function ($data) {
                    return $data->log_name;
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('created_at', function ($data) {
                    return \Carbon\Carbon::parse($data->created_at)->translatedFormat('l, d F Y H:i');
                })
                ->make(true);
        }
        return view('activityLog', get_defined_vars());
    }
}
