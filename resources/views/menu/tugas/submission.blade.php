@extends('layouts.app')

@section('title', 'Tugas Terkumpul | EduTask')
@section('page', 'taskSubmitted')
@section('selected', 'taskSubmitted')
@section('pageName', 'Tugas Terkumpul')

@section('content')
<div class="space-y-5 sm:space-y-6">
  <form action="{{ route('assignment.mahasiswa.submission.store', $assignment->id) }}" method="POST" enctype="multipart/form-data" id="submission-form">
    @csrf

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      
      {{-- Header dengan tombol kembali & submit --}}
      <div class="flex justify-between items-center px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('assignments.mahasiswa.index') }}" class="text-sm text-gray-700 dark:text-white hover:underline">&larr; Kembali</a>

        @if (!$submission)
          {{-- Belum submit tugas --}}
          <button 
            type="submit"
            class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"
          >
            Kumpulkan Tugas
          </button>
        @else
          {{-- Sudah submit tugas --}}
          <span class="text-sm text-gray-700 dark:text-white">
            Dikumpulkan pada {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d F Y H:i') }}
          </span>
        @endif
      </div>

      {{-- Konten Form --}}
      <div class="p-5 sm:p-6 space-y-6">
        {{-- Judul Tugas --}}
        <div>
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-1">{{ $assignment->title }}</h2>
          <p class="text-sm text-gray-600 dark:text-gray-300">
            Tenggat Waktu: <span class="font-medium text-red-500">
              {{ \Carbon\Carbon::parse($assignment->deadline)->format('d F Y H:i') }}
            </span>
          </p>
        </div>

        {{-- Deskripsi --}}
        <div>
          <h3 class="text-medium font-semibold text-gray-700 dark:text-white mb-1">Deskripsi</h3>
          <p class="text-gray-700 dark:text-gray-300 text-medium leading-relaxed">
            {{ $assignment->description ?? 'Deskripsi tidak tersedia.' }}
          </p>
        </div>

        {{-- Upload File --}}
        <div>
          <h3 class="text-base font-small text-gray-800 dark:text-white/90">
            {{ $submission ? 'Daftar File Tugas yang Diupload' : 'Upload File Tugas' }}
          </h3>
        </div>

        <div class="space-y-6 border-t border-gray-100 pt-5 sm:pt-6 dark:border-gray-800">
          @if ($submission)
          <ul class="space-y-2">
            @if(count($files) > 0)
                @foreach ($files as $file)
                    <li>
                        <a href="{{ asset('storage/' . $file->file) }}" target="_blank" class="text-brand-500 hover:underline">
                            📎 {{ basename($file->file) }}
                        </a>
                    </li>
                @endforeach
            @else
                <li>Tidak ada file yang diupload.</li>
            @endif
        </ul>        
          @else
          <!-- File Upload -->
          <div>
            <label
              for="fileInput"
              class="cursor-pointer block hover:border-brand-500 dark:hover:border-brand-500 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900 text-center"
              id="uploadLabel"
            >
              <!-- DEFAULT CONTENT -->
              <div id="uploadDefault">
                <div class="flex justify-center mb-6">
                  <div class="flex h-[68px] w-[68px] items-center justify-center rounded-full bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    <svg class="fill-current" width="29" height="28" viewBox="0 0 29 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M14.5019 3.91699C14.2852 3.91699 14.0899 4.00891 13.953 4.15589L8.57363 9.53186C8.28065 9.82466 8.2805 10.2995 8.5733 10.5925C8.8661 10.8855 9.34097 10.8857 9.63396 10.5929L13.7519 6.47752V18.667C13.7519 19.0812 14.0877 19.417 14.5019 19.417C14.9161 19.417 15.2519 19.0812 15.2519 18.667V6.48234L19.3653 10.5929C19.6583 10.8857 20.1332 10.8855 20.426 10.5925C20.7188 10.2995 20.7186 9.82463 20.4256 9.53184L15.0838 4.19378C14.9463 4.02488 14.7367 3.91699 14.5019 3.91699ZM5.91626 18.667C5.91626 18.2528 5.58047 17.917 5.16626 17.917C4.75205 17.917 4.41626 18.2528 4.41626 18.667V21.8337C4.41626 23.0763 5.42362 24.0837 6.66626 24.0837H22.3339C23.5766 24.0837 24.5839 23.0763 24.5839 21.8337V18.667C24.5839 18.2528 24.2482 17.917 23.8339 17.917C23.4197 17.917 23.0839 18.2528 23.0839 18.667V21.8337C23.0839 22.2479 22.7482 22.5837 22.3339 22.5837H6.66626C6.25205 22.5837 5.91626 22.2479 5.91626 21.8337V18.667Z"
                        fill=""
                      />
                    </svg>
                  </div>
                </div>
                <div>
                  <h4 class="text-theme-xl mb-3 font-semibold text-gray-800 dark:text-white/90">
                    Upload File Disini
                  </h4>
                  <span class="block text-sm text-gray-700 dark:text-gray-400">
                    Klik area ini untuk memilih file PDF, DOCX, ZIP, dll
                  </span>
                  <span class="text-theme-sm text-brand-500 font-medium underline">
                    Browse File
                  </span>
                </div>
              </div>

              <!-- PREVIEW SELECTED FILES -->
              <div id="uploadSelected" class="hidden text-left">
                <h4 class="text-theme-xl mb-3 font-semibold text-gray-800 dark:text-white/90">
                  File yang dipilih:
                </h4>
                <ul id="fileNamesInLabel" class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300"></ul>
              </div>
            </label>

            <input type="file" name="files[]" id="fileInput" multiple class="hidden" />
          </div>
          @endif
        </div>
      </div>
    </div>
  </form>
</div>

@endsection


