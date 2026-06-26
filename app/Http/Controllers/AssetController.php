<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Branch;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('branch')->orderBy('created_at', 'desc')->paginate(15);
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('assets.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_code' => 'required|unique:assets,asset_code',
            'name' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id',
            'purchase_price' => 'numeric|min:0',
        ]);

        Asset::create($request->all());

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $branches = Branch::all();
        return view('assets.edit', compact('asset', 'branches'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'asset_code' => 'required|unique:assets,asset_code,' . $asset->id,
            'name' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id',
            'purchase_price' => 'numeric|min:0',
        ]);

        $asset->update($request->all());

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
