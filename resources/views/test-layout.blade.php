<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Test Layout
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Test del Layout App
                    </h3>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Se vedi questa pagina con il layout completo del sito (header, navigazione, ecc.), 
                        allora il layout funziona correttamente.
                    </p>
                    
                    <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md">
                        <p class="text-sm text-green-800 dark:text-green-200">
                            ✅ Layout App funzionante!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout> 