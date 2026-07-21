<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AdminInvoice;

class MasterDashboardController extends Controller
{
    public function index()
    {
        $summary = AdminInvoice::query()
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid, SUM(CASE WHEN status = 'unpaid' THEN 1 ELSE 0 END) as unpaid, COALESCE(SUM(jumlah), 0) as total_amount")
            ->first();

        $stats = [
            'invoice_total' => (int) $summary->total,
            'invoice_paid' => (int) $summary->paid,
            'invoice_open' => (int) $summary->unpaid,
            'nominal_total' => (float) $summary->total_amount,
        ];

        $invoices = AdminInvoice::with('user')
            ->latest('tgl_invoice')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('master.dashboard', compact('stats', 'invoices'));
    }
}
