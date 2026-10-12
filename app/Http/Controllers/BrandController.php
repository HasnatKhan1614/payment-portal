<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $brands = Brand::orderBy('created_at', 'DESC')
            ->get();

        return view('brand.index',['brands' => $brands]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $validator = Validator::make($request->all(), Brand::$rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Upload the logo file to the public/storage/logo directory
        if ($request->hasFile('logo_path')) {
            $logoPath = $request->file('logo_path')->store('logo', 'public');
        } else {
            $logoPath = null; // Set to null if no file is uploaded
        }
    
        // Create the brand with the UID included
        $brand = Brand::create([
            'name' => $request->input('name'),
            // 'redirect_url' => request()->redirect_url, // Save the path to the uploaded file
            'logo_path' => $logoPath, // Save the path to the uploaded file
            // Add other fields as needed
        ]);
        
        if ($brand) {
            return response()->json(['message' => 'Brand created successfully', 'brand' => $brand], 201);
        } else {
            return response()->json(['message' => 'Failed to create brand'], 500);
        }
    }


    public function create(){
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        return view('brand.create');
    }

    public function edit($id){
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        $brand = Brand::find($id);

        return view('brand.edit',['brand' => $brand]);
    }

    public function show(Brand $brand)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }
        return $brand;
    }

    public function update(Request $request, Brand $brand)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $validator = Validator::make($request->all(), Brand::$rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Upload the logo file to the public/storage/logo directory if a new file is provided
        if ($request->hasFile('logo_path')) {
            // Delete the existing logo file if it exists
            if ($brand->logo_path) {
                Storage::disk('public')->delete($brand->logo_path);
            }
            // Upload the new logo file
            $logoPath = $request->file('logo_path')->store('logo', 'public');
        }
    
        // Update the brand with the new data
        $brand->update([
            'name' => $request->input('name'),
            'logo_path' => $logoPath, // Save the path to the uploaded file
            // 'redirect_url' => request()->redirect_url, // Save the path to the uploaded file
        ]);
    
        return response()->json(['message' => 'Brand updated successfully', 'brand' => $brand], 200);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!Auth::user()->is_admin) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $hasPayments = Payment::withTrashed()
            ->where('brand_id', $brand->id)
            ->exists();
        if ($hasPayments) {
            return back()->with('message', 'Cannot delete brand: it has related payments.');
        }

        $brand->delete();
        return back()->with('message','Brand deleted successfully');
    }
}

