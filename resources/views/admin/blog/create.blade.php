@extends('layouts.admin')

@section('title', 'Nuevo Artículo | Panel de Administración')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.blog.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Redactar Artículo</h1>
        </div>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- AI Generator Banner -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Redactor de IA Integrado
                    </h3>
                    <p class="text-sm text-purple-100 mt-1 mb-4">Ingresa el título del tutorial o artículo que deseas escribir, y la IA de Gemini redactará el contenido y optimizará el SEO automáticamente.</p>
                    <div class="flex gap-2">
                        <input type="text" id="ai-title-input" class="flex-1 bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-white/50" placeholder="Ej: Cómo activar Windows 11 Pro paso a paso">
                        <button type="button" id="btn-generate-ai" class="bg-white text-purple-600 hover:bg-gray-50 font-bold py-2.5 px-6 rounded-xl transition-colors whitespace-nowrap">
                            <i class="fa-solid fa-robot"></i> Generar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Editor -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Título del Artículo *</label>
                    <input type="text" name="title" id="post-title" value="{{ old('title') }}" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5" placeholder="Título impactante...">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Extracto Corto</label>
                    <textarea name="excerpt" id="post-excerpt" rows="2" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5" placeholder="Un resumen persuasivo del artículo...">{{ old('excerpt') }}</textarea>
                    @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contenido (HTML) *</label>
                    <textarea name="content" id="post-content" rows="15" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-mono" placeholder="<h2>Introducción</h2><p>Texto aquí...</p>">{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Publicación</h3>
                
                <label class="relative inline-flex items-center cursor-pointer mb-6">
                    <input type="checkbox" name="is_published" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Publicar Inmediatamente</span>
                </label>

                <div class="w-full h-px bg-gray-100 my-4"></div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Artículo
                </button>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Imagen Destacada</h3>
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-2">
                <p class="text-xs text-gray-500">Recomendado: 1200x630px</p>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Optimización SEO</h3>
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Meta Título</label>
                    <input type="text" name="meta_title" id="post-meta-title" value="{{ old('meta_title') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Meta Descripción</label>
                    <textarea name="meta_description" id="post-meta-description" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.getElementById('btn-generate-ai').addEventListener('click', async function() {
        const titleInput = document.getElementById('ai-title-input').value;
        const btn = this;
        
        if (!titleInput) {
            alert('Por favor ingresa un tema o título para generar el artículo.');
            return;
        }

        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generando...';
        btn.disabled = true;

        try {
            const response = await fetch('{{ route('admin.ai.generate-blog') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ blog_title: titleInput })
            });

            const data = await response.json();

            if (data.success) {
                document.getElementById('post-title').value = titleInput;
                document.getElementById('post-excerpt').value = data.data.excerpt || '';
                document.getElementById('post-content').value = data.data.content || '';
                document.getElementById('post-meta-title').value = data.data.meta_title || '';
                document.getElementById('post-meta-description').value = data.data.meta_description || '';
                alert('¡Artículo generado exitosamente con IA!');
            } else {
                alert(data.message || 'Hubo un error al generar el contenido.');
            }
        } catch (error) {
            alert('Error de conexión.');
            console.error(error);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
</script>
@endsection
