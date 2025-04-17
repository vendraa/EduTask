@props(['title', 'count', 'tasks', 'badgeBg' => '', 'badgeText' => ''])

@php
  $statusColors = [
    'scheduled' => 'bg-yellow-300', // untuk dosen, status scheduled
    'in progress' => 'bg-blue-600', // untuk dosen atau mahasiswa yang sedang mengerjakan tugas
    'missed' => 'bg-red-600',       // untuk mahasiswa yang belum submit setelah deadline
    'completed' => 'bg-green-600',  // untuk mahasiswa yang sudah submit atau dosen setelah deadline
  ];
@endphp

<div class="bg-gray-50 dark:bg-white/5 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
  <div class="flex justify-between items-center mb-3">
    <h3 class="font-semibold text-gray-700 dark:text-white">{{ $title }}</h3>
    <span class="text-xs {{ $badgeBg }} {{ $badgeText }} px-2 py-0.5 rounded-full">{{ $count }}</span>
  </div>

  <div class="space-y-4">
    @foreach ($tasks as $task)
      <div class="bg-white dark:bg-white/5 rounded-lg p-4 border border-gray-200 dark:border-gray-600 shadow-sm space-y-2">
        
        {{-- Judul dan Status --}}
        <div class="flex justify-between items-center">
          <h4 class="text-gray-800 dark:text-white font-semibold">
            {{ is_array($task) ? $task['title'] : $task->title }}
          </h4>
          <div class="text-xs text-white inline-block px-2 py-1 rounded-full {{ $statusColors[$task->status_dynamic ?? 'scheduled'] ?? 'bg-slate-400' }}">
            {{ $task->status_dynamic ?? 'Scheduled' }}  {{-- Menggunakan status_dynamic --}}
          </div>
        </div>

        {{-- Tanggal Deadline --}}
        <div class="flex items-start text-sm text-gray-600 dark:text-gray-300 gap-2">
          <svg class="fill-current text-gray-500 dark:text-gray-400 mt-0.5" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
              fill="currentColor"
            />
          </svg>
          <span>
            <strong class="text-gray-700 dark:text-white">Tenggat Waktu:</strong>
            {{ \Carbon\Carbon::parse(is_array($task) ? $task['date'] : $task->deadline)->format('d M Y H:i') }}
          </span>
        </div>

        {{-- Link Detail --}}
        <div class="mt-2">
          @if (!is_array($task))
            <a href="{{ route('assignments.mahasiswa.submission', $task->id) }}" class="text-indigo-600 dark:text-indigo-400 text-sm hover:underline">
              Lihat Detail
            </a>
          @endif
        </div>
      </div>

      @if (!$loop->last)
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
      @endif
    @endforeach
  </div>
</div>
