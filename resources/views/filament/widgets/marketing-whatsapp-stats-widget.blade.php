<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between w-full">
                <span>Statistik Klik WhatsApp Marketing</span>
                <div>
                    <select 
                        wire:model.live="filterPeriod" 
                        class="text-sm rounded-lg border-gray-300 dark:border-gray-600 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="month">Bulan Ini</option>
                        <option value="all">Semua Data</option>
                    </select>
                </div>
            </div>
        </x-slot>

        {{ $this->table }}
    </x-filament::section>
</x-filament-widgets::widget>
