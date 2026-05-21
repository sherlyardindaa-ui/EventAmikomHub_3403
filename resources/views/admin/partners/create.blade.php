@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">

    <h1 class="text-2xl font-bold mb-6">Tambah Partner</h1>

    <form action="{{ route('admin.partners.store') }}" method="POST" class="space-y-5 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label class="block font-medium">Nama Partner</label>
            <input type="text" name="name"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div>
            <label class="block font-medium">Logo URL</label>
            <input type="url" name="logo_url"
                   class="w-full border rounded p-2"
                   placeholder="https://placehold.co/200x200"
                   required>
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Simpan
        </button>

    </form>

</div>
@endsection