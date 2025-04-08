<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use App\Models\PhoneNumber;
use App\Models\Email;
// use Illuminate\Http\Request;

class contactController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contacts::with(['phoneNumbers', 'emails'])->get();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_numbers.*' => 'nullable|string|max:15',
            'emails.*' => 'nullable|email|max:255'
        ]);

        $contact = Contacts::create($request->only(['name', 'company', 'address']));

        if ($request->phone_numbers) {
            foreach ($request->phone_numbers as $phone) {
                if (!empty($phone)) {
                    PhoneNumber::create([
                        'contacts_id' => $contact->id,
                        'phone_number' => $phone,
                        'type' => 'Mobile' // Default type, can be changed in UI
                    ]);
                }
            }
        }

        if ($request->emails) {
            foreach ($request->emails as $email) {
                if (!empty($email)) {
                    Email::create([
                        'contacts_id' => $contact->id,
                        'email' => $email,
                        'type' => 'Personal' // Default type, can be changed in UI
                    ]);
                }
            }
        }

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $contacts = Contacts::findOrFail($id); // Throws 404 if not found
    //     return view('contacts.index', compact('contacts'));
    // }
    public function edit($id)
    {
    $contact = Contacts::with(['phoneNumbers', 'emails'])->findOrFail($id);
    return view('contacts.create', compact('contact')); // Load the same create.blade.php
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Contacts $contact)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'company' => 'nullable|string|max:255',
    //         'address' => 'nullable|string|max:255',
    //         'phone_numbers.*' => 'nullable|string|max:15',
    //         'emails.*' => 'nullable|email|max:255'
    //     ]);

    //     $contact->update($request->only(['name', 'company', 'address']));

    //     // Update or delete existing phone numbers
    //     $contact->phoneNumbers()->delete();
    //     if ($request->phone_numbers) {
    //         foreach ($request->phone_numbers as $phone) {
    //             if (!empty($phone)) {
    //                 PhoneNumber::create([
    //                     'contact_id' => $contact->id,
    //                     'phone_number' => $phone,
    //                     'type' => 'Mobile'
    //                 ]);
    //             }
    //         }
    //     }

    //     // Update or delete existing emails
    //     $contact->emails()->delete();
    //     if ($request->emails) {
    //         foreach ($request->emails as $email) {
    //             if (!empty($email)) {
    //                 Email::create([
    //                     'contact_id' => $contact->id,
    //                     'email' => $email,
    //                     'type' => 'Personal'
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');

    // }

//     public function update(Request $request, Contacts $contact)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'phone_numbers' => 'array',
//         'phone_numbers.*' => 'string|max:20',
//         'emails' => 'array',
//         'emails.*' => 'email|max:255',
//     ]);

//     // Update contact name
//     $contact->update([
//         'name' => $request->name,
//     ]);

//     // Clear old phone numbers and emails
//     $contact->phoneNumbers()->delete();
//     $contact->emails()->delete();

//     // Re-insert phone numbers
//     foreach ($request->phone_numbers as $phone) {
//         $contact->phoneNumbers()->create([
//             'phone_number' => $phone,
//             'type' => 'Mobile',  // Modify as needed
//         ]);
//     }

//     // Re-insert emails
//     foreach ($request->emails as $email) {
//         $contact->emails()->create([
//             'email' => $email,
//         ]);
//     }

//     return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
// public function update(Request $request, Contacts $contact)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'phone_numbers' => 'array',
//         'phone_numbers.*' => 'string|max:20',
//         'emails' => 'array',
//         'emails.*' => 'email|max:255',
//     ]);

//     // Update contact name
//     $contact->update([
//         'name' => $request->name,
//     ]);

//     // Get current IDs
//     $existingPhones = $contact->phoneNumbers()->pluck('phone_number')->toArray();
//     $existingEmails = $contact->emails()->pluck('email')->toArray();

//     // Delete missing phone numbers
//     $contact->phoneNumbers()->whereNotIn('phone_number', $request->phone_numbers)->delete();
//     // Delete missing emails
//     $contact->emails()->whereNotIn('email', $request->emails)->delete();

//     // Add new phone numbers
//     foreach ($request->phone_numbers as $phone) {
//         if (!in_array($phone, $existingPhones)) {
//             $contact->phoneNumbers()->create(['phone_number' => $phone, 'type' => 'Mobile']);
//         }
//     }

//     // Add new emails
//     foreach ($request->emails as $email) {
//         if (!in_array($email, $existingEmails)) {
//             $contact->emails()->create(['email' => $email]);
//         }
//     }

//     return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
// }

public function update(Request $request, Contacts $contact)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_numbers' => 'nullable|array',
        'phone_numbers.*' => 'nullable|string|max:20',
        'emails' => 'nullable|array',
        'emails.*' => 'nullable|email|max:255',
    ]);

    // Update contact name
    $contact->update(['name' => $request->name]);

    // Delete phone numbers not in the request
    $contact->phoneNumbers()->whereNotIn('phone_number', $request->phone_numbers ?? [])->delete();

    // Delete emails not in the request
    $contact->emails()->whereNotIn('email', $request->emails ?? [])->delete();

    // Insert new phone numbers only if provided
    if ($request->phone_numbers) {
        foreach ($request->phone_numbers as $phone) {
            if (!$contact->phoneNumbers()->where('phone_number', $phone)->exists()) {
                $contact->phoneNumbers()->create(['phone_number' => $phone, 'type' => 'Mobile']);
            }
        }
    }

    // Insert new emails only if provided
    if ($request->emails) {
        foreach ($request->emails as $email) {
            if (!$contact->emails()->where('email', $email)->exists()) {
                $contact->emails()->create(['email' => $email]);
            }
        }
    }

    return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacts $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
