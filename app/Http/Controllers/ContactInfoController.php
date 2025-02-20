<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactInfoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'logo1' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'logo2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'logo3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'logo4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Initialize an empty array to store logo paths
        $logos = [];

        // Iterate through each logo and store it if the file exists
        foreach (['logo1', 'logo2', 'logo3', 'logo4'] as $logo) {
            if ($request->hasFile($logo)) {
                $logos[$logo] = $request->file($logo)->store('logos');
            }
        }

        // Create the contact information record with the logos
        ContactInfo::create([
            'address' => $data['address'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'logo1' => $logos['logo1'] ?? null,
            'logo2' => $logos['logo2'] ?? null,
            'logo3' => $logos['logo3'] ?? null,
            'logo4' => $logos['logo4'] ?? null,
        ]);

        return redirect()->route('pdrrmo-home.index')->with('success', 'Contact information updated successfully!');
    }

    public function edit($id)
    {
        $contactInfo = ContactInfo::find($id);

        if (!$contactInfo) {
            return redirect()->route('contact-info.index')->with('error', 'Contact information not found.');
        }

        return view('contact.edit', compact('contactInfo'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'logo1' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'logo2' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'logo3' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'logo4' => 'nullable|image|mimes:jpg,png,jpeg,gif',
        ]);

        $contactInfo = ContactInfo::find($id);

        // Update the basic fields
        $contactInfo->address = $validated['address'];
        $contactInfo->email = $validated['email'];
        $contactInfo->phone = $validated['phone'];

        // Iterate through each logo field, deleting the old ones and storing the new ones
        foreach (['logo1', 'logo2', 'logo3', 'logo4'] as $logo) {
            if ($request->hasFile($logo)) {
                // Delete the old image from storage if it exists
                if ($contactInfo->$logo) {
                    Storage::delete($contactInfo->$logo);
                }
                // Store the new logo and update the contact information
                $contactInfo->$logo = $request->file($logo)->store('logos');
            }
        }

        // Save the updated contact information
        $contactInfo->save();

        return redirect()->route('pdrrmo-home.index')->with('success', 'Contact information updated successfully!');
    }
}
