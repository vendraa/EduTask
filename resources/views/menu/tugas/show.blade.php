@extends('layouts.app')

@section('title', 'Detail Tugas | EduTask')
@section('page', 'taskDetail')
@section('selected', 'taskDetail')
@section('pageName', 'Halaman Detail Tugas')

@section('content')
  <div
    class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12"
  >
    <div class="mx-auto w-full max-w-[630px] text-center">
      <h3 class="mb-4 text-theme-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">
        Detail Tugas
      </h3>
    </div>
    
    <div class="mb-5">
      <label
        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
      >
        Judul Tugas
      </label>
      <input
        type="text"
        value="{{ $assignment->title }}"
        class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
        readonly
      />
    </div>

    <div class="mb-5">
      <label
        class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
      >
        Deskripsi Tugas
      </label>
      <textarea
        class="dark:bg-dark-900 shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
        rows="6"
        readonly
      >{{ $assignment->description }}</textarea>
    </div>
  
    <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-5">
      <div>
        <label
          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
        >
          Tanggal & Waktu Mulai
        </label>
        <input
          type="text"
          value="{{ \Carbon\Carbon::parse($assignment->start_date)->format('d M Y H:i') }}"
          class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
          readonly
        />
      </div>
  
      <div>
        <label
          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
        >
          Tenggat Waktu
        </label>
        <input
          type="text"
          value="{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y H:i') }}"
          class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
          readonly
        />
      </div>
    </div>
  
    <div class="flex items-center justify-end gap-5 mt-5">
      <a class="px-4 py-3 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
         href="{{ route('assignments.dosen.index') }}"
      >
        Kembali ke Daftar Tugas
      </a>
    </div> 
  </div>
@endsection
