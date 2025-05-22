<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('user')->get();
        return view('dashboards.admin.addresses.index', compact('addresses'));
    }

    public function create()
    {
        $users = User::all();
        return view('dashboards.admin.addresses.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => ['required', 'string', 'regex:/^\d{2}-\d{3}$/'],
            'country' => 'required|string|max:255',
        ], [
            'zip_code.regex' => 'Kod pocztowy musi być w formacie XX-XXX (np. 00-000)',
        ]);

        Address::create($request->all());

        return redirect()->route('admin.addresses.index')
            ->with('success', 'Adres został dodany pomyślnie!');
    }

    public function edit($id)
    {
        $address = Address::findOrFail($id);
        $users = User::all();
        return view('dashboards.admin.addresses.edit', compact('address', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => ['required', 'string', 'regex:/^\d{2}-\d{3}$/'],
            'country' => 'required|string|max:255',
        ], [
            'zip_code.regex' => 'Kod pocztowy musi być w formacie XX-XXX (np. 00-000)',
        ]);

        $address = Address::findOrFail($id);
        $address->update($request->all());

        return redirect()->route('admin.addresses.index')
            ->with('success', 'Adres został zaktualizowany pomyślnie!');
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return redirect()->route('admin.addresses.index')
            ->with('success', 'Adres został usunięty pomyślnie!');
    }
}
