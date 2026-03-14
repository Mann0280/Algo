<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the contact messages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Remove the specified contact message from storage.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return back()->with('success', 'Contact message purged from archives.');
    }
}
