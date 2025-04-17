@extends('layouts.app')

@section('title', 'Daftar Tugas Terkumpul | EduTask')
@section('page', 'taskSubmitted')
@section('selected', 'taskSubmitted')
@section('pageName', 'Daftar Tugas Terkumpul')

@section('content')

    <div x-data="collectedAssignmentTable()" x-init="fetchCollectedAssignments()" class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="px-5 py-4 sm:px-6 sm:py-5">
            <a href="{{ route('assignments.dosen.index') }}" class="inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Kembali
            </a>
        </div>
    
        <div class="p-5 border-t border-gray-100 dark:border-gray-700 sm:p-6">
            <div class="overflow-x-auto">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Judul Tugas : {{ $assignment->title }}
                    </h1>
                </div>                
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
                                <span class="text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            @else
                                <button @click="openModal({{ $submission->id }})"
                                    class="inline-flex items-center px-3 py-1 text-sm font-medium bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Beri Nilai
                                </button>
                            @endif
                        </td>                                              
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                          <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="font-medium">Belum ada tugas yang terkumpul.</p>
                            <p class="text-sm mt-1">Tugas yang telah dikumpulkan oleh mahasiswa akan muncul di sini.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                    </tbody>
                </table>
                <!-- Modal Overlay -->
<!-- FULLSCREEN OVERLAY -->
<div x-show="showModal"
     x-cloak
     style="display: none"
     class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
>
  <!-- MODAL CONTENT -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md mx-4"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 transform scale-95"
       x-transition:enter-end="opacity-100 transform scale-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 transform scale-100"
       x-transition:leave-end="opacity-0 transform scale-95"
  >
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Beri Nilai Tugas</h2>
      <button @click="showModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <form method="POST" :action="'/dosen/nilai/' + selectedSubmissionId" class="space-y-4">
      @csrf
      @method('PUT')

      <div class="space-y-2">
        <label for="score" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai (0-100)</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <input type="number" name="score" id="score" required min="0" max="100"
                 class="block w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500" />
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">Berikan nilai antara 0 sampai 100</p>
      </div>

      <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
        <button type="button" @click="showModal = false"
                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Batal
        </button>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-md bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Simpan Nilai
        </button>
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
