<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Product;
use App\Models\User;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LicenseManuallyAssignedMail;

class AdminLicenseController extends Controller
{
    protected LicenseService $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function index(Request $request)
    {
        $query = License::with(['product', 'order', 'buyer']);

        if ($search = $request->input('search')) {
            $query->where('key', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($productId = $request->input('product_id')) {
            $query->where('product_id', $productId);
        }

        $licenses = $query->latest()->paginate(20)->withQueryString();
        $products = Product::whereIn('type', ['license', 'giftcard', 'subscription'])->orderBy('name')->get();

        return view('admin.licenses.index', compact('licenses', 'products'));
    }

    public function create(Request $request)
    {
        $products = Product::whereIn('type', ['license', 'giftcard', 'subscription'])->orderBy('name')->get();
        $selectedProductId = $request->input('product_id');

        return view('admin.licenses.create', compact('products', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'licenses' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $keys = explode("\n", str_replace("\r", "", $request->licenses));
        
        $imported = $this->licenseService->importLicenses($product, $keys);

        return redirect()->route('admin.licenses.index')
            ->with('success', "{$imported} licencias importadas correctamente para {$product->name}");
    }

    public function destroy(License $license)
    {
        $product = $license->product;
        
        // Only delete if it's available (don't delete sold keys)
        if ($license->status !== 'available') {
            return back()->with('error', 'No se puede eliminar una licencia que ya fue vendida o usada.');
        }

        $license->delete();

        // Update product stock
        $product->update([
            'stock' => $this->licenseService->getAvailableCount($product),
        ]);

        return back()->with('success', 'Licencia eliminada correctamente.');
    }

    public function export(Request $request)
    {
        $query = License::with(['product', 'order', 'buyer']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($productId = $request->input('product_id')) {
            $query->where('product_id', $productId);
        }

        $licenses = $query->get();

        $fileName = "licencias_" . date('Y-m-d_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Producto', 'Llave/Código', 'Estado', 'Vendido en (Fecha)'];

        $callback = function() use($licenses, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($licenses as $license) {
                $row['ID']  = $license->id;
                $row['Producto'] = $license->product->name ?? 'N/A';
                $row['Llave/Código'] = $license->key;
                $row['Estado'] = $license->status;
                $row['Vendido en (Fecha)'] = $license->sold_at ? $license->sold_at->format('Y-m-d H:i:s') : 'N/A';

                fputcsv($file, array($row['ID'], $row['Producto'], $row['Llave/Código'], $row['Estado'], $row['Vendido en (Fecha)']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function assign(Request $request, License $license)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if ($license->status !== 'available') {
            return back()->with('error', 'La licencia ya no está disponible.');
        }

        $email = $request->input('email');
        $sendEmail = $request->boolean('send_email');

        // Check if user exists
        $user = User::where('email', $email)->first();

        // Update license status
        $license->update([
            'status' => 'sold',
            'sold_at' => now(),
            'buyer_id' => $user ? $user->id : null,
        ]);

        // Update product stock
        $product = $license->product;
        if ($product) {
            $product->update([
                'stock' => $this->licenseService->getAvailableCount($product),
            ]);
        }

        // Send email if requested
        if ($sendEmail) {
            Mail::to($email)->queue(new LicenseManuallyAssignedMail($license));
        }

        $message = "Licencia asignada a {$email}.";
        if ($sendEmail) {
            $message .= " Se ha enviado un correo con la clave.";
        }

        return back()->with('success', $message);
    }
}
