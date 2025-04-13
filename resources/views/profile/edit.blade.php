@extends('layouts.app')

@section('title', 'Profile | EduTask')
@section('page', 'profile')
@section('selected', 'Profile')
@section('pageName', 'Halaman Profile')

@section('content')
  <div
  class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6"
  >
  <h3
    class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7"
  >
    Profile
  </h3>

  <div
    class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6"
  >
    <div
      class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between"
    >
      <div
        class="flex flex-col items-center w-full gap-6 xl:flex-row"
      >
        <div
          class="w-20 h-20 overflow-hidden border border-gray-200 rounded-full dark:border-gray-800"
        >
          <img src="{{ Auth::user()->avatar_url }}" alt="user" />
        </div>
        <div class="order-3 xl:order-2">
          <h4
            class="mb-2 text-lg font-semibold text-center text-gray-800 dark:text-white/90 xl:text-left"
          >
            {{ Str::of(Auth::user()->name)->before(' ') }}
          </h4>        
          <div
            class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left"
          >
            <p class="text-sm text-gray-500 dark:text-gray-400">
              {{ ucfirst(Auth::user()->role) }}
            </p>
          </div>
        </div>

      </div>


    </div>
  </div>

  <div
    class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6"
  >
    <div
      class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between"
    >
      <div>
        <h4
          class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6"
        >
          Personal Information
        </h4>

        <div
          class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32"
        >
          <div>
            <p
              class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400"
            >
              Full Name
            </p>
            <p
              class="text-sm font-medium text-gray-800 dark:text-white/90"
            >
              {{ Auth::user()->name }}
            </p>
          </div>

          <div>
            <p
              class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400"
            >
              Email address
            </p>
            <p
              class="text-sm font-medium text-gray-800 dark:text-white/90"
            >
              {{ Auth::user()->email }}
            </p>
          </div>

          <div>
            <p
              class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400"
            >
              Role
            </p>
            <p
              class="text-sm font-medium text-gray-800 dark:text-white/90"
            >
              {{ ucfirst(Auth::user ()->role)}}
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
  </div>
@endsection
