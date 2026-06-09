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
        
        set_time_limit(120);

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
            $response = Http::withoutVerifying()->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
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

    public function generateBlogSeo(Request $request)
    {
        set_time_limit(120); // Permitir hasta 2 minutos para la respuesta de la IA

        $request->validate([
            'blog_title' => 'required|string|max:255',
        ]);

        $apiKey = Setting::get('gemini_api_key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor configura tu API Key de Gemini en Configuración -> Inteligencia Artificial primero.'
            ], 400);
        }

        $blogTitle = $request->blog_title;

        $prompt = "Actúa como un experto en SEO y Copywriting para un blog de tecnología y licencias de software. Escribe un artículo completo, profesional y optimizado para el título: '{$blogTitle}'.
Requisitos estrictos:
- Devuelve la respuesta en formato JSON exacto sin markdown.
- El JSON debe tener exactamente 4 claves: 'content', 'excerpt', 'meta_title' y 'meta_description'.
- 'content': El contenido completo del artículo del blog (mínimo 600 palabras). ESTRICTAMENTE DEBE INCLUIR ETIQUETAS HTML REALES. Usa <p> para todos los párrafos. Usa <h2> y <h3> para estructurar. Usa <ul> y <li> para listas. Usa <strong> para negritas y palabras clave importantes. NO devuelvas texto plano. Es OBLIGATORIO que el contenido sea código HTML válido listo para insertarse en un <div>.
- 'excerpt': Un resumen corto del artículo, muy persuasivo para invitar a leer (máximo 150 caracteres).
- 'meta_title': Título SEO máximo de 60 caracteres.
- 'meta_description': Descripción SEO máximo de 160 caracteres.
Ejemplo de salida:
{
  \"content\": \"<p>Si alguna vez te has preguntado...</p><h2>Primer paso</h2><p>...</p>\",
  \"excerpt\": \"Descubre los mejores consejos para dominar esto hoy mismo.\",
  \"meta_title\": \"{$blogTitle} | Guía Definitiva\",
  \"meta_description\": \"Aprende todo lo necesario sobre {$blogTitle} con nuestra guía paso a paso. Optimiza tu equipo ahora.\"
}";

        try {
            $response = Http::withoutVerifying()->timeout(90)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = $result['candidates'][0]['content']['parts'][0]['text'];
                    
                    // Clean markdown code blocks if present
                    $text = preg_replace('/^```json\s*/i', '', $text);
                    $text = preg_replace('/\s*```$/i', '', $text);
                    $text = trim($text);
                    
                    // Extract JSON from curly braces
                    $start = strpos($text, '{');
                    $end = strrpos($text, '}');
                    
                    if ($start !== false && $end !== false) {
                        $jsonString = substr($text, $start, $end - $start + 1);
                        $data = json_decode($jsonString, true);

                        if ($data && isset($data['content'])) {
                            return response()->json([
                                'success' => true,
                                'data' => $data
                            ]);
                        } else {
                            \Illuminate\Support\Facades\Log::error('AI Blog Parsing Error:', [
                                'json_error' => json_last_error_msg(),
                                'text_snippet' => substr($text, 0, 500),
                            ]);
                        }
                    } else {
                        \Illuminate\Support\Facades\Log::error('AI Blog No JSON Found:', [
                            'text' => substr($text, 0, 500)
                        ]);
                    }
                } else {
                    \Illuminate\Support\Facades\Log::error('AI Blog No Content:', [
                        'response' => $result
                    ]);
                }
            } else {
                \Illuminate\Support\Facades\Log::error('AI Blog Request Failed:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la IA. Intenta de nuevo.'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión con Gemini: ' . $e->getMessage()
            ], 500);
        }
    }
}
