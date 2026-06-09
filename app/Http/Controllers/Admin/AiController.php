<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class AiController extends Controller
{
    public function generateProductSeo(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
        ]);

        $apiKey = Setting::get('gemini_api_key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor configura tu API Key de Gemini en Configuración -> Inteligencia Artificial primero.'
            ], 400);
        }

        $productName = $request->product_name;

        // Prompt estructurado para forzar salida JSON limpia
        $prompt = "Actúa como un experto en SEO y Copywriting para una tienda online de licencias y software. Genera el contenido para un producto llamado '{$productName}'. 
Requisitos estrictos:
- Devuelve la respuesta en formato JSON exacto sin markdown (nada de ```json).
- El JSON debe tener exactamente 3 claves: 'description', 'meta_title' y 'meta_description'.
- 'description': Descripción detallada y persuasiva del producto, de al menos 200 palabras, usando etiquetas HTML. Debes estructurar el contenido utilizando encabezados SEO (<h2> y <h3>) para separar las secciones (ej. Características, Beneficios, Requisitos). Usa listas (<ul>, <li>) si es necesario, y <strong> para resaltar palabras clave. (IMPORTANTE: NO uses la etiqueta <h1>, ya que está reservada para el título principal de la página).
- 'meta_title': Título SEO máximo de 60 caracteres.
- 'meta_description': Descripción SEO máximo de 160 caracteres.
Ejemplo de salida:
{
  \"description\": \"<p>Descubre el poder de <strong>{$productName}</strong>...</p>\",
  \"meta_title\": \"Comprar {$productName} al mejor precio\",
  \"meta_description\": \"Adquiere {$productName} con entrega inmediata y garantía. Las mejores ofertas en licencias de software originales.\"
}";

        try {
            $response = Http::withoutVerifying()->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = $result['candidates'][0]['content']['parts'][0]['text'];
                    
                    // Limpiar markdown si Gemini lo incluye por error
                    $text = str_replace(['```json', '```'], '', $text);
                    $text = trim($text);

                    $data = json_decode($text, true);

                    if ($data && isset($data['description'])) {
                        return response()->json([
                            'success' => true,
                            'data' => $data
                        ]);
                    } else {
                        \Illuminate\Support\Facades\Log::error('AI Parsing Error:', [
                            'text' => $text,
                            'json_error' => json_last_error_msg()
                        ]);
                    }
                }
            } else {
                \Illuminate\Support\Facades\Log::error('AI Request Error:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al parsear la respuesta de la IA. Por favor intenta de nuevo.'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión con Gemini: ' . $e->getMessage()
            ], 500);
        }
    }
}
