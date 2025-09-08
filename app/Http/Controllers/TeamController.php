<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // عرض الفريق في الصفحة العامة
    public function index()
    {
        $team = Team::all();
        return view('team.index', compact('team'));
    }

    // عرض كل أعضاء الفريق في لوحة تحكم الأدمن
    public function adminIndex()
    {
        $team = Team::all();
        return view('admin.team.index', compact('team'));
    }

    // فورم إضافة عضو
    public function create()
    {
        return view('admin.team.create');
    }

    // تخزين عضو جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'bio']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        Team::create($data);

        return redirect()->route('admin.team.index')->with('success', 'تمت إضافة العضو بنجاح');
    }

    // تعديل عضو
    public function edit(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    // تحديث عضو
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'bio']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'تم تعديل العضو بنجاح');
    }

    // حذف عضو
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'تم حذف العضو');
    }
}
