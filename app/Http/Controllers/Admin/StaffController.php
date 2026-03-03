<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    // Show all staff
    public function index()
    {
        $staffs = Staff::all();
        return view('admin.pages.staff.index', compact('staffs'));
    }

    // Show create form
    public function create()
    {
        return view('admin.pages.staff.create');
    }

    // Store new staff
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:staff,phone',
            'email' => 'required|email|unique:staff,email',
            'role' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('staff', 'public');
        }

        Staff::create($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff added successfully.');
    }

    // Show edit form
    public function edit(Staff $staff)
    {
        return view('admin.pages.staff.edit', compact('staff'));
    }

    // Update staff
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:staff,phone,' . $staff->id,
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'role' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }
            $data['image'] = $request->file('image')->store('staff', 'public');
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
    }

    // Delete staff
    public function destroy(Staff $staff)
    {
        if ($staff->image) {
            Storage::disk('public')->delete($staff->image);
        }
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}
