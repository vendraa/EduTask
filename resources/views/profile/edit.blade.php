@extends('layouts.app')

@section('title', 'Profile | EduTask')
@section('page', 'profile')
@section('selected', 'Profile')
@section('pageName', 'My Profile')

@section('content')
<div x-data="{ open: false }" class="max-w-4xl mx-auto relative">
  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800/90">
    <!-- Profile header with user info -->
    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
      <div class="flex items-center space-x-5">
        <div class="relative group">
          <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md dark:border-gray-700">
            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" />
          </div>
          <div class="absolute inset-0 bg-black/30 rounded-full opacity-0 flex items-center justify-center group-hover:opacity-100 transition-opacity cursor-pointer">
            <span class="text-white text-xs font-medium">Change</span>
          </div>
        </div>
        
        <div>
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ Auth::user()->name }}</h2>
          <div class="flex items-center mt-1">
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300">
              {{ ucfirst(Auth::user()->role) }}
            </span>
          </div>
        </div>
      </div>
      
      <button 
        @click="open = true"
        class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors"
      >
        Edit Profile
      </button>
    </div>

    <!-- Personal Information -->
    <div class="mb-6">
      <div class="flex items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Personal Information</h3>
        <div class="ml-auto flex space-x-2">
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Information Cards -->
        <div class="bg-gray-50 rounded-lg p-4 dark:bg-gray-700/30">
          <p class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400 mb-1">Full Name</p>
          <div class="flex items-center justify-between">
            <p class="text-gray-800 dark:text-white">{{ Auth::user()->name }}</p>
            <button class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300">
              <i class="fas fa-pencil-alt text-xs"></i>
            </button>
          </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 dark:bg-gray-700/30">
          <p class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400 mb-1">Email Address</p>
          <div class="flex items-center justify-between">
            <p class="text-gray-800 dark:text-white">{{ Auth::user()->email }}</p>
            <button class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300">
              <i class="fas fa-pencil-alt text-xs"></i>
            </button>
          </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 dark:bg-gray-700/30">
          <p class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400 mb-1">Role</p>
          <div class="flex items-center justify-between">
            <p class="text-gray-800 dark:text-white">{{ ucfirst(Auth::user()->role) }}</p>
          </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 dark:bg-gray-700/30">
          <p class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400 mb-1">Member Since</p>
          <div class="flex items-center justify-between">
            <p class="text-gray-800 dark:text-white">{{ Auth::user()->created_at->format('M d, Y') }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Activity Summary -->
    <div>
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Activity Summary</h3>
      
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-blue-50 rounded-lg p-4 dark:bg-blue-900/20">
          <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-medium uppercase text-blue-600 dark:text-blue-400">Tasks Completed</p>
            <span class="p-1.5 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-800/50 dark:text-blue-300">
              <i class="fas fa-tasks text-xs"></i>
            </span>
          </div>
          <p class="text-2xl font-bold text-gray-800 dark:text-white">To</p>
        </div>
        
        <div class="bg-green-50 rounded-lg p-4 dark:bg-green-900/20">
          <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-medium uppercase text-green-600 dark:text-green-400">Assignments</p>
            <span class="p-1.5 rounded-full bg-green-100 text-green-600 dark:bg-green-800/50 dark:text-green-300">
              <i class="fas fa-book text-xs"></i>
            </span>
          </div>
          <p class="text-2xl font-bold text-gray-800 dark:text-white">Be</p>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-4 dark:bg-purple-900/20">
          <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-medium uppercase text-purple-600 dark:text-purple-400">Achievements</p>
            <span class="p-1.5 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-800/50 dark:text-purple-300">
              <i class="fas fa-medal text-xs"></i>
            </span>
          </div>
          <p class="text-2xl font-bold text-gray-800 dark:text-white">Determined</p>
        </div>
      </div>
    </div>
    
    <div 
    x-show="open"
    @click.away="open = false"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
  >
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-xl">
      <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Edit Profile</h2>

      <form method="POST" action="{{ auth()->user()->role === 'mahasiswa' ? route('profile.mahasiswa.update') : route('profile.dosen.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
          <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Avatar</label>
          <input type="file" name="avatar" class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div class="flex justify-end space-x-2 mt-6">
          <button 
            type="button"
            @click="open = false"
            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
          >
            Cancel
          </button>
          <button 
            type="submit"
            class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white"
          >
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection