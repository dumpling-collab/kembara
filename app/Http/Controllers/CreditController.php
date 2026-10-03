<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Paket top up. KEY = jumlah credit, VALUE = harga Rupiah + label badge.
     *
     * CATATAN: ini pembayaran TIRUAN — begitu tombol diklik, credit langsung
     * masuk tanpa proses pembayaran sungguhan. Untuk produksi nanti, ini
     * perlu disambungkan ke payment gateway (Midtrans/Xendit, dll) sebelum
     * credit ditambahkan.
     */
    public const PACKAGES = [
        350 => ['price' => 34900, 'badge' => 'Best Value'],
        160 => ['price' => 17900, 'badge' => 'Best Deal'],
        80 => ['price' => 9900, 'badge' => 'For you'],
    ];

    public function index()
    {
        return view('credit.top-up', ['packages' => self::PACKAGES]);
    }

    public function purchase(Request $request, int $amount)
    {
        abort_unless(array_key_exists($amount, self::PACKAGES), 404);

        $request->user()->increment('credits', $amount);

        return redirect()->route('challenge.index')->with('status', "+{$amount} Credits berhasil ditambahkan!");
    }
}
