@extends('layouts.app')

@section('title', 'Daftar Tugas | EduTask')
@section('page', 'taskList')
@section('selected', 'taskList')
@section('pageName', 'Halaman Daftar Tugas')

@section('content')

  @if (auth()->user()->role === 'mahasiswa')
  <div x-data="{ tab: 'all' }" class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-8">
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
      <!-- Header -->
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tugas Anda</h2>
      
      <!-- Tabs -->
      <div class="flex gap-2 flex-wrap">
        <button
          @click="tab = 'all'"
          :class="tab === 'all' 
            ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700' 
            : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700'"
          class="px-5 py-2 text-sm rounded-lg font-medium border transition-colors duration-200"
        >
          Semua Tugas
        </button>
  
        <button
          @click="tab = 'todo'"
          :class="tab === 'todo' 
            ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-300 border-yellow-200 dark:border-yellow-700' 
            : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700'"
          class="px-5 py-2 text-sm rounded-lg font-medium border transition-colors duration-200"
        >
          <div class="flex items-center gap-2">
            <span>Belum Dikerjakan</span>
            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">{{ $todoTasks->count() }}</span>
          </div>
        </button>

        <button
          @click="tab = 'missed'"
          :class="tab === 'missed' 
            ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-300 border-red-200 dark:border-red-700' 
            : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700'"
          class="px-5 py-2 text-sm rounded-lg font-medium border transition-colors duration-200"
        >
          <div class="flex items-center gap-2">
            <span>Terlewat</span>
            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">{{ $missedTasks->count() }}</span>
          </div>
        </button>
    
        <button
          @click="tab = 'completed'"
          :class="tab === 'completed' 
            ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-300 border-green-200 dark:border-green-700' 
            : 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700'"
          class="px-5 py-2 text-sm rounded-lg font-medium border transition-colors duration-200"
        >
          <div class="flex items-center gap-2">
            <span>Selesai</span>
            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">{{ $completedTasks->count() }}</span>
          </div>
        </button>
      </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-200 dark:border-gray-700 my-4 mb-6"></div>

    @php
      $columns = [
          [
              'key' => 'todo',
              'title' => 'Belum Dikerjakan',
              'tasks' => $todoTasks,
              'badgeBg' => 'bg-yellow-100 dark:bg-yellow-900/40',
              'badgeText' => 'text-yellow-800 dark:text-yellow-200',
              'headerBg' => 'bg-yellow-50 dark:bg-yellow-900/20',
              'headerBorder' => 'border-yellow-200 dark:border-yellow-800',
              'icon' => '<svg class="w-5 h-5 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
          ],
          [
              'key' => 'missed',
              'title' => 'Terlewat',
              'tasks' => $missedTasks,
              'badgeBg' => 'bg-red-100 dark:bg-red-900/40',
              'badgeText' => 'text-red-800 dark:text-red-200',
              'headerBg' => 'bg-red-50 dark:bg-red-900/20',
              'headerBorder' => 'border-red-200 dark:border-red-800',
              'icon' => '<svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
          ],
          [
              'key' => 'completed',
              'title' => 'Selesai',
              'tasks' => $completedTasks,
              'badgeBg' => 'bg-green-100 dark:bg-green-900/40',
              'badgeText' => 'text-green-800 dark:text-green-200',
              'headerBg' => 'bg-green-50 dark:bg-green-900/20',
              'headerBorder' => 'border-green-200 dark:border-green-800',
              'icon' => '<svg class="w-5 h-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
          ],
      ];
    @endphp
    
    {{-- ALL VIEW: 3 kolom --}}
    <div x-show="tab === 'all'" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($columns as $column)
            <div class="flex flex-col h-full">
              <div class="rounded-lg border {{ $column['headerBorder'] }} {{ $column['headerBg'] }} p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  {!! $column['icon'] !!}
                  <h3 class="font-semibold text-gray-800 dark:text-white">{{ $column['title'] }}</h3>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $column['badgeBg'] }} {{ $column['badgeText'] }}">
                  {{ $column['tasks']->count() }}
                </span>
              </div>
              
              <div class="mt-3 flex-1 overflow-y-auto" style="max-height: calc(100vh - 250px)">
                @if($column['tasks']->count() > 0)
                  <div class="space-y-3">
                    @foreach($column['tasks'] as $task)
                      <div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex justify-between items-start">
                          <h4 class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</h4>
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $column['badgeBg'] }} {{ $column['badgeText'] }}">
                            {{ $column['title'] }}
                          </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $task->description }}</p>
                        <div class="mt-3 flex items-center text-xs text-gray-500 dark:text-gray-400">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                          </svg>
                          <span>Tenggat: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="mt-3 flex justify-end">
                        <a href="/mahasiswa/tugas/pengumpulan-tugas/{{ $task->id }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-800/40 transition-colors duration-200">                              <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Detail
                          </a>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @else
                  <div class="py-8 flex flex-col items-center justify-center text-center text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>Tidak ada tugas {{ strtolower($column['title']) }}</p>
                  </div>
                @endif
              </div>
            </div>
        @endforeach
    </div>

    {{-- VIEW LAINNYA: Full Width --}}
    @foreach ($columns as $column)
      <div x-show="tab === '{{ $column['key'] }}'" class="w-full">
        <div class="rounded-lg border {{ $column['headerBorder'] }} {{ $column['headerBg'] }} p-4 flex items-center justify-between mb-4">
          <div class="flex items-center gap-2">
            {!! $column['icon'] !!}
            <h3 class="font-semibold text-gray-800 dark:text-white">{{ $column['title'] }}</h3>
          </div>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $column['badgeBg'] }} {{ $column['badgeText'] }}">
            {{ $column['tasks']->count() }}
          </span>
        </div>
        
        @if($column['tasks']->count() > 0)
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($column['tasks'] as $task)
              <div class="relative p-4 pb-16 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                  <h4 class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</h4>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $column['badgeBg'] }} {{ $column['badgeText'] }}">
                    {{ $column['title'] }}
                  </span>
                </div>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $task->description }}</p>
                <div class="mt-3 flex items-center text-xs text-gray-500 dark:text-gray-400">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  <span>Tenggat: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y, H:i') }}</span>
                </div>
          
                {{-- Tombol selalu di kanan bawah --}}
                <a href="/mahasiswa/tugas/pengumpulan-tugas/{{ $task->id }}"
                  class="absolute bottom-4 right-4 inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-800/40 transition-colors duration-200">
                  <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  Lihat Detail
                </a>
              </div>
            @endforeach
          </div>
        @else
          <div class="py-16 flex flex-col items-center justify-center text-center text-gray-500 dark:text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-lg">Tidak ada tugas {{ strtolower($column['title']) }}</p>
            <p class="mt-2 max-w-md mx-auto">Anda tidak memiliki tugas dengan status {{ strtolower($column['title']) }} saat ini.</p>
          </div>
        @endif
      </div>
    @endforeach
  </div>
  @else
  <div class="space-y-5 sm:space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-sm">
      <div class="px-6 py-5 sm:px-8 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          Daftar Tugas
        </h3>
        
        <a href="{{ route('assignments.dosen.create') }}" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Buat Tugas Baru
        </a>
      </div>
      
      <div class="p-5 sm:p-6">
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          @php $perPage = request()->input('perPage', 10); @endphp
          <div x-data="{ perPage: '{{ $perPage }}' }" class="flex items-center gap-2">
            <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tampilkan</label>
            <select id="perPage" name="perPage"
                    x-model="perPage"
                    @change="window.location.href = '{{ url()->current() }}' + '?perPage=' + perPage"
                    class="block w-auto px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-md focus:outline-none focus:ring focus:border-indigo-500">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">data</span>
          </div>
          
          <div class="relative w-full sm:max-w-xs">
            <form method="GET" action="{{ url()->current() }}">
              <input type="hidden" name="perPage" value="{{ $perPage }}">
              <input
                type="text"
                name="search"
                id="search"
                value="{{ $search }}"
                placeholder="Cari dosen berdasarkan nama atau email..."
                class="block w-full pl-10 pr-8 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-md focus:outline-none focus:ring focus:border-indigo-500"
              />
              <!-- Icon Search -->
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
              </div>
          
              @if ($search)
              <!-- Tombol clear (X) -->
              <button
                type="button"
                onclick="window.location='{{ url()->current() }}?perPage={{ $perPage }}'"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
              @endif
            </form>
          </div>        
        </div>
  
        <div class="overflow-visible rounded-lg border border-gray-200 dark:border-gray-700">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul Tugas</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dosen Pembuat</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Mulai</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tenggat Waktu</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
              @forelse($assignments as $assignment)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $assignment->title }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $assignment->lecturer ? $assignment->lecturer->name : '-' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $assignment->start_date ? $assignment->start_date->format('d M Y H:i') : '-' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $assignment->deadline ? $assignment->deadline->format('d M Y H:i') : '-' }}
                  </div>
                </td>                
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                      $status = $assignment->status_dynamic;
                  @endphp
              
                  <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium 
                      @if ($status === 'scheduled') 
                          bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 
                      @elseif ($status === 'in progress') 
                          bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 
                      @else
                          bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                      @endif">
                      {{ ucfirst($status) }}
                  </span>
                </td>              
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div x-data="{ open: false, dropUp: false }" x-init="$nextTick(() => {
                    const rect = $el.getBoundingClientRect();
                    dropUp = (window.innerHeight - rect.bottom) < 150;
                  })" class="relative">
                    <!-- Trigger -->
                    <button @click="open = !open" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                      </svg>
                    </button>
      
                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                      :class="dropUp ? 'bottom-full mb-2' : 'mt-2'"
                      class="absolute right-0 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-gray-800 dark:border-gray-700">
                      <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                        <!-- Edit -->
                        <li>
                            <a href="{{ route('assignments.dosen.edit', $assignment->id) }}"
                               class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2l-6 6M3 21h6l11-11a2.828 2.828 0 00-4-4L5 17v4z"/>
                                </svg>
                                Edit Tugas
                            </a>
                        </li>
                        <!-- Detail -->
                        <li>
                            <a href="{{ route('assignments.dosen.show', $assignment->id) }}"
                               class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Detail
                            </a>
                        </li>
                        <!-- Tugas Terkumpul -->
                        <li>
                            <a href="{{ route('assignments.dosen.submissions', $assignment->id) }}"
                               class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Lihat Tugas Terkumpul
                            </a>
                        </li>
                        <!-- Delete -->
                        <li class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                            <form method="POST" action="{{ route('assignments.dosen.destroy', $assignment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zM4 7h16" />
                                    </svg>
                                    Hapus Tugas
                                </button>
                            </form>
                        </li>
                    </ul>
                    </div>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-2 text-lg font-medium">Belum ada tugas</p>
                    <p class="text-gray-400 dark:text-gray-500 mb-4">Anda belum membuat tugas apapun.</p>
                    <a href="{{ route('assignments.dosen.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition-colors">
                      <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                      </svg>
                      Buat Tugas Baru
                    </a>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
  
        <div class="mt-6 flex justify-between items-center flex-wrap gap-2">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Showing {{ $assignments->firstItem() ?? 0 }} to {{ $assignments->lastItem() ?? 0 }} of {{ $assignments->total() ?? 0 }} data
          </div>
          <div>
            {{ $assignments->appends(['perPage' => $perPage, 'search' => $search])->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

@endsection
