<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Backup Database') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Unduh Backup (SQL Dump)</h3>
                        <p class="text-gray-500 text-sm mt-1">Unduh seluruh tabel database beserta datanya ke dalam format .sql. Fitur ini menggunakan Pure PHP MySQL Dumper tanpa membutuhkan mysqldump.</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.backup.download') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh Database
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
