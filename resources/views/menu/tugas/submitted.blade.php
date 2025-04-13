@extends('layouts.app')

@section('title', 'Daftar Tugas Terkumpul | EduTask')
@section('page', 'taskSubmitted')
@section('selected', 'taskSubmitted')
@section('pageName', 'Daftar Tugas Terkumpul')

@section('content')

    <div x-data="collectedAssignmentTable()" x-init="fetchCollectedAssignments()" class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">
            Tugas Terkumpul
            </h3>
        </div>
    
        <div class="p-5 border-t border-gray-100 dark:border-gray-700 sm:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3 font-medium">Nama Mahasiswa</th>
                        <th class="px-6 py-3 font-medium">File Tugas</th>
                        <th class="px-6 py-3 font-medium">Waktu Pengumpulan</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Nilai</th>
                        <th class="px-6 py-3 font-medium">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $submission->student->name }}</td>
                        <td class="px-6 py-4 text-blue-600 dark:text-blue-400">
                            @if($submission->files->isNotEmpty())
                                @foreach($submission->files as $file)
                                    <a href="{{ asset('storage/' . $file->file) }}" target="_blank" class="underline block mb-1">
                                        Lihat File
                                    </a>
                                @endforeach
                            @else
                                <span class="text-gray-400">Belum ada file</span>
                            @endif
                        </td>                   
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $submission->submitted_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            @if($submission->submitted_at > $submission->assignment->deadline)
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-red-100 text-red-800 dark:bg-red-300/20 dark:text-red-300">
                                    Terlambat Mengumpulkan
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-300/20 dark:text-green-300">
                                    Tepat Waktu
                                </span>
                            @endif
                        </td>                        
                        <td class="px-6 py-4 text-gray-800 dark:text-gray-100">
                            {{ ($submission->score ?? 0) . '/100' }}
                        </td>                        
                        <td class="px-6 py-4">
                            @if($submission->score !== null)
                                <!-- Jika sudah ada nilai, tampilkan icon centang -->
                                <span class="text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            @else
                                <!-- Jika belum ada nilai, tampilkan tombol "Beri Nilai" -->
                                <button @click="openModal({{ $submission->id }})"
                                    class="inline-flex items-center px-3 py-1 text-sm font-medium bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                    Beri Nilai
                                </button>
                            @endif
                        </td>                                              
                        </tr>
                    @empty
                        <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            Belum ada tugas yang terkumpul.
                        </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <!-- Modal Overlay -->
                <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                    x-transition>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-sm">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Beri Nilai</h2>
                        <form method="POST" :action="'/dosen/nilai/' + selectedSubmissionId">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Nilai</label>
                                <input type="number" name="score" min="0" max="100"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                    required>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="showModal = false"
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300">Batal</button>
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
            <!-- Pagination Placeholder -->
            <div class="flex justify-between mt-6 items-center flex-wrap gap-2">
            <div class="text-sm text-gray-700 dark:text-gray-400">
                Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{ $submissions->total() }} results
            </div>
            <div>
                {{ $submissions->links() }}
            </div>
            </div>
        </div>
        </div>
    </div>

    <script>
        function collectedAssignmentTable() {
            return {
                showModal: false,
                selectedSubmissionId: null,
                fetchCollectedAssignments() {
                    // kode fetch kalau ada
                },
                openModal(id) {
                    this.showModal = true;
                    this.selectedSubmissionId = id;
                }
            }
        }
    </script>
    

@endsection  
