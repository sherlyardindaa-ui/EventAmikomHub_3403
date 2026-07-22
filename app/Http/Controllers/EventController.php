<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;

class EventController extends Controller
{
    /**
     * Menampilkan detail event tertentu
     */
    public function show(Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer/navigasi
        $categories = Category::all();
        
        // Me-render view dengan membawa data kategori dan data spesifik acara tersebut
        return view('event-detail', compact('categories', 'event'));
    }

    /**
     * Menampilkan halaman checkout
     */
    function checkout(){
        return view('checkout');
    }

    /**
     * Menampilkan halaman tiket
     */
    function ticket(){
        return view('ticket');
    }

    /**
     * Menampilkan event berdasarkan kategori (slug)
     */
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $events = Event::where('category_id', $category->id)->get();
        $categories = Category::all(); // tambahin ini untuk navigasi

        return view('katalog', compact('events', 'category', 'categories'));
    }

    /**
     * Filter event berdasarkan kategori (AJAX)
     */
    public function filterByCategory(Request $request)
    {
        $query = Event::query();

        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $events = $query->latest()->get();

        return response()->json($events);
    }
}