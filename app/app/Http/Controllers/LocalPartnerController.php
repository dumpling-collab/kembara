<?php

namespace App\Http\Controllers;

use App\Models\PartnerApplication;
use Illuminate\Http\Request;

class LocalPartnerController extends Controller
{
    public const CATEGORIES = ['Kuliner', 'Fashion', 'Lainnya'];

    /** Layar "Tumbuh Bersama Kembara Local Partners" */
    public function index()
    {
        return view('local-partners.index');
    }

    /** Form pengajuan kerja sama */
    public function form()
    {
        return view('local-partners.form', ['categories' => self::CATEGORIES]);
    }

    /**
     * Simpan pengajuan ke database.
     *
     * CATATAN: belum ada dashboard admin untuk meninjau data ini — untuk
     * sekarang pengecekan perlu manual lewat database. Status tersimpan
     * sebagai 'pending', siap dipakai kalau nanti dashboard admin dibangun.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'owner_name' => ['required', 'string', 'max:150'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
            'category' => ['required', 'in:' . implode(',', self::CATEGORIES)],
            'location' => ['required', 'string', 'max:255'],
            'products' => ['required', 'string', 'max:1000'],
            'social_link' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
        ]);

        PartnerApplication::create($data);

        return redirect()->route('local-partners.index')
            ->with('status', 'Pengajuan kamu berhasil dikirim! Tim Kembara akan meninjau dan menghubungimu lewat WhatsApp atau email.');
    }
}
