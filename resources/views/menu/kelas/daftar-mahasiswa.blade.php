@extends('layouts.app')

@section('title', 'Daftar Mahasiswa | EduTask')
@section('page', 'daftarMahasiswa')
@section('selected', 'daftarMahasiswa')
@section('pageName', 'Halaman Daftar Mahasiswa')

@section('content')
  <div class="space-y-5 sm:space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 shadow-sm">
      <div class="px-6 py-5 sm:px-8 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          Daftar Mahasiswa
        </h3>
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
                value="{{ request('search') }}"
                placeholder="Cari mahasiswa berdasarkan nama atau email..."
                class="block w-full pl-10 pr-8 py-2 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-md focus:outline-none focus:ring focus:border-indigo-500"
              />
              <!-- Icon Search -->
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
              </div>
          
              @if(request('search'))
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

        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Mahasiswa</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Bergabung</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
              @forelse($students as $student)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-700 dark:text-gray-300">{{ $student->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                    {{ ucfirst($student->role) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-700 dark:text-gray-300">{{ $student->created_at->format('d M Y, H:i') }}</div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 mb-2 text-lg font-medium">Belum ada mahasiswa</p>
                    <p class="text-gray-400 dark:text-gray-500">Belum ada mahasiswa yang terdaftar dalam sistem.</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-6 flex justify-between items-center flex-wrap gap-2">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Menampilkan {{ $students->firstItem() ?? 0 }} sampai {{ $students->lastItem() ?? 0 }} dari {{ $students->total() ?? 0 }} data
          </div>
          <div>
            {{ $students->appends(['perPage' => request('perPage'), 'search' => request('search')])->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection