<?php
namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GatewayController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $gateways = Gateway::orderBy('sort_order')
                ->orderBy('created_at', 'DESC')
                ->get();

        return view('gateway.index',['gateways' => $gateways]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $validator = Validator::make($request->all(), Gateway::$rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['status'] = $request->boolean('status', true);
        if (! isset($data['sort_order']) || $data['sort_order'] === null || $data['sort_order'] === '') {
            $data['sort_order'] = ((int) Gateway::max('sort_order')) + 1;
        }

        $gateway = Gateway::create($data);
        
        if ($gateway) {
            return response()->json(['message' => 'Gateway created successfully', 'gateway' => $gateway], 201);
        } else {
            return response()->json(['message' => 'Failed to create gateway'], 500);
        }
    }


    public function create(){
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        return view('gateway.create');
    }

    public function edit($id){
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $gateway = Gateway::find($id);

        return view('gateway.edit',['gateway' => $gateway]);
    }

    public function show(Gateway $gateway)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        return $gateway;
    }

    public function update(Request $request, Gateway $gateway)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $validator = Validator::make($request->all(), Gateway::$rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['status'] = $request->boolean('status', true);
        $gateway->update($data);
        
        if ($gateway) {
            return response()->json(['message' => 'Gateway updated successfully', 'gateway' => $gateway], 200);
        } else {
            return response()->json(['message' => 'Failed to update gateway'], 500);
        }
    }

    public function destroy($id)
    {
        $gateway = Gateway::find($id);
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $hasPayments = Payment::withTrashed()
            ->where('gateway_id', $gateway->id)
            ->exists();
        if ($hasPayments) {
            return back()->with('message', 'Cannot delete gateway: it has related payments.');
        }

        $gateway->delete();
        return back()->with('message','Gateway deleted successfully');
    }

    public function reorder(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $validator = Validator::make($request->all(), [
            'gateway_ids' => 'required|array|min:1',
            'gateway_ids.*' => 'integer|exists:gateways,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request) {
            foreach ($request->gateway_ids as $index => $gatewayId) {
                Gateway::where('id', $gatewayId)->update(['sort_order' => $index + 1]);
            }
        });

        return response()->json(['message' => 'Gateway order updated successfully.']);
    }

    public function updateStatus(Request $request, Gateway $gateway)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $gateway->update([
            'status' => $request->boolean('status'),
        ]);

        return response()->json([
            'message' => 'Gateway status updated successfully.',
            'status' => (bool) $gateway->status,
        ]);
    }
}

