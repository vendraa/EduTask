@extends('layouts.app')

@section('title', 'Daftar Tugas | EduTask')
@section('page', 'taskList')
@section('selected', 'taskList')
@section('pageName', 'Daftar Tugas')

@section('content')

  @if (auth()->user()->role === 'mahasiswa')
    <div x-data="{ tab: 'all' }" class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
      <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <!-- Tabs -->
        <div class="flex gap-2 flex-wrap">
          <button
            @click="tab = 'all'"
            :class="tab === 'all' 
              ? 'bg-gray-300 dark:bg-gray-600 text-indigo-600 dark:text-white' 
              : 'bg-gray-100 dark:bg-black text-gray-600 dark:text-white'"
            class="px-4 py-2 text-sm rounded-lg font-medium"
          >
            All Tasks
          </button>
    
          <button
            @click="tab = 'todo'"
            :class="tab === 'todo' 
              ? 'bg-gray-300 dark:bg-gray-600 text-indigo-600 dark:text-white' 
              : 'bg-gray-100 dark:bg-black text-gray-600 dark:text-white'"
            class="px-4 py-2 text-sm rounded-lg"
          >
            To Do
          </button>

          <button
            @click="tab = 'missed'"
            :class="tab === 'missed' 
              ? 'bg-gray-300 dark:bg-gray-600 text-indigo-600 dark:text-white' 
              : 'bg-gray-100 dark:bg-black text-gray-600 dark:text-white'"
            class="px-4 py-2 text-sm rounded-lg"
          >
            Missed
          </button>
      
          <button
            @click="tab = 'completed'"
            :class="tab === 'completed' 
              ? 'bg-gray-300 dark:bg-gray-600 text-indigo-600 dark:text-white' 
              : 'bg-gray-100 dark:bg-black text-gray-600 dark:text-white'"
            class="px-4 py-2 text-sm rounded-lg"
          >
            Completed
          </button>
        </div>
        
      </div>

      <!-- Divider -->
      <div class="border-t border-gray-200 dark:border-gray-700 my-4 mb-6"></div>

      @php
        $columns = [
            [
                'key' => 'todo',
                'title' => 'To Do',
                'tasks' => $todoTasks,
                'badgeBg' => 'bg-yellow-200',
                'badgeText' => 'text-yellow-700',
            ],
            [
                'key' => 'missed',
                'title' => 'Missed',
                'tasks' => $missedTasks,
                'badgeBg' => 'bg-red-100',
                'badgeText' => 'text-red-800',
            ],
            [
                'key' => 'completed',
                'title' => 'Completed',
                'tasks' => $completedTasks,
                'badgeBg' => 'bg-green-100',
                'badgeText' => 'text-green-800',
            ],
        ];
      @endphp
      
      {{-- ALL VIEW: 3 kolom --}}
      <div x-show="tab === 'all'" class="flex flex-col gap-5">
          @foreach ($columns as $column)
              <x-kanban-column 
                  :title="$column['title']"
                  :count="$column['tasks']->count()"
                  :tasks="$column['tasks']"
                  :badgeBg="$column['badgeBg']"
                  :badgeText="$column['badgeText']"
              />
          @endforeach
      </div>
  
      {{-- VIEW LAINNYA: Full Width --}}
      <div x-show="tab !== 'all'" class="grid grid-cols-1 gap-5">
          @foreach ($columns as $column)
          <template x-if="tab === '{{ $column['key'] }}'">
            <x-kanban-column 
              :title="$column['title']"
              :count="$column['tasks']->count()"
              :tasks="$column['tasks']"
              :badgeBg="$column['badgeBg']"
              :badgeText="$column['badgeText']"
            />
          </template>
          @endforeach
      </div>
  
    </div>
  @else
  <div x-data="assignmentTable()" x-init="fetchAssignments()" class="space-y-5 sm:space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
      <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
          Daftar Tugas
        </h3>
      </div>
      <div class="p-5 border-t border-gray-100 dark:border-gray-700 sm:p-6">
        <div class="overflow-x-auto">
          <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Dropdown jumlah data -->
            @php
              $perPage = request()->input('perPage', 10); // Default ke 10 jika tidak ada
            @endphp
          
            <div x-data="{ perPage: '{{ $perPage }}' }" class="flex items-center gap-2">
              <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tampilkan</label>
              <select id="perPage" name="perPage"
                      x-model="perPage"
                      @change="window.location.href = '{{ url()->current() }}' + '?perPage=' + perPage"
                      class="block w-auto px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-md focus:outline-none focus:ring focus:border-blue-500">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
              </select>
              <span class="text-sm font-medium text-gray-700 dark:text-gray-300">data</span>
            </div>                
          
            <!-- Search bar -->
            <div class="flex items-center gap-2">
              <label for="search" class="text-sm font-medium text-gray-700 dark:text-gray-300">Search:</label>
              <div class="relative">
                <input
                  type="text"
                  id="search"
                  x-model="search"
                  @input.debounce.500ms="fetchAssignments"
                  placeholder="Cari tugas berdasarkan judul..."
                  class="w-full sm:w-64 pl-10 pr-4 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                />
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                  <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <table class="min-w-full text-sm text-left border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
              <tr>
                <th class="px-6 py-3 font-medium">Judul Tugas</th>
                <th class="px-6 py-3 font-medium">Dosen Pembuat</th>
                <th class="px-6 py-3 font-medium">Tanggal Mulai</th>
                <th class="px-6 py-3 font-medium">Tenggat Waktu</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
              <template x-if="assignments.length">
                <template x-for="assignment in assignments" :key="assignment.id">
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <td class="px-6 py-4 text-gray-800 dark:text-gray-100" x-text="assignment.title"></td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300" x-text="assignment.lecturer?.name ?? '-'"></td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300" x-text="formatDate(assignment.start_date)"></td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300" x-text="formatDate(assignment.deadline)"></td>
                    <td class="px-6 py-4">
                      <template x-if="true">
                        <span
                          class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
                          :class="{
                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-300/20 dark:text-yellow-300': assignment.status_dynamic === 'scheduled',
                            'bg-blue-100 text-blue-800 dark:bg-blue-300/20 dark:text-blue-300': assignment.status_dynamic === 'in progress',
                            'bg-green-100 text-green-800 dark:bg-green-300/20 dark:text-green-300': !['scheduled', 'in progress'].includes(assignment.status_dynamic),
                          }"
                          x-text="assignment.status_dynamic.charAt(0).toUpperCase() + assignment.status_dynamic.slice(1)">
                        </span>
                      </template>
                    </td>
                    <td class="px-6 py-4 relative">
                      <div x-data="{ open: false, dropUp: false }" x-init="$nextTick(() => {
                        const rect = $el.getBoundingClientRect();
                        dropUp = (window.innerHeight - rect.bottom) < 150;
                      })" class="relative">
                        <!-- Trigger -->
                        <button @click="open = !open" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
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
                              <a :href="`/dosen/tugas/edit-tugas/${assignment.id}`"
                                 class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
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
                              <a :href="`/dosen/tugas/${assignment.id}/detail`"
                                 class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
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
                              <a :href="`/dosen/tugas/${assignment.id}/tugas-terkumpul`"
                                 class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 4h16v16H4V4z" />
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12l2 2 4-4" />
                                </svg>
                                Lihat Tugas Terkumpul
                              </a>
                            </li>
                            <!-- Delete -->
                            <li>
                              <form method="POST" :action="`/dosen/tugas/${assignment.id}`">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-600/20">
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
                </template>
              </template>
              
              <template x-if="assignments.length === 0">
                <tr>
                  <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada tugas yang ditemukan.
                  </td>
                </tr>
              </template>
            </tbody>
          </table>      
        </div>
        <div class="flex justify-between mt-6 items-center flex-wrap gap-2">
          <div class="text-sm text-gray-700 dark:text-gray-400">
              Showing {{ $assignments->firstItem() }} to {{ $assignments->lastItem() }} of {{ $assignments->total() }} results
          </div>
      
          <div>
              {{ $assignments->appends(['perPage' => request('perPage')])->links() }}
          </div>
      </div>
      
        
      </div>
    </div>
  </div>
  @endif

@endsection


<script>
function assignmentTable() {
  return {
    search: '',
    assignments: [],
    loading: false,

    fetchAssignments() {
      this.loading = true;
      fetch(`/api/tugas?search=${encodeURIComponent(this.search)}`)
        .then(res => res.json())
        .then(data => {
          this.assignments = data;
          this.loading = false;
        });
    },

    formatDate(dateStr) {
      const options = {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      };
      return new Date(dateStr).toLocaleString('id-ID', options);
    }
  }
}
</script>

