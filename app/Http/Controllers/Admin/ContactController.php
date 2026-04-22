<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-contacts|create-contacts|edit-contacts|delete-contacts', ['only' => ['index','show']]);
        $this->middleware('permission:create-contacts', ['only' => ['create','store']]);
        $this->middleware('permission:edit-contacts', ['only' => ['edit']]);
        $this->middleware('permission:delete-contacts', ['only' => ['destroy']]);
    }
    public function index()
    {
        $type = request('type', 'contact');
        $contacts = Contact::where('type', $type)->latest()->paginate(10);
        $contactCount = Contact::where('type', 'contact')->count();
        $demoCount = Contact::where('type', 'demo')->count();

        return view('admin.contacts.index', compact('contacts', 'type', 'contactCount', 'demoCount'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {

        $contact->delete();
        return redirect()->route('contacts.index')->with('message', 'Mesaj uğurla silindi');

    }
}
