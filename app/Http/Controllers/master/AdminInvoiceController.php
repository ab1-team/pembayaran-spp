<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\AdminInvoice;
use App\Models\AdminUser;
use App\Models\Profil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminInvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AdminInvoice::with('user')->select('admin_invoice.*');

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('owner', fn ($row) => $row->user->nama_lengkap ?? '—')
                ->addColumn('tgl_invoice_fmt', fn ($row) => $row->tgl_invoice?->format('d/m/Y') ?? '—')
                ->addColumn('tgl_lunas_fmt', fn ($row) => $row->tgl_lunas?->format('d/m/Y') ?? '—')
                ->addColumn('jumlah_fmt', fn ($row) => 'Rp ' . number_format((float) $row->jumlah, 0, ',', '.'))
                ->addColumn('status_badge', function ($row) {
                    return $row->status === 'paid'
                        ? '<span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">Paid</span>'
                        : '<span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-700">Unpaid</span>';
                })
                ->orderColumn('tgl_invoice_fmt', 'admin_invoice.tgl_invoice $1')
                ->orderColumn('owner', 'admin_invoice.user_id $1')
                ->filterColumn('owner', function ($q, $kw) {
                    $q->whereHas('user', fn ($qq) => $qq->where('nama_lengkap', 'like', "%{$kw}%")
                        ->orWhere('email', 'like', "%{$kw}%"));
                })
                ->filterColumn('status_badge', function ($q, $kw) {
                    if (str_contains(strtolower($kw), 'paid') && !str_contains(strtolower($kw), 'unpaid')) {
                        $q->where('admin_invoice.status', 'paid');
                    } elseif (str_contains(strtolower($kw), 'unpaid')) {
                        $q->where('admin_invoice.status', 'unpaid');
                    }
                })
                ->addColumn('action', function ($row) {
                    $print = route('master.invoice.print', $row->id);
                    $delete = route('master.invoice.destroy', $row->id);
                    return '
                        <div class="inline-flex gap-1">
                            <button type="button" class="print-invoice inline-flex items-center rounded-lg bg-indigo-100 px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-200" data-url="'.$print.'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                            <button type="button" class="delete-invoice inline-flex items-center rounded-lg bg-rose-100 px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-200" data-action="'.$delete.'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.48 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status_badge', 'action'])
                ->toJson();
        }

        $invoice = new AdminInvoice(['status' => 'unpaid']);
        $admins = $this->adminOptions();

        return view('master.invoice.index', [
            'invoice' => $invoice,
            'admins'  => $admins,
        ]);
    }

    public function data(Request $request)
    {
        return $this->index($request);
    }

    public function store(Request $request)
    {
        $data = $this->validateInvoice($request);

        if ($data['status'] === 'paid' && empty($data['tgl_lunas'])) {
            $data['tgl_lunas'] = now()->toDateString();
        }

        AdminInvoice::create($data);

        return redirect()->route('master.invoice.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function print(AdminInvoice $invoice)
    {
        $invoice->load('user');
        $logoPath = public_path('assets/logo/abt_logo.png');
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = 'png';
        }
        $data['invoice'] = $invoice;
        $pdf = Pdf::loadView('master.invoice.print', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice-'.$invoice->id.'.pdf');
    }

    public function destroy(AdminInvoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('master.invoice.index')
            ->with('success', 'Invoice deleted.');
    }

    private function validateInvoice(Request $request): array
    {
        $data = $request->validate([
            'jenis_pembayaran' => ['required', 'string', 'in:Biaya Lisensi Instalasi,Biaya Perpanjangan Maintenance dan Server,Biaya Bimbingan Teknis,Biaya Migrasi Ulang,Biaya Aktivasi WA Gateway'],
            'tgl_invoice'      => ['required', 'date'],
            'tgl_lunas'        => ['nullable', 'date', 'after_or_equal:tgl_invoice'],
            'status'           => ['required', 'in:paid,unpaid'],
            'jumlah'           => ['required', 'numeric', 'min:0'],
            'user_id'          => ['required', 'exists:admin_user,id'],
        ]);

        // Normalize empty strings (flatpickr sends "" when no value picked) → null
        foreach (['tgl_lunas'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        return $data;
    }

    private function adminOptions()
    {
        return AdminUser::orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'email']);
    }
}
