<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('admin.pages.blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        return view('admin.pages.blogs.show', compact('blog'));
    }

    public function create()
    {
        return view('admin.pages.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'read_time' => 'nullable|string|max:50',
            'date' => 'nullable|string|max:50',
            'content' => 'nullable|string', // json or string
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Wrap content into an array if needed, since the original code expects array of paragraphs
        // or just accept string and update the views accordingly. We'll store it as array for compatibility.
        $contentLines = array_filter(array_map('trim', explode(PHP_EOL, $validated['content'] ?? '')));
        $validated['content'] = $contentLines;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        // Convert content back to string for textarea
        $blogContent = is_array($blog->content) ? implode(PHP_EOL, $blog->content) : $blog->content;
        return view('admin.pages.blogs.edit', compact('blog', 'blogContent'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'read_time' => 'nullable|string|max:50',
            'date' => 'nullable|string|max:50',
            'content' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        $contentLines = array_filter(array_map('trim', explode(PHP_EOL, $validated['content'] ?? '')));
        $validated['content'] = $contentLines;

        if ($request->hasFile('image')) {
            if ($blog->image && !Str::startsWith($blog->image, 'http')) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        } else {
            unset($validated['image']);
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && !Str::startsWith($blog->image, 'http')) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
