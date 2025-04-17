@extends('layouts.app')

@section('title', 'Dashboard | EduTask')
@section('page', 'dashboard')
@section('selected', 'Dashboard')
@section('pageName', 'Dashboard')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Welcome to EduTask!</h1>
  <p class="text-gray-600 dark:text-gray-400 mt-1">Your educational task management platform</p>
</div>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-3 md:gap-6">
  <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between">
      <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 dark:bg-indigo-900/30">
        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0121 12.098c0 3.867-2.239 7.342-5.6 9.065M12 14v7.5" />
        </svg>
      </div>
      <span class="rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-medium text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">Total</span>
    </div>

    <div class="mt-6">
      <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Dosen</h3>
      <div class="mt-2 flex items-baseline">
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahDosen }}</p>
        <p class="ml-2 text-sm text-gray-500 dark:text-gray-400">pengajar</p>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between">
      <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2a5 5 0 00-10 0v2H2v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>
      <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Total</span>
    </div>

    <div class="mt-6">
      <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Mahasiswa</h3>
      <div class="mt-2 flex items-baseline">
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahMahasiswa }}</p>
        <p class="ml-2 text-sm text-gray-500 dark:text-gray-400">pelajar</p>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between">
      <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/30">
        <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 16h6M9 8h6M15 4h2a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2h2" />
        </svg>
      </div>
      <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">Total</span>
    </div>

    <div class="mt-6">
      <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Tugas</h3>
      <div class="mt-2 flex items-baseline">
        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $jumlahTugas }}</p>
        <p class="ml-2 text-sm text-gray-500 dark:text-gray-400">tugas aktif</p>
      </div>
    </div>
  </div>
</div>

<div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
  <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Aktivitas Terbaru</h2>
  <div class="flex items-center justify-center h-48 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
    <p class="text-gray-500 dark:text-gray-400">Additional section for future statistics (coming soon)</p>
  </div>
</div>
@endsection
