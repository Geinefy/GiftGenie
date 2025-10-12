<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormMail;
use App\Mail\ContactAutoReplyMail;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Prepare contact data
            $contactData = [
                'name' => trim($request->name),
                'email' => trim(strtolower($request->email)),
                'subject' => trim($request->subject),
                'message' => trim($request->message),
                'timestamp' => now()
            ];

            // Validate email format again to be sure
            if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()
                    ->with('error', 'Please provide a valid email address.')
                    ->withInput();
            }

            $adminEmail = config('mail.from.address');
            
            // Send email to admin first
            try {
                Mail::to($adminEmail)->send(new ContactFormMail($contactData));
                Log::info('Admin notification email sent successfully');
            } catch (\Exception $adminEmailError) {
                Log::error('Failed to send admin notification email: ' . $adminEmailError->getMessage());
                // Continue to try sending user confirmation
            }

            // Send auto-reply confirmation email to the user
            try {
                Mail::to($contactData['email'])->send(new ContactAutoReplyMail($contactData));
                Log::info('User confirmation email sent successfully');
            } catch (\Exception $userEmailError) {
                Log::error('Failed to send user confirmation email: ' . $userEmailError->getMessage());
                // Don't fail the whole process if user email fails
            }

            // Log the successful submission
            Log::info('Contact form submission processed successfully', [
                'name' => $contactData['name'],
                'email' => $contactData['email'],
                'subject' => $contactData['subject']
            ]);

            return redirect()->back()->with('success', 'Thank you for your message! We have received your inquiry and will get back to you within 24 hours.');

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage(), [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Sorry, there was an error processing your message. Please try again in a few moments.')
                ->withInput();
        }
    }
}