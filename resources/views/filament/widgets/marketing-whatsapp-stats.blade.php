<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Statistik Klik WhatsApp Marketing</span>
                <select wire:model.live="filter" class="text-sm rounded-lg border-gray-300 dark:border-gray-600 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    <option value="month">Bulan Ini</option>
                    <option value="all">Semua Data</option>
                </select>
            </div>
        </x-slot>

        <div class="overflow-x-auto -mx-6">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nama Marketing
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                No. WhatsApp
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Klik
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                        @forelse($this->getData() as $marketing)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $marketing->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                {{ $marketing->phone ? '+62 ' . ltrim($marketing->phone, '0') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-filament::badge color="success">
                                    {{ $marketing->whatsapp_clicks_count }}
                                </x-filament::badge>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada data
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
