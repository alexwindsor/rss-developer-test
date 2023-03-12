<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {

        $contacts = Contact::with('account:id,name')->whereHas('account', function (Builder $query) {
            $query->where('owner_id', '=', auth()->id());
        })->get(['id', 'account_id', 'first_name', 'last_name', 'email', 'phone', 'position']);

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts
        ]);

    }

    public function show($id)
    {
        $contact = Contact::with('account')->where('id', $id)->get(['id', 'account_id', 'first_name', 'last_name', 'email', 'phone', 'position']);

        return Inertia::render('Contacts/Show', [
            'contact' => $contact[0]
        ]);
    }

    public function create()
    {
        $accounts = Account::where('owner_id', auth()->id())->get(['id', 'name']);

        return Inertia::render('Contacts/Create', [
        'accounts' => $accounts
        ]);
    }

    public function store()
    {
        $new_contact = Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'account_id' => ['required', 'integer'],
            'phone' => 'required',
            'email' => ['required', 'email'],
            'position' => 'required'
        ]);
        Contact::create($new_contact);
        return redirect('/contacts');

    }

    public function edit($id)
    {
        $contact = Contact::where('id', $id)->first(['id', 'account_id', 'first_name', 'last_name', 'email', 'phone', 'position']);
        $accounts = Account::where('owner_id', auth()->id())->get(['id', 'name']);

        return Inertia::render('Contacts/Edit', [
            'contact' => $contact,
            'accounts' => $accounts
        ]);
    }

    public function update($id)
    {
        $new_contact = Request::validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'account_id' => ['required', 'integer'],
            'email' => 'required',
            'phone' => 'required',
            'position' => 'required'
        ]);

        Contact::where('id', $id)->update($new_contact);
        return redirect('/contacts');
    }

    public function destroy($id)
    {
        Contact::where('id', $id)->delete();
        return redirect('/contacts');
    }
}
