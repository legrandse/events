<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Price;
use Illuminate\Http\Request;


class OwnerController extends Controller
{
    // 🌐 Affiche la liste des owners
    public function index()
    {
        $owners = Owner::all();
        $prices = Price::all();
        return view('owners.index', compact('owners','prices'));
    }

    // 🌐 Formulaire pour créer un owner
    public function create()
    {
    	$prices = Price::all();
        return view('owners.create', compact('prices'));
    }

    // 🌐 Enregistre un nouveau owner
    public function store(Request $request)
    {
        $request->validate([
            'organisation' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:owners,email',
            'gsm' => 'nullable|string|max:20',
        ]);

        Owner::create($request->all());

        return redirect()->route('owners.index')->with('success', 'Owner créé avec succès.');
    }

    // 🌐 Affiche un owner spécifique
    public function show(Owner $owner)
    {
        return view('owners.show', compact('owner'));
    }

    // 🌐 Formulaire pour éditer un owner
    public function edit(Owner $owner)
    {
    	$prices = Price::all();
        return view('owners.edit', compact('owner','prices'));
    }

    // 🌐 Met à jour un owner
    public function update(Request $request, Owner $owner)
    {
        $request->validate([
            'organisation' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:owners,email,' . $owner->id,
            'gsm' => 'nullable|string|max:20',
        ]);

        $owner->update($request->all());

        return redirect()->route('owners.index')->with('success', 'Owner mis à jour avec succès.');
    }

    // 🌐 Supprime un owner
    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index')->with('success', 'Owner supprimé avec succès.');
    }
}
