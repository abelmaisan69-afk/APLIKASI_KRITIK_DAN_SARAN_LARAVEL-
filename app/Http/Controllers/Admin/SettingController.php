<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function usaha()    { return view('admin.settings.usaha'); }
    public function homepage() { return view('admin.settings.homepage'); }
    public function branding() { return view('admin.settings.branding'); }

    public function updateUsaha(Request $request)
    {
        $data = $request->validate([
            'nama_usaha'      => 'required|string|max:100',
            'tahun_berdiri'   => 'nullable|digits:4',
            'alamat'          => 'nullable|string|max:300',
            'whatsapp'        => ['nullable', 'regex:/^[0-9+\s-]{8,20}$/'],
            'email'           => 'nullable|email|max:100',
            'instagram'       => ['nullable', 'regex:/^@?[A-Za-z0-9._]{1,30}$/'],
            'jam_operasional' => 'nullable|string|max:200',
            'deskripsi_usaha' => 'nullable|string|max:1000',
        ], [
            'whatsapp.regex'  => 'Nomor WhatsApp hanya boleh angka, spasi, + dan -.',
            'instagram.regex' => 'Isi username saja, contoh: @namausaha.',
        ]);

        Setting::put($data);

        return back()->with('sukses', 'Pengaturan usaha disimpan.');
    }

    public function updateHomepage(Request $request)
    {
        $data = $request->validate([
            'hero_headline'    => 'required|string|max:150',
            'hero_subheadline' => 'nullable|string|max:300',
            'hero_btn1_text'   => 'required|string|max:40',
            'hero_btn2_text'   => 'required|string|max:40',
            'about_story'      => 'nullable|string|max:3000',
            'visi'             => 'nullable|string|max:500',
            'misi'             => 'nullable|string|max:1500',
            'nilai'            => 'nullable|string|max:1000',
            'cta_title'        => 'required|string|max:150',
            'cta_text'         => 'nullable|string|max:300',
            'footer_text'      => 'nullable|string|max:300',
            'hero_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $this->simpan($request, $data, ['hero_image', 'about_photo']);

        return back()->with('sukses', 'Pengaturan homepage disimpan.');
    }

    public function updateBranding(Request $request)
    {
        $warna = ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'];

        $data = $request->validate([
            'nama_usaha'      => 'required|string|max:100',
            'color_primary'   => $warna,
            'color_secondary' => $warna,
            'color_accent'    => $warna,
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon'         => 'nullable|image|mimes:png,jpg,jpeg,webp|max:512',
            'bg_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'color_button' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

                if ($request->boolean('button_sama')) {
    $data['color_button'] = null; // kosong = ikut warna utama
}

        $this->simpan($request, $data, ['logo', 'favicon', 'bg_image']);

        return back()->with('sukses', 'Branding disimpan dan langsung berlaku di seluruh website.');
    }

    // Simpan teks + upload file (file lama dihapus saat diganti)
    private function simpan(Request $request, array $data, array $fileKeys): void
    {
        $lama = Setting::semua();

        foreach ($fileKeys as $key) {
            unset($data[$key]);

            if ($request->hasFile($key)) {
                if (! empty($lama[$key])) {
                    Storage::disk('public')->delete($lama[$key]);
                }
                $data[$key] = $request->file($key)->store('site', 'public');
            }
        }

        Setting::put($data);
    }
}
