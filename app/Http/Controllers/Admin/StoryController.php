<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    /**
     * Show the form for creating a new story.
     */
    public function create()
    {
        return view('admin.stories.create');
    }

    /**
     * Store a newly created story in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'option_a' => 'required|string|max:100',
            'option_b' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate a unique slug based on custom slug or title
        $slugSource = $request->slug ?: $request->title;
        $slug = Str::slug($slugSource);
        $originalSlug = $slug;
        $count = 1;

        while (Story::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stories', 'public');
        }

        $story = Story::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Nailathala na ang bagong edisyon!')
            ->with('story_url', route('story.show', $story->slug));
    }
}
