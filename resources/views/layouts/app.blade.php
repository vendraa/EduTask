<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'EduTask')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body
    x-data="{
      page: '{{ trim($__env->yieldContent('page', 'blank')) }}',
      loaded: true,
      darkMode: false,
      stickyMenu: false,
      sidebarToggle: false,
      scrollTop: false
    }"
    x-init="
      darkMode = JSON.parse(localStorage.getItem('darkMode') || false);
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
    "
    :class="{ 'dark bg-gray-900': darkMode }"
  >
    <x-preloader />

    <div class="flex h-screen overflow-hidden">
      <x-sidebar
        :page="trim($__env->yieldContent('page', 'blank'))"
        :selected="trim($__env->yieldContent('selected', ''))"
        :sidebarToggle="false"
      />

      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        <x-overlay />
        <x-header />

        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
            <div x-data="{ pageName: `@yield('pageName', 'Blank Page')` }">
              <x-breadcrumb />
            </div>
            @yield('content')
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
