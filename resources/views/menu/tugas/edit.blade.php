@extends('layouts.app')

@section('title', 'Edit Tugas | EduTask')
@section('page', 'taskEdit')
@section('selected', 'taskEdit')
@section('pageName', 'Halaman Edit Tugas')

@section('content')
  <div
    class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12"
  >
    <div class="mx-auto w-full max-w-[630px] text-center">
      <h3 class="mb-4 text-theme-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">
        Edit Tugas
      </h3>
    </div>
    
    <form method="POST" enctype="multipart/form-data" action="{{ route('assignments.dosen.update', $assignment->id) }}">
        @csrf
        @method('PUT')

      <div class="mb-5">
        <label
          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
        >
          Judul Tugas
        </label>
        <input
          type="text"
          name="title"
          value="{{ old('title', $assignment->title) }}"
          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
          required
        />
      </div>
      <div class="mb-5">
        <label
          class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
        >
          Deskripsi Tugas
        </label>
        <textarea
          placeholder="Enter a description..."
          type="text"
          name="description"
          rows="6"
          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
        >{{ old('description', $assignment->description) }}</textarea>
      </div>
  
      <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label
            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
          >
            Tanggal & Waktu Mulai
          </label>
      
          <div class="relative">
            <input
              type="datetime-local"
              name="start_date"
              value="{{ old('start_date', \Carbon\Carbon::parse($assignment->start_date)->format('Y-m-d\TH:i')) }}"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              onclick="this.showPicker()"
              required
            />
            <span
              class="pointer-events-none absolute right-4 top-0 bottom-0 flex items-center cursor-pointer text-gray-500 dark:text-gray-400"
            >
              <svg
                class="fill-current"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                  fill=""
                />
              </svg>
            </span>
          </div>
        </div>
  
        <div>
          <label
            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"
          >
            Tenggat Waktu
          </label>
  
          <div class="relative">
            <input
              type="datetime-local"
              name="deadline"
              value="{{ old('deadline', \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i')) }}"
              placeholder="Select date"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              onclick="this.showPicker()"
              required
            />
            <span
              class="pointer-events-none absolute right-4 top-0 bottom-0 flex items-center cursor-pointer text-gray-500 dark:text-gray-400"
            >
              <svg
                class="fill-current"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
                  fill=""
                />
              </svg>
            </span>
          </div>
        </div>
      </div>>
  
      <div class="flex items-center justify-end gap-5 mt-5">
        <button type="submit" name="submit" value="buat" class="px-4 py-3 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">
          Buat Tugas
        </button>
        <a class="px-4 py-3 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600"
           href="{{ route('assignments.dosen.index') }}"
        >
          Cancel
        </a>
      </div> 
    </form>
    
  </div>
@endsection