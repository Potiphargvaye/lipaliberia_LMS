<!-- Sidenav -->  
<div class="fixed left-0 top-0 w-64 h-screen z-50 sidebar-menu transition-transform bg-[#001f4d] flex flex-col">

    <!-- Logo (UNCHANGED) -->
    <a href="#" class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
        <h2 class="font-bold text-2xl">
            Edmol <span class="bg-[#f84525] text-white px-2 rounded-md">School</span>
        </h2>
    </a>

    <!-- ✅ SCROLLABLE MENU AREA (ONLY ADDITION) -->
    <div class="flex-1 overflow-y-auto px-4 mt-4">

        <ul>
            <span class="text-teal-500 font-bold">ADMIN</span>

@can('view dashboard')
<li class="mb-1 group">
    <a href="{{ route('admin.dashboard') }}"
       class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
        <i class="ri-home-2-line mr-3 text-lg"></i>
        <span class="text-sm">Dashboard</span>
    </a>
</li>
@endcan

           @can('manage users')
<li class="mb-1 group"> 
    <!-- Main Users Link -->
    <a href="{{ route('admin.users.index') }}" 
       class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md
              group-[.active]:bg-[#002966] group-[.active]:text-white sidebar-dropdown-toggle">
        <i class='bx bx-user mr-3 text-lg'></i>                
        <span class="text-sm">Users</span>
        <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
    </a>

    <!-- Sub-links Dropdown -->
    <ul class="pl-7 mt-2 hidden group-[.selected]:block">
        
        <li class="mb-4">
            <a href="{{ route('admin.users.index') }}"  
               class="text-[#f84525] text-sm flex items-center
                      hover:text-[#f84525]
                      hover:bg-[#f84525]/10
                      px-2 py-1 rounded-md  
                      transition-colors
                      before:contents-['']
                      before:w-1 before:h-1
                      before:rounded-full
                      before:bg-[#f84525]
                      before:mr-3">
                All
            </a>
        </li> 

        <li class="mb-4">
            <a href="{{ route('admin.users.permissions.edit', auth()->id()) }}"
               class="text-[#f84525] text-sm flex items-center
                      hover:text-[#f84525]
                      hover:bg-[#f84525]/10
                      px-2 py-1 rounded-md
                      transition-colors
                      before:contents-['']
                      before:w-1 before:h-1
                      before:rounded-full
                      before:bg-[#f84525]
                      before:mr-3">
                User Permission
            </a>
        </li> 

    </ul>
</li>
@endcan

@can('view students')
<li class="mb-1 group">
    <a href="{{ route('admin.students.index') }}"
       class="flex font-semibold items-center py-2 px-4 text-white rounded-md
              hover:bg-[#002966] hover:text-white
              {{ request()->is('admin/students*') ? 'bg-[#002966]' : '' }}">
        <i class="ri-graduation-cap-line mr-3 text-lg"></i>
        <span class="text-sm">Students</span>
    </a>
</li>
@endcan

            @can('manage grade assignments')
<li class="mb-1 group">
    <a href="{{ route('admin.grade-assignments') }}" 
       class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
        <i class="ri-file-list-3-line mr-3 text-lg"></i>
        <span class="text-sm">Grade-Assignment</span> 
    </a>
</li>
@endcan

            <li class="mb-1 group">
    <a href="{{ route('admin.announcements.index') }}"
   class="flex font-semibold items-center py-2 px-4 text-white rounded-md
          hover:bg-[#002966] hover:text-white
          {{ request()->is('admin/announcements*') ? 'bg-[#002966]' : '' }}">
    <i class="ri-megaphone-line mr-3 text-lg"></i>
    <span class="text-sm">Announcement</span>
</a>
</li>


<span class="text-gray-400 font-bold">Finance</span>

          @can('manage fees')
<li class="mb-1 group">
    <a href="{{ route('admin.fees.index') }}" class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
        <i class="ri-wallet-3-line mr-3 text-lg"></i>
        <span class="text-sm">Fees-Management</span>
    </a>
</li>
@endcan

           <span class="text-orange-500 hover:text-orange-700 font-bold">Report-Card</span>

           @can('enter student grades')
<li class="mb-1 group">
    <a href="{{ route('grades.entry') }}" 
       class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
      <i class="ri-book-line mr-3 text-lg"></i>
        <span class="text-sm">Grade Entry</span> 
    </a>
</li>
@endcan

           <li class="mb-1 group">
    <!-- Main Report Card Link -->
    <a href="#"
       class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md
              group-[.active]:bg-[#002966] group-[.active]:text-white sidebar-dropdown-toggle">
        <i class="ri-folder-4-line mr-3 text-lg"></i>                
        <span class="text-sm">Report Cards</span>
        <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
    </a>

    <!-- Sub-links Dropdown -->
    <ul class="pl-7 mt-2 hidden group-[.selected]:block">

        <!-- Junior .-->
        <li class="mb-4">
            <a href="{{ route('report.cards.index', 'junior') }}"  
               class="text-[#f84525] text-sm flex items-center
                      hover:text-[#f84525]
                      hover:bg-[#f84525]/10
                      px-2 py-1 rounded-md  
                      transition-colors
                      before:contents-['']
                      before:w-1 before:h-1
                      before:rounded-full
                      before:bg-[#f84525]
                      before:mr-3">
                Junior Report Card
            </a>
        </li> 

        <!-- Elementary -->
        <li class="mb-4">
            <a href="{{ route('report.cards.index', 'elementary') }}"
               class="text-[#f84525] text-sm flex items-center
                      hover:text-[#f84525]
                      hover:bg-[#f84525]/10
                      px-2 py-1 rounded-md
                      transition-colors
                      before:contents-['']
                      before:w-1 before:h-1
                      before:rounded-full
                      before:bg-[#f84525]
                      before:mr-3">
                Elementary Report Card
            </a>
        </li> 

        <!-- Senior -->
        <li class="mb-4">
            <a href="{{ route('report.cards.index', 'senior') }}"
               class="text-[#f84525] text-sm flex items-center
                      hover:text-[#f84525]
                      hover:bg-[#f84525]/10
                      px-2 py-1 rounded-md
                      transition-colors
                      before:contents-['']
                      before:w-1 before:h-1
                      before:rounded-full
                      before:bg-[#f84525]
                      before:mr-3">
                Senior Report Card
            </a>
        </li> 

        <li class="mb-4">
            <a href="{{ route('report.cards.index', 'kindergarten') }}"  
               class="text-[#f84525] text-sm flex items-center
                      hover:text-[#f84525]
                      hover:bg-[#f84525]/10
                      px-2 py-1 rounded-md  
                      transition-colors
                      before:contents-['']
                      before:w-1 before:h-1
                      before:rounded-full
                      before:bg-[#f84525]
                      before:mr-3">
                Kindergarten Report Card
            </a>
        </li> 

    </ul>
</li>

            <span class="text-gray-400 font-bold">BLOG</span>

            <li class="mb-1 group">
                <a href="" class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
                    <i class='bx bxl-blogger mr-3 text-lg'></i>                 
                    <span class="text-sm">Post</span>
                </a>
            </li>

            <li class="mb-1 group">
                <a href="" class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
                    <i class='bx bx-archive mr-3 text-lg'></i>                
                    <span class="text-sm">Archive</span>
                </a>
            </li>

            
            <span class="text-teal-500 font-bold">PERSONAL</span>

            <li class="mb-1 group">
                <a href="" class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#002966] hover:text-white rounded-md">
                    <i class='bx bx-bell mr-3 text-lg'></i>                
                    <span class="text-sm">Notifications</span>
                </a>
            </li>

            <div x-data="{ showLogoutModal: false }">

    <!-- Logout List Item -->
    <li class="mb-1 group">
        <button
            type="button"
            @click="showLogoutModal = true"
            class="flex font-bold items-center py-2 px-4 w-full text-[#f84525] hover:text-white hover:bg-[#002966] rounded-md"
        >
            <i class="ri-shut-down-line mr-3 text-lg text-[#f84525]"></i>
            <span class="text-sm">Logout</span>
        </button>
    </li>

    <!-- Logout Confirm Modal -->
    <div
        x-show="showLogoutModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center
               bg-black/60 backdrop-blur-sm px-2"
    >
        <div
            x-show="showLogoutModal"
            x-transition
            class="bg-white w-full max-w-xs rounded-lg shadow-xl overflow-hidden"
        >
            <!-- Header -->
            <div class="flex items-center justify-between px-3 py-2 bg-red-600 text-white">
                <h3 class="text-xs font-semibold">Confirm Logout</h3>
                <button
                    @click="showLogoutModal = false"
                    class="p-1 rounded-full hover:bg-red-500 transition"
                >
                    <i class="ri-close-line text-sm"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="p-3 space-y-2 text-xs">
                <p class="text-gray-700">
                    Are you sure you want to logout from the system?
                </p>

                <p class="text-red-600 flex items-center gap-1 text-[11px]">
                    <i class="ri-alert-line"></i>
                    You will need to login again to access the system.
                </p>
            </div>

            <!-- Footer -->
     <div class="px-3 py-2 bg-gray-50 border-t flex justify-end gap-1">
    <button
        @click="showLogoutModal = false"
        class="px-2 py-1 text-xs rounded border hover:bg-gray-100"
    >
        Cancel
    </button>

    <form method="POST" action="{{ route('logout') }}" x-data="{ submitting: false }" @submit="submitting = true">
        @csrf
        <button
            type="submit"
            class="px-2 py-1 text-xs font-semibold bg-red-600 text-white rounded
                   hover:bg-red-700 flex items-center gap-2"
            :disabled="submitting"
        >
            <!-- Spinner -->
            <svg x-show="submitting" class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full" viewBox="0 0 24 24"></svg>

            <!-- Button text -->
            <span x-show="!submitting">Logout</span>
            <span x-show="submitting">Logging out…</span>
        </button>
    </form>
     </div>
    </div>
    </div>

</div>

        </ul>

    </div>
</div>

<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
<!-- End Sidenav -->
