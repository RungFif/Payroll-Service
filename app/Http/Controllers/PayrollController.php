<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $query = Payroll::with('user');

            // Search filter
            if ($search = request('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                        ->orWhere('amount', 'like', "%$search%")
                        ->orWhere('period', 'like', "%$search%")
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

            // Period filter
            if (($period = request('period')) && $period !== 'all') {
                $query->where('period', $period);
            }

            $payrolls = $query->get();
        } else {
            $payrolls = Payroll::with('user')->where('user_id', Auth::id())->get();
        }
        return view('payrolls.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $users = User::all();
        return view('payrolls.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'period' => 'required',
            'status' => 'required',
        ]);
        Payroll::create($request->only('user_id', 'amount', 'period', 'status'));
        return redirect()->route('payrolls.index')->with('success', 'Payroll created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $payroll = Payroll::with('user')->findOrFail($id);
        if (!Auth::user()->hasRole('admin') && $payroll->user_id !== Auth::id()) {
            abort(403);
        }
        return view('payrolls.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $payroll = Payroll::findOrFail($id);
        $users = User::all();
        return view('payrolls.edit', compact('payroll', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'period' => 'required',
            'status' => 'required',
        ]);
        $payroll = Payroll::findOrFail($id);
        $payroll->update($request->only('user_id', 'amount', 'period', 'status'));
        return redirect()->route('payrolls.index')->with('success', 'Payroll updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted!');
    }

    /**
     * Export payrolls to CSV.
     */
    public function export(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        // If 'download' is present, export CSV, otherwise show export page
        if ($request->has('download')) {
            $query = Payroll::with('user');

            // Search filter
            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                        ->orWhere('amount', 'like', "%$search%")
                        ->orWhere('period', 'like', "%$search%")
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

            // Period filter
            if (($period = $request->input('period')) && $period !== 'all') {
                $query->where('period', $period);
            }

            $payrolls = $query->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="payrolls.csv"',
            ];

            $columns = ['ID', 'Employee Name', 'Employee Email', 'Amount', 'Period', 'Status', 'Created At'];

            return new StreamedResponse(function () use ($payrolls, $columns) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, $columns);

                foreach ($payrolls as $payroll) {
                    fputcsv($handle, [
                        $payroll->id,
                        $payroll->user->name ?? '',
                        $payroll->user->email ?? '',
                        $payroll->amount,
                        $payroll->period,
                        $payroll->status,
                        $payroll->created_at,
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        // Otherwise, show the export options page
        return view('payrolls.export');
    }
}
