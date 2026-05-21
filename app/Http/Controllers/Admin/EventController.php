<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $events = Event::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('location', 'LIKE', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.events.index', compact('events', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Upload gambar
        if ($request->hasFile('poster')) {
            $data['image'] = $request->file('poster')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Data event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Kalau upload gambar baru
        if ($request->hasFile('poster')) {

            // hapus gambar lama (biar storage nggak numpuk)
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $data['image'] = $request->file('poster')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Data event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // ✅ hapus gambar juga
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Data event berhasil dihapus.');
    }
}