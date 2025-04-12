@extends('layouts.app')

@section('title', 'Dashboard | EduTask')
@section('page', 'dashboard')
@section('selected', 'Dashboard')
@section('pageName', 'Dashboard')

@section('content')
  <div
    class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12"
  >
    <div class="mx-auto w-full max-w-[630px] text-center">
      <h3 class="mb-4 text-theme-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">
        Dashboard
      </h3>
      <p class="text-sm text-gray-500 dark:text-gray-400 sm:text-base">
        Halaman Dashboard sedang dalam tahap pengembangan.
      </p>
    </div>
  </div>
@endsection