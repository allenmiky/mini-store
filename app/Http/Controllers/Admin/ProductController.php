<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use RuntimeException;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        
        $stats = [
            'total' => $products->count(),
            'active' => Product::where('status', 'active')->count(),
            'out_of_stock' => Product::where('stock', 0)->count()
        ];
        
        return view('admin.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $imageUrl = null;
        $publicId = null;

        if ($request->hasFile('image')) {
            ['image_url' => $imageUrl, 'public_id' => $publicId] = $this->uploadToCloudinary(
                $request->file('image')->getRealPath(),
                $request->file('image')->getMimeType(),
                $request->file('image')->getClientOriginalName()
            );
        }

        Product::create([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image_url' => $imageUrl,
            'cloudinary_public_id' => $publicId,
            'stock' => $request->stock,
            'status' => $request->status
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3|max:100',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('image')) {
            $this->deleteProductImage($product);

            ['image_url' => $product->image_url, 'public_id' => $product->cloudinary_public_id] = $this->uploadToCloudinary(
                $request->file('image')->getRealPath(),
                $request->file('image')->getMimeType(),
                $request->file('image')->getClientOriginalName()
            );
        }

        $product->name = $request->name;
        $product->slug = strtolower(str_replace(' ', '-', $request->name));
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $this->deleteProductImage($product);

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate(['stock' => 'required|integer|min:0']);
        
        $product->stock = $request->stock;
        $product->save();
        
        return response()->json([
            'success' => true,
            'new_stock' => $product->stock
        ]);
    }

    private function uploadToCloudinary(string $filePath, ?string $mimeType, string $originalName): array
    {
        $config = $this->cloudinaryConfig();
        $timestamp = time();
        $folder = 'products';
        $signature = sha1("folder={$folder}&timestamp={$timestamp}{$config['api_secret']}");
        $endpoint = "https://api.cloudinary.com/v1_1/{$config['cloud_name']}/image/upload";

        $response = $this->sendCloudinaryRequest($endpoint, [
            'file' => curl_file_create($filePath, $mimeType ?: 'application/octet-stream', $originalName),
            'api_key' => $config['api_key'],
            'timestamp' => $timestamp,
            'folder' => $folder,
            'signature' => $signature,
        ]);

        if (empty($response['secure_url']) || empty($response['public_id'])) {
            throw new RuntimeException('Cloudinary upload failed.');
        }

        return [
            'image_url' => $response['secure_url'],
            'public_id' => $response['public_id'],
        ];
    }

    private function deleteProductImage(Product $product): void
    {
        if ($product->cloudinary_public_id) {
            $this->deleteFromCloudinary($product->cloudinary_public_id);
            return;
        }

        $this->deleteStoredImage($product->image_url);
    }

    private function deleteFromCloudinary(string $publicId): void
    {
        $config = $this->cloudinaryConfig();
        $timestamp = time();
        $signature = sha1("public_id={$publicId}&timestamp={$timestamp}{$config['api_secret']}");
        $endpoint = "https://api.cloudinary.com/v1_1/{$config['cloud_name']}/image/destroy";

        $this->sendCloudinaryRequest($endpoint, [
            'public_id' => $publicId,
            'api_key' => $config['api_key'],
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);
    }

    private function cloudinaryConfig(): array
    {
        $url = env('CLOUDINARY_URL');

        if (! $url) {
            throw new RuntimeException('CLOUDINARY_URL is not configured.');
        }

        $parts = parse_url($url);

        if (! isset($parts['host'], $parts['user'], $parts['pass'])) {
            throw new RuntimeException('CLOUDINARY_URL is invalid.');
        }

        return [
            'cloud_name' => $parts['host'],
            'api_key' => $parts['user'],
            'api_secret' => $parts['pass'],
        ];
    }

    private function sendCloudinaryRequest(string $endpoint, array $payload): array
    {
        $handle = curl_init($endpoint);

        curl_setopt_array($handle, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $rawResponse = curl_exec($handle);

        if ($rawResponse === false) {
            $message = curl_error($handle);
            curl_close($handle);

            throw new RuntimeException('Cloudinary request failed: '.$message);
        }

        $statusCode = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);

        $response = json_decode($rawResponse, true);

        if ($statusCode >= 400) {
            $message = $response['error']['message'] ?? 'Unknown Cloudinary error.';
            throw new RuntimeException('Cloudinary request failed: '.$message);
        }

        return is_array($response) ? $response : [];
    }

    private function deleteStoredImage(?string $imageUrl): void
    {
        if (! $imageUrl) {
            return;
        }

        $path = ltrim((string) parse_url($imageUrl, PHP_URL_PATH), '/');

        if (str_starts_with($path, 'storage/')) {
            @unlink(storage_path('app/public/'.substr($path, 8)));
        }
    }
}
