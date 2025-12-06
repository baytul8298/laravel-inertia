<?php

namespace App\Repositories;

use App\Interface\SkillRepositoryInterface;
use App\Models\Skill;
use Illuminate\Support\Facades\Storage;

class SkillRepository implements SkillRepositoryInterface
{
    public function all()
    {
        return Skill::with('skillItems')->latest()->get();
    }

    public function find($id)
    {
    }

    public function store($request, array $data)
    {
        $skillData = [
            'name'       => $data['name'],
            'title'      => $data['title'],
            'description'=> $data['description'] ?? null,
            'is_active'  => $data['is_active'],
        ];

        if ($request->hasFile('image')) {
            $skillData['image'] = $request->file('image')->store('skill', 'public');
        }

        $skill = Skill::create($skillData);

        if (!empty($data['skill_items'])) {
            foreach ($data['skill_items'] as $item) {
                $skill->skillItems()->create([
                    'name'       => $item['name'],
                    'percentage' => $item['percentage'],
                ]);
            }
        }

        return $skill;
    }

    public function update($id, $request, array $data)
    {
        $skill = Skill::findOrFail($id);
        $skillData = [
            'name'       => $data['name'],
            'title'      => $data['title'],
            'description'=> $data['description'] ?? null,
            'is_active'  => $data['is_active'],
        ];

        if ($request->hasFile('image')) {
            if ($skill->image && Storage::disk('public')->exists($skill->image)) {
                Storage::disk('public')->delete($skill->image);
            }
            $skillData['image'] = $request->file('image')->store('skill', 'public');
        }

        $skill->update($skillData);

        if (!empty($data['skill_items'])) {
            $existingItemIds = [];
            foreach ($data['skill_items'] as $itemData) {

                if (!empty($itemData['id'])) {
                    $skillItem = $skill->skillItems()->find($itemData['id']);
                    if ($skillItem) {
                        $skillItem->update([
                            'name'       => $itemData['name'],
                            'percentage' => $itemData['percentage'],
                        ]);
                        $existingItemIds[] = $itemData['id'];
                    }
                } else {
                    $newItem = $skill->skillItems()->create([
                        'name'       => $itemData['name'],
                        'percentage' => $itemData['percentage'],
                    ]);
                    $existingItemIds[] = $newItem->id;
                }
            }

            $skill->skillItems()->whereNotIn('id', $existingItemIds)->delete();
        } else {
            $skill->skillItems()->delete();
        }

        return $skill;
    }

    public function delete($id)
    {
    }
}
