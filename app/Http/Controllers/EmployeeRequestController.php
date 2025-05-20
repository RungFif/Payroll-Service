<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmployeeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $query = EmployeeRequest::with('user');

            // Search filter
            if ($search = request('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                        });
                });
            }

            // Status filter
            if (($status = request('status')) && $status !== 'all') {
                $query->where('status', $status);
            }

            // Type filter
            if (($type = request('type')) && $type !== 'all') {
                $query->where('type', $type);
            }

            $requests = $query->get();
        } else {
            $requests = EmployeeRequest::where('user_id', Auth::id())->get();
        }
        return view('employee_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasRole('user')) {
            abort(403);
        }
        return view('employee_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('user')) {
            abort(403);
        }
        $request->validate([
            'type' => 'required',
            'description' => 'nullable',
        ]);
        EmployeeRequest::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'description' => $request->description,
            'status' => 'pending',
        ]);
        return redirect()->route('employee-requests.index')->with('success', 'Request submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $requestModel = EmployeeRequest::findOrFail($id);
        if (!Auth::user()->hasRole('admin') && $requestModel->user_id !== Auth::id()) {
            abort(403);
        }
        return view('employee_requests.show', ['request' => $requestModel]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $requestModel = EmployeeRequest::findOrFail($id);
        if (!Auth::user()->hasRole('user') || $requestModel->user_id !== Auth::id()) {
            abort(403);
        }
        return view('employee_requests.edit', ['request' => $requestModel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $empRequest = EmployeeRequest::findOrFail($id);
        if (Auth::user()->hasRole('admin')) {
            $request->validate(['status' => 'required|in:pending,approved,denied']);
            $empRequest->update(['status' => $request->status]);
            return redirect()->route('employee-requests.index')->with('success', 'Status updated!');
        } elseif (Auth::user()->hasRole('user') && $empRequest->user_id === Auth::id()) {
            $request->validate([
                'type' => 'required',
                'description' => 'nullable',
            ]);
            $empRequest->update($request->only('type', 'description'));
            return redirect()->route('employee-requests.index')->with('success', 'Request updated!');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empRequest = EmployeeRequest::findOrFail($id);
        if (!Auth::user()->hasRole('user') || $empRequest->user_id !== Auth::id()) {
            abort(403);
        }
        $empRequest->delete();
        return redirect()->route('employee-requests.index')->with('success', 'Request deleted!');
    }

    /**
     * Show the form for editing the status of the specified resource.
     */
    public function editStatus(EmployeeRequest $request)
    {
        // Only allow admin
        abort_unless(Auth::user()->hasRole('admin'), 403);
        return view('employee_requests.updateStatus', compact('request'));
    }

    /**
     * Export the employee requests to a CSV file.
     */
    public function export(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        // If 'download' is present, export CSV, otherwise show export page
        if ($request->has('download')) {
            $query = EmployeeRequest::with('user');

            // Search filter
            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                        });
                });
            }

            // Status filter
            if (($status = $request->input('status')) && $status !== 'all') {
                $query->where('status', $status);
            }

            // Type filter
            if (($type = $request->input('type')) && $type !== 'all') {
                $query->where('type', $type);
            }

            $requests = $query->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="employee_requests.csv"',
            ];

            $columns = ['ID', 'Employee Name', 'Employee Email', 'Type', 'Description', 'Status', 'Created At'];

            return new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($requests, $columns) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, $columns);

                foreach ($requests as $req) {
                    fputcsv($handle, [
                        $req->id,
                        $req->user->name ?? '',
                        $req->user->email ?? '',
                        $req->type,
                        $req->description,
                        $req->status,
                        $req->created_at,
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        // Otherwise, show the export options page
        return view('employee_requests.export');
    }
}
