<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $contactInfo = ContactInfo::first();

        return view('contact.index', compact('contacts', 'contactInfo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'focal_person' => 'required|string|max:255',
            'contact_number' => 'required|digits_between:10,15',
            'email' => 'required|email|max:255',
            'response_team' => 'required|string|max:255',
        ]);

        Contact::create($validated);

        return redirect()->route('contact.index')->with('success', 'Contact added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'focal_person' => 'required|string|max:255',
            'contact_number' => 'required|digits_between:10,15',
            'email' => 'required|email|max:255',
            'response_team' => 'required|string|max:255',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validated);

        return redirect()->route('contact.index')->with('success', 'Contact updated successfully!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully!');
    }
}
