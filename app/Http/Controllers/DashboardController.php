<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gateway;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $isAdmin = (bool) $user->is_admin;

        if ($isAdmin) {
            $query = Payment::with(['gateway', 'brand', 'user', 'customer']);
        } else {
            $query = Payment::with(['gateway', 'brand', 'user', 'customer'])
                ->where('user_id', $user->id);
        }

        $startDate = request('start_date');
        $endDate = request('end_date');
        $status = request('status');

        if ($startDate) {
            $query->whereDate('updated_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('updated_at', '<=', $endDate);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($isAdmin && request()->filled('seller_id')) {
            $query->where('user_id', (int) request('seller_id'));
        }

        if (request()->filled('gateway_id')) {
            $query->where('gateway_id', (int) request('gateway_id'));
        }

        if (request()->filled('brand_id')) {
            $query->where('brand_id', (int) request('brand_id'));
        }

        $payments = $query->orderBy('updated_at', 'desc')->get();

        $usPaidAmount = 0;
        $usUnpaidAmount = 0;
        $gbpPaidAmount = 0;
        $gbpUnpaidAmount = 0;

        $paidCount = 0;
        $unpaidCount = 0;

        foreach ($payments as $payment) {
            $taxAmount = $payment->tax ? ($payment->price * $payment->tax) / 100 : 0;
            $totalPrice = $payment->price + $taxAmount;

            if ($payment->status === 'paid') {
                $paidCount++;
            } elseif ($payment->status === 'unpaid') {
                $unpaidCount++;
            }

            if ($payment->currency === 'usd') {
                if ($payment->status === 'paid') {
                    $usPaidAmount += $totalPrice;
                } elseif ($payment->status === 'unpaid') {
                    $usUnpaidAmount += $totalPrice;
                }
            } elseif ($payment->currency === 'gbp') {
                if ($payment->status === 'paid') {
                    $gbpPaidAmount += $totalPrice;
                } elseif ($payment->status === 'unpaid') {
                    $gbpUnpaidAmount += $totalPrice;
                }
            }
        }

        $sellers = $isAdmin
            ? User::orderBy('name')->get(['id', 'name'])
            : collect();

        $brands = Brand::orderBy('name')->get(['id', 'name']);
        // Backward-compatible alias (older blades / cached views expected $merchants).
        $merchants = $brands;

        $gateways = Gateway::orderBy('sort_order')->orderBy('name')->get(['id', 'name']);

        return view('dashboard', compact(
            'payments',
            'usPaidAmount',
            'usUnpaidAmount',
            'gbpPaidAmount',
            'gbpUnpaidAmount',
            'paidCount',
            'unpaidCount',
            'sellers',
            'brands',
            'merchants',
            'gateways',
            'isAdmin'
        ));
    }
}
