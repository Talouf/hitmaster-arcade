<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ]);

        $validatedData['user_id'] = Auth::id(); // This will be null for guests
        $validatedData['sent_date'] = now();

        $contactMessage = ContactMessage::create($validatedData);
        if ($contactMessage) {
            try {
                Mail::to('sylhorczak@gmail.com')->send(new ContactFormSubmission($contactMessage));
            } catch (\Exception $e) {
                Log::error('Failed to send email: ' . $e->getMessage());
                return redirect()->route('contact')->with('error', 'Your message was received, but we encountered an error sending the confirmation email.');
            }
    
            return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès !');
        } else {
            return redirect()->route('contact')->with('error', 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.');
        }
    }
}