@extends('layouts.app')

@section('title', 'Tambah Tugas | EduTask')
@section('page', 'taskAdd')
@section('selected', 'taskAdd')
@section('pageName', 'Halaman Tambah Tugas')

@section('content')
  <div class="space-y-5 sm:space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-sm">
      <div class="px-6 py-5 sm:px-8 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
          </svg>
          Buat Tugas Baru
        </h3>
      </div>
      
      <div class="p-5 sm:p-6">
        <form method="POST" enctype="multipart/form-data" action="{{ route('assignments.dosen.store') }}" class="space-y-6">
          @csrf

          <!-- Judul -->
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1">
                Judul Tugas
                <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="title"
                name="title"
                placeholder="Masukkan judul tugas"
                required
                class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-800 dark:text-white placeholder-gray-400 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
              <p class="text-xs text-gray-500 dark:text-gray-400">Berikan judul yang deskriptif untuk tugas ini</p>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label for="description" class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1">
                Deskripsi Tugas
                <span class="text-red-500">*</span>
              </label>
              <textarea
                id="description"
                name="description"
                rows="8"
                required
                placeholder="Masukkan deskripsi dan instruksi tugas secara detail..."
                class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-800 dark:text-white placeholder-gray-400 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              ></textarea>
              <p class="text-xs text-gray-500 dark:text-gray-400">Berikan instruksi yang jelas dan detail untuk tugas ini</p>
            </div>
          </div>

          <!-- Tanggal dan Waktu -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Tanggal Mulai -->
            <div class="space-y-2">
              <label for="start_date" class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1">
                Tanggal & Waktu Mulai
                <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <input
                  type="datetime-local"
                  id="start_date"
                  name="start_date"
                  onclick="this.showPicker()"
                  required
                  class="block w-full pl-10 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-800 dark:text-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400">Tentukan kapan mahasiswa dapat mulai mengerjakan tugas</p>
            </div>

            <!-- Tenggat Waktu -->
            <div class="space-y-2">
              <label for="deadline" class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1">
                Tenggat Waktu
                <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <input
                  type="datetime-local"
                  id="deadline"
                  name="deadline"
                  onclick="this.showPicker()"
                  required
                  class="block w-full pl-10 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-800 dark:text-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400">Tentukan batas waktu pengumpulan tugas</p>
            </div>
          </div>

          <!-- File Lampiran (Optional) -->
          <div class="grid grid-cols-1 gap-6">
            <div class="space-y-2">
              <label for="attachment" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                File Lampiran (Opsional)
              </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600 dark:text-gray-400">
                    <label for="attachment" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 focus-within:outline-none">
                      <span>Upload file</span>
                      <input id="attachment" name="attachment" type="file" class="sr-only">
                    </label>
                    <p class="pl-1">atau drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    PDF, DOCX, XLSX, JPG, PNG hingga 10MB
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Tombol Aksi -->
          <div class="pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <a href="{{ route('assignments.dosen.index') }}"
              class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
              Batal
            </a>

            <button type="submit" name="submit" value="buat"
              class="inline-flex items-center justify-center rounded-md bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Buat Tugas
            </button>

            <button type="submit" name="submit" value="buat_lagi"
              class="inline-flex items-center justify-center rounded-md bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Simpan & Buat Lagi
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection