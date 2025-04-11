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

        </main>
      </div>
    </div>
  </body>
</html>
