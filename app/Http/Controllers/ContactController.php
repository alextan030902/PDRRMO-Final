<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'focal_person' => 'required|string|max:255',
            'contact_number' => 'required|digits_between:10,15',
            'email' => 'required|email|max:255',
            'response_team' => 'required|string|max:255',
        ]);

        // Create a new contact entry
        Contact::create($validated);

        // Redirect back with success message
        return redirect()->route('contact.index')->with('success', 'Contact added successfully!');
    }

    // public function edit($id)
    // {
    //     $contact = Contact::find($id);

    //     return view('contacts.index', compact('contact'));
    // }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'focal_person' => 'required|string|max:255',
            'contact_number' => 'required|digits_between:10,15',
            'email' => 'required|email|max:255',
            'response_team' => 'required|string|max:255',
        ]);

        // Find the contact by ID and update its data
        $contact = Contact::findOrFail($id);
        $contact->update($validated);

        // Redirect back with success message
        return redirect()->route('contact.index')->with('success', 'Contact updated successfully!');
    }

    public function destroy($id)
    {
        // Find the contact by its ID
        $contact = Contact::findOrFail($id);

        // Delete the contact
        $contact->delete();

        // Redirect back with a success message
        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully!');
    }
}
