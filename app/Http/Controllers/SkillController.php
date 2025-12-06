<?php

namespace App\Http\Controllers;

use App\Repositories\SkillRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillController extends Controller
{
    protected $repo;

    public function __construct(SkillRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Skill/Index', [
            'skills' => $this->repo->all(),
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|boolean',

            'skill_items' => 'nullable|array',
            'skill_items.*.name' => 'required|string|max:255',
            'skill_items.*.percentage' => 'required|integer|min:0|max:100',
        ]);

        $this->repo->store($request, $validated);

        return back()->with('success', 'Skill created successfully.');
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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|boolean',

            'skill_items' => 'nullable|array',
            'skill_items.*.id' => 'nullable|integer|exists:skill_items,id',
            'skill_items.*.name' => 'required|string|max:255',
            'skill_items.*.percentage' => 'required|decimal:0,2|min:0|max:100',
        ]);

        $this->repo->update($id, $request, $validated);

        return back()->with('success', 'Skill updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
