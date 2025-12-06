<?php

namespace App\Http\Controllers;

use App\Models\TechStack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Technology/Index', [
            'technologies' => TechStack::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active'   => 'required|boolean',
        ]);

        $data = $request->only(['name', 'title', 'description', 'is_active']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('technology', 'public');
        }

        TechStack::create($data);

        return back()->with('success', 'Tech created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tech = TechStack::find($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active'   => 'required|boolean',
        ]);

        $data = $request->only(['name', 'title', 'description', 'is_active']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($tech->image && Storage::disk('public')->exists($tech->image)) {
                Storage::disk('public')->delete($tech->image);
            }
            $data['image'] = $request->file('image')->store('technology', 'public');
        }
        $tech->update($data);

        return back()->with('success', 'Tech updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
