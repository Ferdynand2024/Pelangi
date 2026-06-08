<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact'); // sesuaikan dengan nama blade-mu
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Kirim email ke admin (atau simpan ke DB)
        ContactMessage::create($validated);


        return back()->with('success', 'Pesan Anda telah dikirim. Terima kasih!');
    }
}
