<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
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

        $contact = Contact::create($validated);

        event(new ActivityLogged(
            auth()->user()->name,
            'Added a new contact',
            'Contact',
            $contact->id,
            $validated
        ));

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

        $oldData = $contact->toArray();

        $contact->update($validated);

        $changes = array_diff($contact->toArray(), $oldData);

        if (! empty($changes)) {
            event(new ActivityLogged(
                auth()->user()->name,
                'Updated a contact',
                'Contact',
                $contact->id,
                $changes
            ));
        }

        return redirect()->route('contact.index')->with('success', 'Contact updated successfully!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        event(new ActivityLogged(
            auth()->user()->name,
            'Deleted a contact',
            'Contact',
            $contact->id,
            []
        ));

        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully!');
    }
}
