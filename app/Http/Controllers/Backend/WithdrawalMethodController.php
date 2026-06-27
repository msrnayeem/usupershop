<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;

class WithdrawalMethodController extends Controller
{
    public function index()
    {
        $methods = WithdrawalMethod::orderBy('sort_order')->get();
        return view('backend.withdrawal-methods.index', compact('methods'));
    }

    public function create()
    {
        return view('backend.withdrawal-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:100|unique:withdrawal_methods,name',
            'logo_emoji'         => 'nullable|string|max:10',
            'logo_color'         => 'nullable|string|max:20',
            'account_label'      => 'required|string|max:100',
            'account_placeholder'=> 'nullable|string|max:200',
            'account_regex'      => 'nullable|string|max:200',
            'instructions'       => 'nullable|string',
            'sort_order'         => 'nullable|integer|min:0',
        ], [
            'name.unique' => 'এই নামে আগেই একটি payment method আছে।',
        ]);

        WithdrawalMethod::create([
            'name'               => $request->name,
            'logo_emoji'         => $request->logo_emoji ?? '💳',
            'logo_color'         => $request->logo_color ?? '#333',
            'account_label'      => $request->account_label,
            'account_placeholder'=> $request->account_placeholder,
            'account_regex'      => $request->account_regex,
            'is_active'          => $request->has('is_active') ? 1 : 0,
            'sort_order'         => $request->sort_order ?? 99,
            'instructions'       => $request->instructions,
        ]);

        return redirect()->route('withdrawal.methods.index')
            ->with('success', "✅ {$request->name} payment method যোগ হয়েছে!");
    }

    public function edit($id)
    {
        $method = WithdrawalMethod::findOrFail($id);
        return view('backend.withdrawal-methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = WithdrawalMethod::findOrFail($id);

        $request->validate([
            'name'               => "required|string|max:100|unique:withdrawal_methods,name,{$id}",
            'account_label'      => 'required|string|max:100',
        ]);

        $method->update([
            'name'               => $request->name,
            'logo_emoji'         => $request->logo_emoji ?? $method->logo_emoji,
            'logo_color'         => $request->logo_color ?? $method->logo_color,
            'account_label'      => $request->account_label,
            'account_placeholder'=> $request->account_placeholder,
            'account_regex'      => $request->account_regex,
            'is_active'          => $request->has('is_active') ? 1 : 0,
            'sort_order'         => $request->sort_order ?? $method->sort_order,
            'instructions'       => $request->instructions,
        ]);

        return redirect()->route('withdrawal.methods.index')
            ->with('success', "✅ {$method->name} আপডেট হয়েছে!");
    }

    public function toggleActive($id)
    {
        $method            = WithdrawalMethod::findOrFail($id);
        $method->is_active = $method->is_active ? 0 : 1;
        $method->save();
        $status = $method->is_active ? 'Active' : 'Inactive';
        return back()->with('success', "{$method->name} → {$status}");
    }

    public function destroy($id)
    {
        $method = WithdrawalMethod::findOrFail($id);
        $name   = $method->name;
        $method->delete();
        return back()->with('success', "✅ {$name} মুছে ফেলা হয়েছে।");
    }
}
