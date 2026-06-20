<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('backend.pages.view-page', compact('pages'));
    }

    // Show the create form
    public function create()
    {
        return view('backend.pages.add-page');
    }

    // Store a new page
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pages'
        ]);
       	
        Page::create([
            'name'=>$request->name,
            'page-slug'=>Str::slug($request->name),
            'description'=>$request->description
        ]);

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    // Show the edit form
    public function edit(Page $page)
    {
        return view('backend.pages.add-page', compact('page'));
    }

    // Update a page
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required|unique:pages,name,'.$page->id
        ]);

        $page->update($request->all());

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    // Delete a page
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }

    // Show a single page by name (for frontend)
    public function show($name)
    {
        $page = Page::where('name', $name)->firstOrFail();
        return view('pages.show', compact('page'));
    }
}
