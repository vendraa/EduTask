@extends('layouts.app')

@section('title', 'Daftar Dosen | EduTask')
@section('page', 'daftarDosen')
@section('selected', 'daftarDosen')
@section('pageName', 'Halaman Daftar Dosen')

@section('content')
<div class="rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12">
  <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Daftar Dosen</h3>

  <div class="flex items-center justify-between mb-4">
    @php $perPage = request()->input('perPage', 10); @endphp
    <div>
      <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tampilkan</label>
      <select id="perPage" name="perPage" onchange="window.location.href='?perPage=' + this.value"
        class="ml-2 px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
      </select>
      <span class="text-sm font-medium text-gray-700 dark:text-gray-300 ml-2">data</span>
    </div>
  </div>

  <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
    <table class="min-w-full text-sm text-left">
      <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        <tr>
          <th class="px-6 py-3 font-medium">Nama Dosen</th>
          <th class="px-6 py-3 font-medium">Email</th>
          <th class="px-6 py-3 font-medium">Role</th>
          <th class="px-6 py-3 font-medium">Tanggal Bergabung</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($lecturers as $lecturer)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
          <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $lecturer->name }}</td>
          <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $lecturer->email }}</td>
          <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ ucfirst($lecturer->role) }}</td>
          <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $lecturer->created_at->format('d F Y H i') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada dosen yang terdaftar.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6 flex justify-between items-center flex-wrap gap-2">
    <div class="text-sm text-gray-700 dark:text-gray-400">
      Menampilkan {{ $lecturers->firstItem() }} sampai {{ $lecturers->lastItem() }} dari {{ $lecturers->total() }} data
    </div>
    <div>
      {{ $lecturers->appends(['perPage' => request('perPage')])->links() }}
    </div>
  </div>
</div>
@endsection
