<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Blank Page | EduTask</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body
    x-data="{ page: 'blank', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
    x-init="
      darkMode = JSON.parse(localStorage.getItem('darkMode') || false);
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode }"
  >
    {{-- Preloader --}}
    <x-preloader />

    <div class="flex h-screen overflow-hidden">
      {{-- Sidebar --}}
      <x-sidebar :page="$page ?? 'blank'" :selected="$selected ?? ''" :sidebarToggle="false" />

      {{-- Content --}}
      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        {{-- Overlay --}}
        <x-overlay />

        {{-- Header --}}
        <x-header />

        {{-- Main Content --}}
        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
            {{-- Breadcrumb --}}
            <div x-data="{ pageName: 'Blank Page' }">
              <x-breadcrumb />
            </div>

            {{-- Page Card --}}
            <div
              class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/[0.03] xl:px-10 xl:py-12"
            >
              <div class="mx-auto w-full max-w-[630px] text-center">
                <h3 class="mb-4 text-theme-xl font-semibold text-gray-800 dark:text-white/90 sm:text-2xl">
                  Card Title Here
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                  Start putting content on grids or panels, you can also use
                  different combinations of grids. Please check out the
                  dashboard and other pages.
                </p>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
