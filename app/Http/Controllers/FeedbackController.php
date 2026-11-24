<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'  => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'tipe'  => 'required|in:kritik,saran',
            'pesan' => 'required|string|min:10|max:2000',
        ]);

        Feedback::create($data);

        return back()->with('sukses', 'Terima kasih, masukanmu sudah terkirim!');
    }

    // --- Admin ---
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    public function markRead(Feedback $feedback)
    {
        $feedback->update(['sudah_dibaca' => true]);
        return back();
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('sukses', 'Masukan dihapus.');
    }
}
