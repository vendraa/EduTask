<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 duration-300 ease-linear dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
  @click.outside="sidebarToggle = false"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="sidebar-header flex items-center gap-2 pb-7 pt-8"
  >
    <a href="{{ route(auth()->user()?->role === 'dosen' ? 'dashboard.dosen' : 'dashboard.mahasiswa') }}">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img class="dark:hidden" src="{{ asset('images/logo/logo.svg') }}" alt="Logo" />
        <img
          class="hidden dark:block"
          src="{{ asset('images/logo/logo-dark.svg') }}"
          alt="Logo"
        />
      </span>

      <img
        class="logo-icon"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="{{ asset('images/logo/logo-icon.svg') }}"
        alt="Logo"
      />
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear"
  >
    <!-- Sidebar Menu -->
    <nav x-data="{ selected: '{{ $selected ?? '' }}' }">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            MENU
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        <ul class="mb-6 flex flex-col gap-4">
          <!-- Menu Item Dashboard -->
          @php
            $userRole = auth()->user()?->role;
            $dashboardRoute = $userRole === 'dosen' ? route('dashboard.dosen') : route('dashboard.mahasiswa');
            $isDashboardActive = ($selected ?? '') === 'Dashboard' || ($page ?? '') === 'dashboard';
          @endphp
          <li>
            <a
              href="{{ $dashboardRoute }}"
              @click="selected = (selected === 'Dashboard' ? '' : 'Dashboard')"
              class="menu-item group"
              :class="{{ json_encode($isDashboardActive) }} ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="{{ json_encode($isDashboardActive) }} ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                  fill=""
                />
              </svg>
          
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Dashboard
              </span>
            </a>
          </li>
          <!-- Menu Item Dashboard -->

          <!-- Menu Item Pengumuman -->
          @php
            $userRole = auth()->user()?->role;
            $pengumumanRoute = $userRole === 'dosen' ? route('announcement.dosen.index') : route('announcement.mahasiswa.index');
            $isPengumumanActive = ($selected ?? '') === 'Pengumuman' || ($page ?? '') === 'pengumuman';
          @endphp
          <li>
            <a
              href="{{ $pengumumanRoute }}"
              @click="selected = (selected === 'Pengumuman' ? '' : 'Pengumuman')"
              class="menu-item group"
              :class="{{ json_encode($isPengumumanActive) }} ? 'menu-item-active' : 'menu-item-inactive'"
            >
            <svg
                :class="{{ json_encode($isPengumumanActive) }} ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z"
                  fill=""
                />
              </svg>
          
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                Pengumuman
              </span>
            </a>
          </li>
          <!-- Menu Item Pengumuman -->

          <!-- Menu Item Task -->
          @php
            $currentPage = $page ?? '';
            $selectedMenu = $selected ?? '';
            $isTaskActive = $selectedMenu === 'Task' || in_array($currentPage, ['taskList', 'taskKanban']);
        
            $userRole = auth()->user()?->role;
        
            $taskRoutes = [
                'dosen' => [
                    'create' => route('tasks.dosen.create'),
                    'list' => route('tasks.dosen.index'),
                    'submitted' => route('tasks.dosen.submitted'),
                    'history' => route('tasks.dosen.history'),
                ],
                'mahasiswa' => [
                    'list' => route('tasks.mahasiswa.index'),
                    'history' => route('tasks.mahasiswa.history'),
                ],
            ];
          @endphp
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Task' ? '' : 'Task')"
              class="menu-item group"
              :class="selected === 'Task' || ['taskList', 'taskKanban', 'taskAdd'].includes('{{ $currentPage }}') ? 'menu-item-active' : 'menu-item-inactive'"
            >
            <div class="flex items-center gap-3">
              <svg
                class="shrink-0"
                :class="{{ json_encode($isTaskActive) }} ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M7.75586 5.50098C7.75586 5.08676 8.09165 4.75098 8.50586 4.75098H18.4985C18.9127 4.75098 19.2485 5.08676 19.2485 5.50098L19.2485 15.4956C19.2485 15.9098 18.9127 16.2456 18.4985 16.2456H8.50586C8.09165 16.2456 7.75586 15.9098 7.75586 15.4956V5.50098ZM8.50586 3.25098C7.26322 3.25098 6.25586 4.25834 6.25586 5.50098V6.26318H5.50195C4.25931 6.26318 3.25195 7.27054 3.25195 8.51318V18.4995C3.25195 19.7422 4.25931 20.7495 5.50195 20.7495H15.4883C16.7309 20.7495 17.7383 19.7421 17.7383 18.4995L17.7383 17.7456H18.4985C19.7411 17.7456 20.7485 16.7382 20.7485 15.4956L20.7485 5.50097C20.7485 4.25833 19.7411 3.25098 18.4985 3.25098H8.50586ZM16.2383 17.7456H8.50586C7.26322 17.7456 6.25586 16.7382 6.25586 15.4956V7.76318H5.50195C5.08774 7.76318 4.75195 8.09897 4.75195 8.51318V18.4995C4.75195 18.9137 5.08774 19.2495 5.50195 19.2495H15.4883C15.9025 19.2495 16.2383 18.9137 16.2383 18.4995L16.2383 17.7456Z"
                  fill="currentColor"
                />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Manajemen Tugas</span>
            </div>

              <svg
                class="ml-auto w-5 h-5 self-center"
                :class="[(selected === 'Task') ? 'rotate-180 stroke-brand-500 dark:stroke-brand-400' : 'stroke-gray-500 group-hover:stroke-gray-700 dark:stroke-gray-400 dark:group-hover:stroke-gray-300', sidebarToggle ? 'lg:hidden' : '' ]"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>
          
              <!-- Dropdown Start -->
              <div class="translate transform overflow-hidden" :class="(selected === 'Task') ? 'block' : 'hidden'">
                  <ul :class="['menu-dropdown mt-2 flex flex-col gap-1 pl-9', sidebarToggle ? 'lg:hidden' : 'flex']">
          
                      @if ($userRole === 'dosen')
                          <li>
                              <a href="{{ $taskRoutes['dosen']['create'] }}"
                                  class="menu-dropdown-item group"
                                  :class="page === 'taskAdd' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                  Tambah Tugas
                              </a>
                          </li>
                          <li>
                              <a href="{{ $taskRoutes['dosen']['list'] }}"
                                  class="menu-dropdown-item group"
                                  :class="page === 'taskList' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                  Daftar Tugas
                              </a>
                          </li>
                          <li>
                              <a href="{{ $taskRoutes['dosen']['submitted'] }}"
                                  class="menu-dropdown-item group"
                                  :class="page === 'taskSubmitted' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                  Tugas Terkumpul
                              </a>
                          </li>
                          <li>
                              <a href="{{ $taskRoutes['dosen']['history'] }}"
                                  class="menu-dropdown-item group"
                                  :class="page === 'taskHistory' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                  Riwayat Tugas
                              </a>
                          </li>
                      @elseif ($userRole === 'mahasiswa')
                          <li>
                              <a href="{{ $taskRoutes['mahasiswa']['list'] }}"
                                  class="menu-dropdown-item group"
                                  :class="page === 'taskList' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                  Daftar Tugas
                              </a>
                          </li>
                          <li>
                              <a href="{{ $taskRoutes['mahasiswa']['history'] }}"
                                  class="menu-dropdown-item group"
                                  :class="page === 'taskHistory' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                  Riwayat Tugas
                              </a>
                          </li>
                      @endif
          
                  </ul>
              </div>
              <!-- Dropdown End -->
          </li>
          <!-- Menu Item Task -->

          <!-- Menu Item Tables -->
          @php
            $userRole = auth()->user()?->role;

            $kelasRoutes = [
              'dosen' => [
                'dosenList' => route('daftarDosen.dosen.index'),      // contoh: route('kelas.dosen.index')
                'mahasiswaList' => route('daftarMahasiswa.dosen.index'),
              ],
              'mahasiswa' => [
                'dosenList' => route('daftarDosen.mahasiswa.index'),      // atau kosongkan jika tidak perlu
                'mahasiswaList' => route('daftarMahasiswa.mahasiswa.index'),
              ],
            ];

            $isKelasActive = ($selected ?? '') === 'Kelas' || in_array(($page ?? ''), ['daftarDosen', 'daftarMahasiswa']);
          @endphp
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Kelas' ? '':'Kelas')"
              class="menu-item group"
              :class="{{ json_encode($isKelasActive) }} ? 'menu-item-active' : 'menu-item-inactive'"
            >
            <div class="flex items-center gap-3">
              <svg
                class="shrink-0"
                :class="{{ json_encode($isKelasActive) }} ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z"
                fill=""
              />
              </svg>
              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Manajemen Kelas
              </span>
            </div>

              <svg
                class="ml-auto w-5 h-5 self-center"
                :class="[(selected === 'Kelas') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="translate transform overflow-hidden"
              :class="(selected === 'Kelas') ? 'block' :'hidden'"
            >
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="menu-dropdown mt-2 flex flex-col gap-1 pl-9"
              >
                <li>
                  <a
                    href="{{ $kelasRoutes[$userRole]['dosenList'] }}"
                    class="menu-dropdown-item group"
                    :class="page === 'daftarDosen' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Daftar Dosen
                  </a>
                </li>
                <li>
                  <a
                    href="{{ $kelasRoutes[$userRole]['mahasiswaList'] }}"
                    class="menu-dropdown-item group"
                    :class="page === 'daftarMahasiswa' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
                  >
                    Daftar Mahasiswa
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Tables -->

        </ul>
      </div>

      <!-- Others Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            others
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="menu-group-icon mx-auto fill-current"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        <ul class="mb-6 flex flex-col gap-4">
          <!-- Menu Item Charts -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Charts' ? '':'Charts')"
              class="menu-item group"
              :class="(selected === 'Charts') || (page === 'lineChart' || page === 'barChart' || page === 'pieChart') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'Charts') || (page === 'lineChart' || page === 'barChart' || page === 'pieChart') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 2C11.5858 2 11.25 2.33579 11.25 2.75V12C11.25 12.4142 11.5858 12.75 12 12.75H21.25C21.6642 12.75 22 12.4142 22 12C22 6.47715 17.5228 2 12 2ZM12.75 11.25V3.53263C13.2645 3.57761 13.7659 3.66843 14.25 3.80098V3.80099C15.6929 4.19606 16.9827 4.96184 18.0104 5.98959C19.0382 7.01734 19.8039 8.30707 20.199 9.75C20.3316 10.2341 20.4224 10.7355 20.4674 11.25H12.75ZM2 12C2 7.25083 5.31065 3.27489 9.75 2.25415V3.80099C6.14748 4.78734 3.5 8.0845 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C15.9155 20.5 19.2127 17.8525 20.199 14.25H21.7459C20.7251 18.6894 16.7492 22 12 22C6.47715 22 2 17.5229 2 12Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Your Profile
              </span>
            </a>
          </li>
          <!-- Menu Item Charts -->

          <!-- Menu Item Sign Out -->
          <li>
            <a
              href="#"
              @click.prevent="document.getElementById('logout-form').submit();"
              class="menu-item group"
              :class="(selected === 'SignOut') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <svg
                :class="(selected === 'SignOut') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M15.1007 19.247C14.6865 19.247 14.3507 18.9112 14.3507 18.497L14.3507 14.245H12.8507V18.497C12.8507 19.7396 13.8581 20.747 15.1007 20.747H18.5007C19.7434 20.747 20.7507 19.7396 20.7507 18.497L20.7507 5.49609C20.7507 4.25345 19.7433 3.24609 18.5007 3.24609H15.1007C13.8581 3.24609 12.8507 4.25345 12.8507 5.49609V9.74501L14.3507 9.74501V5.49609C14.3507 5.08188 14.6865 4.74609 15.1007 4.74609L18.5007 4.74609C18.9149 4.74609 19.2507 5.08188 19.2507 5.49609L19.2507 18.497C19.2507 18.9112 18.9149 19.247 18.5007 19.247H15.1007ZM3.25073 11.9984C3.25073 12.2144 3.34204 12.4091 3.48817 12.546L8.09483 17.1556C8.38763 17.4485 8.86251 17.4487 9.15549 17.1559C9.44848 16.8631 9.44863 16.3882 9.15583 16.0952L5.81116 12.7484L16.0007 12.7484C16.4149 12.7484 16.7507 12.4127 16.7507 11.9984C16.7507 11.5842 16.4149 11.2484 16.0007 11.2484L5.81528 11.2484L9.15585 7.90554C9.44864 7.61255 9.44847 7.13767 9.15547 6.84488C8.86248 6.55209 8.3876 6.55226 8.09481 6.84525L3.52309 11.4202C3.35673 11.5577 3.25073 11.7657 3.25073 11.9984Z"
                  fill=""
                />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''"
              >
                Sign Out
              </span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
              @csrf
            </form>
          </li>
          <!-- Menu Item Sign Out -->

        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->
  </div>
</aside>
