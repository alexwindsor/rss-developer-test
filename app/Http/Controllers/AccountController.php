<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::where('owner_id', auth()->id())->get(['id', 'name', 'town_city', 'country', 'phone']);

        return Inertia::render('Accounts/Index', [
            'accounts' => $accounts
        ]);
    }

    public function show($id)
    {
        $account = Account::find($id, ['id', 'name', 'address', 'town_city', 'country', 'post_code', 'phone']);
        $contacts = Contact::where('account_id', $id)->get(['id', 'first_name', 'last_name', 'email', 'phone', 'position']);

        return Inertia::render('Accounts/Show', [
            'account' => $account,
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        $owners = User::where('active', 1)->get(['id', 'name']);
        return Inertia::render('Accounts/Create', [
            'owners' => $owners,
            'auth_id' => auth()->id()
        ]);
    }

    public function store()
    {
        $new_account = Request::validate([
            'name' => ['required', 'min:2'],
            'owner_id' => ['required', 'integer'],
            'phone' => 'required',
            'country' => 'required',
            'address' => 'required',
            'town_city' => 'required',
            'post_code' => 'required'
        ]);
        Account::create($new_account);
        return redirect('/accounts');
    }

    public function edit($id)
    {
        $account = Account::find($id, ['id', 'owner_id', 'name', 'address', 'town_city', 'country', 'post_code', 'phone']);
        $owners = User::where('active', 1)->get(['id', 'name']);
        return Inertia::render('Accounts/Edit', [
            'account' => $account,
            'owners' => $owners,
            'auth_id' => auth()->id()
        ]);
    }

    public function update($id)
    {
        $new_account = Request::validate([
            'name' => ['required', 'min:2'],
            'owner_id' => ['required', 'integer'],
            'phone' => 'required',
            'country' => 'required',
            'address' => 'required',
            'town_city' => 'required',
            'post_code' => 'required'
        ]);
        Account::where('id', $id)->update($new_account);
        return redirect('/accounts');
    }

    public function destroy($id)
    {
        Account::where('id', $id)->delete();
        return redirect('/accounts');
    }
}
