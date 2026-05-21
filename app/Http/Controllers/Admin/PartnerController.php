<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->get('search');
    
    $partners = Partner::when($search, function ($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%");
    })
    ->latest()
    ->paginate(10)
    ->withQueryString();

    return view('admin.partners.index', compact('partners', 'search'));
    }
    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'website' => 'nullable|url|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'website' => $request->website,
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $data['logo'] = $path;
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil ditambahkan');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'website' => 'nullable|url|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'website' => $request->website,
        ];

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::delete('public/' . $partner->logo);
            }
            $path = $request->file('logo')->store('partners', 'public');
            $data['logo'] = $path;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil diupdate!');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        if ($partner->logo) {
            Storage::delete('public/' . $partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil dihapus!');
    }
}