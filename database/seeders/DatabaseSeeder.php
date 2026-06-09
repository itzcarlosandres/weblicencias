<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);

        // Create blog posts
        $admin = User::where('email', 'admin@todokeys.com')->first();

        BlogPost::create([
            'author_id' => $admin->id,
            'title' => 'Guía Completa: Cómo Activar Windows 11 con tu Licencia',
            'slug' => 'guia-activar-windows-11-licencia',
            'excerpt' => 'Aprende paso a paso cómo activar tu copia de Windows 11 con la licencia que adquiriste en TodoKeys.',
            'content' => '<h2>Introducción</h2><p>Activar Windows 11 es un proceso sencillo que garantiza que tu sistema operativo esté completamente funcional y actualizado. En esta guía te mostramos cómo hacerlo paso a paso.</p><h2>Paso 1: Obtener tu clave de producto</h2><p>Después de tu compra en TodoKeys, recibirás tu clave de producto por email e instantáneamente en tu panel de usuario.</p><h2>Paso 2: Abrir Configuración</h2><p>Ve a Configuración > Sistema > Activación y haz clic en "Cambiar clave de producto".</p><h2>Paso 3: Ingresar la clave</h2><p>Escribe tu clave de producto y haz clic en "Siguiente". El sistema verificará tu licencia automáticamente.</p><h2>¡Listo!</h2><p>Tu Windows 11 estará activado y podrás disfrutar de todas sus funcionalidades.</p>',
            'is_published' => true,
            'published_at' => now()->subDays(3),
            'meta_title' => 'Cómo Activar Windows 11 - Guía Completa 2024',
            'meta_description' => 'Aprende a activar Windows 11 con tu licencia. Guía paso a paso con imágenes.',
        ]);

        BlogPost::create([
            'author_id' => $admin->id,
            'title' => '¿Por Qué Comprar Licencias Digitales es Mejor?',
            'slug' => 'por-que-comprar-licencias-digitales',
            'excerpt' => 'Descubre las ventajas de comprar licencias digitales en lugar de versiones físicas.',
            'content' => '<h2> Ventajas de las licencias digitales</h2><p>Las licencias digitales se han convertido en la forma más popular y conveniente de adquirir software original. Aquí te explicamos por qué:</p><h2>Entrega instantánea</h2><p>No necesitas esperar al envío. Tu licencia llega en segundos a tu email y panel de usuario.</p><h2>Mejor precio</h2><p>Al no tener costos de envío, packaging o distribución física, el precio es significativamente menor.</p><h2>Seguridad</h2><p>No hay riesgo de extravío, daño físico o robo. Tu licencia siempre estará disponible en tu cuenta.</p><h2>Eco-friendly</h2><p>Al no usar plásticos ni papel, contribuyes al cuidado del medio ambiente.</p>',
            'is_published' => true,
            'published_at' => now()->subDays(7),
            'meta_title' => 'Ventajas de las Licencias Digitales | TodoKeys',
            'meta_description' => 'Descubre por qué comprar licencias digitales es mejor que las versiones físicas.',
        ]);

        BlogPost::create([
            'author_id' => $admin->id,
            'title' => 'Las Mejores Ofertas de Software este Mes',
            'slug' => 'mejores-ofertas-software-mes',
            'excerpt' => 'Revisa nuestras ofertas exclusivas en software, antivirus y suscripciones.',
            'content' => '<h2>Ofertas del mes</h2><p>Cada mes seleccionamos las mejores ofertas para nuestros clientes. Este mes tenemos descuentos increíbles en:</p><ul><li>Windows 11 Pro - 85% OFF</li><li>Office 2021 Professional - 89% OFF</li><li>Norton 360 Deluxe - 70% OFF</li><li>Adobe Creative Cloud - 75% OFF</li></ul><h2>No te las pierdas</h2><p>Estas ofertas son por tiempo limitado. Aprovecha ahora y ahorra en software original.</p>',
            'is_published' => true,
            'published_at' => now()->subDays(1),
            'meta_title' => 'Mejores Ofertas de Software - TodoKeys',
            'meta_description' => 'Aprovecha las mejores ofertas en software original con descuentos de hasta 89%.',
        ]);
    }
}
