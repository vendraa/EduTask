@extends('layouts.app')

@section('title', 'Detail Tugas | EduTask')
@section('page', 'taskDetail')
@section('selected', 'taskDetail')
@section('pageName', 'Halaman Detail Tugas')

@section('content')
  <div class="space-y-5 sm:space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-sm">
      <div class="px-6 py-5 sm:px-8 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Detail Tugas
        </h3>
      </div>
      
      <div class="p-5 sm:p-6">
        <div class="space-y-6">
          <!-- Judul -->
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Judul Tugas
              </label>
              <div class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-3 text-sm text-gray-800 dark:text-white">
                {{ $assignment->title }}
              </div>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Deskripsi Tugas
              </label>
              <textarea
              class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-3 text-sm text-gray-800 dark:text-white"
              rows="6"
              readonly
            >{{ $assignment->description }}</textarea>
            </div>
          </div>

          <!-- Tanggal dan Waktu -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Tanggal Mulai -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Tanggal & Waktu Mulai
              </label>
              <div class="flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-2.5 text-sm text-gray-800 dark:text-white">
                  {{ \Carbon\Carbon::parse($assignment->start_date)->format('d M Y H:i') }}
                </div>
              </div>
            </div>

            <!-- Tenggat Waktu -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Tenggat Waktu
              </label>
              <div class="flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-2.5 text-sm text-gray-800 dark:text-white">
                  {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y H:i') }}
                </div>
              </div>
            </div>
          </div>

          <!-- File Lampiran -->
          @if($assignment->attachment_path)
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                File Lampiran
              </label>
              <div class="flex items-center p-4 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <svg class="h-8 w-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-800 dark:text-white">{{ basename($assignment->attachment_path) }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Ukuran file: {{ number_format(filesize(storage_path('app/'.$assignment->attachment_path)) / 1024, 2) }} KB</p>
                </div>
                <a href="{{ route('assignments.download', $assignment->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-900/50">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                  Download
                </a>
              </div>
            </div>
          </div>
          @endif

          <!-- Tombol Aksi -->
          <div class="pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <a href="{{ route('assignments.dosen.index') }}"
              class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
              <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
              </svg>
              Kembali ke Daftar
            </a>

            <a href="{{ route('assignments.dosen.edit', $assignment->id) }}"
              class="inline-flex items-center justify-center rounded-md bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Edit Tugas
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
