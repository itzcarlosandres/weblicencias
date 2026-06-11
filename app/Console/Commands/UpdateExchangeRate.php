<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyService;

class UpdateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza la tasa de cambio USD→COP desde APIs gratuitas (frankfurter.app / open.er-api.com)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔄 Actualizando tasa de cambio USD/COP...');

        try {
            $rate = CurrencyService::refreshRate();

            if ($rate > 0) {
                $this->info("✅ Tasa actualizada: 1 USD = " . number_format($rate, 2, '.', ',') . " COP");
                $this->line("   Guardada en caché (6 horas) y en base de datos.");
                return Command::SUCCESS;
            }

            $this->warn("⚠️  No se pudo obtener la tasa desde APIs. Usando valor guardado en DB.");
            return Command::FAILURE;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
