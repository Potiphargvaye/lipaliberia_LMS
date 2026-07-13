@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Banner Header -->
    

    <div class="admin-container px-3 sm:px-4 md:px-6 lg:px-8 max-w-full overflow-x-hidden">
    <!-- Header + Assign Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
        <h2 class="text-base sm:text-lg font-bold text-gray-800">Fees Management</h2>
         @can('manage fees')
         <button
    onclick="openModal('assignFeeModal')"
    class="bg-[#0a1f44] text-white px-2.5 py-1 sm:px-3 sm:py-1.5
           rounded-md hover:opacity-90 transition
           flex items-center gap-1
           text-xs font-semibold shadow-sm"
>
    <i class="fas fa-plus text-xs"></i>
    <span class="hidden xs:inline"></span>
    Assign Fees
</button>
@endcan

    </div>

    <!-- Academic Year Filter -->
<div class="academic-year-filter mb-3 w-full">
    <form method="GET" action="{{ route('admin.fees.index') }}" 
          class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 w-full">
        <label for="academic_year" class="text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-0">
            Filter by Academic Year:
        </label>
        <select id="academic_year" name="academic_year" onchange="this.form.submit()" 
                class="mt-1 sm:mt-0 block w-full sm:w-auto text-xs sm:text-sm pl-2 pr-6 py-1.5 
                       border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 
                       focus:border-indigo-500 truncate max-w-full">
            <option value="all" {{ empty($selected_year) || $selected_year == 'all' ? 'selected' : '' }}>
                All Academic Years
            </option>
            @foreach($academic_years as $year)
                <option value="{{ $year }}" class="truncate" {{ $selected_year == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </form>
</div>


    <!-- Statistics Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3 w-full">
        <div class="bg-white rounded-md shadow-sm p-3 w-full border-l-4 border-indigo-500">
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Total Fees Due {{ !empty($selected_year) && $selected_year != 'all' ? "($selected_year)" : '' }}</h3>
            <div class="text-lg sm:text-xl font-bold text-indigo-600">${{ number_format($remaining_fees_due, 2) }}</div>
            <div class="text-xs sm:text-sm text-gray-500 mt-1">
                From {{ $stats->total_records }} fee records
                @if(!empty($selected_year) && $selected_year != 'all')
                    <div class="flex items-center mt-1 text-xs">
                        <i class="fas fa-filter mr-1"></i> Filtered by: {{ $selected_year }}
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-md shadow-sm p-3 w-full border-l-4 border-green-500">
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Total Fees Collected {{ !empty($selected_year) && $selected_year != 'all' ? "($selected_year)" : '' }}</h3>
            <div class="text-lg sm:text-xl font-bold text-green-600">${{ number_format($stats->total_fees_collected, 2) }}</div>
            <div class="text-xs sm:text-sm text-gray-500 mt-1">
                @if($stats->total_fees_due > 0)
                    {{ number_format(($stats->total_fees_collected / $stats->total_fees_due) * 100, 1) }}% collected
                @else
                    No fees due
                @endif
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4 w-full">
        <div class="bg-white rounded-md shadow-sm p-2 text-center border-t-4 border-yellow-500 w-full">
            <span class="bg-yellow-500 inline-block w-2 h-2 rounded-full mb-1"></span>
            <span class="font-semibold text-gray-700 text-xs sm:text-sm">{{ $stats->pending_count }} Pending</span>
        </div>
        <div class="bg-white rounded-md shadow-sm p-2 text-center border-t-4 border-blue-500 w-full">
            <span class="bg-blue-500 inline-block w-2 h-2 rounded-full mb-1"></span>
            <span class="font-semibold text-gray-700 text-xs sm:text-sm">{{ $stats->partial_count }} Partial</span>
        </div>
        <div class="bg-white rounded-md shadow-sm p-2 text-center border-t-4 border-green-500 w-full">
            <span class="bg-green-500 inline-block w-2 h-2 rounded-full mb-1"></span>
            <span class="font-semibold text-gray-700 text-xs sm:text-sm">{{ $stats->paid_count }} Paid</span>
        </div>
        <div class="bg-white rounded-md shadow-sm p-2 text-center border-t-4 border-red-500 w-full">
            <span class="bg-red-500 inline-block w-2 h-2 rounded-full mb-1"></span>
            <span class="font-semibold text-gray-700 text-xs sm:text-sm">{{ $stats->overdue_count }} Overdue</span>
        </div>
    </div>
</div>

<!-- Payment Form -->
<div class="bg-white rounded-md shadow-sm p-4 sm:p-6 mb-4 border border-gray-200 max-w-full overflow-x-hidden">
    <h3 class="text-sm sm:text-base font-semibold text-gray-800 mb-3">Record Payment</h3>
    <form action="{{ route('admin.fees.payment', 0) }}" method="POST" id="paymentForm" class="w-full">
        @csrf

        <!-- First Row: Fee Record + Amount -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 mb-3 w-full">
            <!-- Fee Record -->
            <div class="form-group w-full">
                <label for="fee_id" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Select Fee Record</label>
                <select id="fee_id" name="fee_id" required
                        class="mt-1 block w-full text-xs sm:text-sm pl-2 pr-6 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 truncate">
                    <option value="">Select Fee Record</option>
                    @foreach($fees as $fee)
                        <option value="{{ $fee->fee_id }}">
                            {{ $fee->student->name }} - {{ $fee->fee_type }} (${{ number_format($fee->amount, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Amount Paid -->
            <div class="form-group w-full">
                <label for="paid_amount" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Amount Paid</label>
                <input type="number" id="paid_amount" name="paid_amount" step="0.01" required
                       class="mt-1 block w-full text-xs sm:text-sm pl-2 pr-6 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Second Row: Payment Method + Reference -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 mb-3 w-full">
            <!-- Payment Method -->
            <div class="form-group w-full">
                <label for="payment_method" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select id="payment_method" name="payment_method" required
                        class="mt-1 block w-full text-xs sm:text-sm pl-2 pr-6 py-1.5 border border-gray-300 rounded-md
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 truncate max-w-full">
                    <option value="">Select Method</option>
                    <option value="Cash" class="truncate">Cash</option>
                    <option value="Check" class="truncate">Check</option>
                    <option value="Bank Transfer" class="truncate">Bank Transfer</option>
                    <option value="Credit Card" class="truncate">Credit Card</option>
                    <option value="Mobile Money" class="truncate">Mobile Money</option>
                </select>
            </div>

            <!-- Reference Number -->
            <div class="form-group w-full">
                <label for="reference_number" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                <input type="text" id="reference_number" name="reference_number"
                       class="mt-1 block w-full text-xs sm:text-sm pl-2 pr-6 py-1.5 border border-gray-300 rounded-md
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 truncate max-w-full">
            </div>
        </div>

       <!-- Payment Date + Submit Button -->
<div class="flex items-center gap-2">
    <!-- Payment Date -->
    <div class="relative">
        <label for="payment_date" class="sr-only">Payment Date</label>
        <input type="date" id="payment_date" name="payment_date" required
               class="pl-8 pr-3 py-1.5 border border-gray-300 rounded-md text-xs sm:text-sm
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
               value="{{ date('Y-m-d') }}">
        <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400">
            <i class="fas fa-calendar-alt text-xs sm:text-sm"></i>
        </span>
    </div>

    <!-- Record Button -->
    @can('manage fees')
    <button type="submit"
            class="bg-[#0a1f44] text-white px-3 py-1.5 rounded-md hover:opacity-90 transition flex items-center gap-1 text-xs font-semibold shadow-sm">
        <i class="fas fa-money-bill-wave text-xs"></i>
        Record
    </button>
    @endcan
</div>

    </form>
</div>


        <!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6 border border-gray-200 w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 sm:gap-4 w-full">
        <!-- Search Input -->
        <div class="flex-1 relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 text-sm sm:text-base"></i>
            </div>
            <input 
                type="text" 
                id="feeSearchInput" 
                onkeyup="filterFeesTable()"
                placeholder="Search fees by student, fee type, status, amount..." 
                class="pl-10 pr-10 py-2 sm:py-2.5 border border-gray-300 rounded-md w-full text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 truncate transition-colors duration-300"
            >
            <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
                <button id="clearSearch" class="text-gray-400 hover:text-gray-600 hidden transition-colors duration-200 text-sm sm:text-base">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
<select id="gradeFilter" onchange="filterFeesTable()"
    class="py-1.5 px-2 sm:py-2 sm:px-3 border border-gray-300 rounded-md text-xs sm:text-sm bg-white min-w-[120px] max-w-full truncate focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <option value="">All Grades</option>

    @foreach($grades as $grade)
        <option value="{{ $grade }}">{{ $grade }}</option>
    @endforeach

</select>
        <!-- Filters -->
        <div class="flex flex-wrap gap-2 sm:gap-3 mt-2 md:mt-0">
            <select id="statusFilter" onchange="filterFeesTable()"
             class="py-1.5 px-2 sm:py-2 sm:px-3 border border-gray-300 rounded-md text-xs sm:text-sm bg-white min-w-[120px] max-w-full truncate focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
<option value="partial">Partial</option>
<option value="paid">Paid</option>
<option value="overdue">Overdue</option>
            </select>

           <select id="feeTypeFilter" onchange="filterFeesTable()"
            class="py-1.5 px-2 sm:py-2 sm:px-3 border border-gray-300 rounded-md text-xs sm:text-sm bg-white min-w-[120px] max-w-full truncate focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              
<option value="">All Fee Types</option>
<option value="tuition fee">Tuition Fee</option>
<option value="Registration">Registration</option>
<option value="activity fee">Activity Fee</option>
<option value="technology fee">Technology Fee</option>
<option value="library fee">Library Fee</option>
</select>
            </select>
        </div>
    </div>

    <!-- Results Count & Reset -->
    <div class="mt-3 flex flex-wrap items-center gap-3">
        <span class="text-sm text-gray-600" id="searchResultsCount">
            Showing {{ count($fees) }} records
        </span>
        <button id="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200 font-medium flex items-center gap-1">
            <i class="fas fa-refresh text-xs sm:text-sm"></i> Reset Filters
        </button>
    </div>
</div>

<!-- Loading Spinner --> 
<div id="searchLoadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-4 shadow-2xl w-36 sm:w-44">
        <div class="flex flex-col items-center">
            <div class="relative">
                <i class="fas fa-spinner fa-spin text-2xl text-blue-500 mb-1"></i>
                <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping opacity-20"></div>
            </div>
            <p class="mt-1 text-gray-600 font-medium text-xs sm:text-sm text-center">Searching fees...</p>
            <p class="text-[10px] sm:text-xs text-gray-400 text-center">Please wait while we find the best matches</p>
        </div>
    </div>
</div>



        <!-- Fees Table -->
<h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">Fee Records</h3>
<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
            <thead class="bg-gray-50">
             <tr>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">No.</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Student</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Class</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Fee Type</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Installment</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Amount</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Paid</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Balance</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
        <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Actions</th>
    </tr>

            </thead>
           <tbody class="bg-white divide-y divide-gray-200" id="feesTableBody">

@foreach($fees as $index => $fee)
<tr class="hover:bg-gray-50 transition-colors duration-200 fee-row">

    <td class="px-3 py-2 whitespace-nowrap text-gray-900">
        {{ $loop->iteration }}
    </td>

    <!-- Student Name -->
    <td class="px-3 py-2 whitespace-nowrap text-gray-900 student-name">
        {{ $fee->student->name }}
    </td>

    <!-- Grade -->
    <td class="px-3 py-2 whitespace-nowrap text-xs font-black grade"
        style="font-family: Arial Black; color: #0a1f44;">
        {{ $fee->student->class_applying_for ?? 'N/A' }}
    </td>

    <!-- Fee Type -->
    <td class="px-3 py-2 whitespace-nowrap text-gray-900 fee-type">
        {{ $fee->fee_type }}
    </td>

    <td class="px-3 py-2 whitespace-nowrap text-gray-900">
        {{ $fee->installment_number }}
    </td>

    <td class="px-3 py-2 whitespace-nowrap text-green-600 font-semibold">
        ${{ number_format($fee->amount, 2) }}
    </td>

    <td class="px-3 py-2 whitespace-nowrap text-gray-900">
        ${{ number_format($fee->paid_amount, 2) }}
    </td>

    <td class="px-3 py-2 whitespace-nowrap text-red-600 font-semibold">
        ${{ number_format($fee->amount - $fee->paid_amount, 2) }}
    </td>

    <td class="px-3 py-2 whitespace-nowrap text-gray-900">
        {{ $fee->due_date->format('M j, Y') }}
    </td>

    <!-- Status -->
    <td class="px-3 py-2 whitespace-nowrap status">

        @php
            $statusClasses = [
                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'partial' => 'bg-blue-100 text-blue-800 border-blue-200',
                'paid' => 'bg-green-100 text-green-800 border-green-200',
                'overdue' => 'bg-red-100 text-red-800 border-red-200'
            ];
            $statusClass = $statusClasses[$fee->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
        @endphp

        <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium border {{ $statusClass }}">
            {{ ucfirst($fee->status) }}
        </span>

    </td>

    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium">
      <div class="flex space-x-1">
    @can('view fee details')
    <button onclick="viewFee({{ $fee->fee_id }})" class="bg-blue-600 hover:bg-blue-700 text-white p-1 rounded-md flex items-center justify-center">
        <i class="fas fa-eye text-xs"></i>
    </button>
    @endcan

    @can('edit fees')
    <button onclick="editFee({{ $fee->fee_id }})" class="bg-yellow-600 hover:bg-yellow-700 text-white p-1 rounded-md flex items-center justify-center">
        <i class="fas fa-edit text-xs"></i>
    </button>
    @endcan

    @can('delete fees')
    <button onclick="confirmDelete({{ $fee->fee_id }}, '{{ addslashes($fee->student->name . ' - ' . $fee->fee_type) }}')" class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-md flex items-center justify-center">
        <i class="fas fa-trash text-xs"></i>
    </button>
    @endcan
</div>
    </td>
</tr>
@endforeach

            </tbody>
        </table>
    </div>
</div>

    </div>
</div>

<!-- Modals -->
<!-- Assign Fee Modal -->
<div id="assignFeeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-2">
        <div
            id="assignFeeModalContent"
            class="bg-white rounded-md shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300"
        >

            <!-- Header -->
            <div class="bg-[#0a1f44] text-white px-4 py-3 rounded-t-md flex justify-between items-center">
                <h3 class="text-sm sm:text-base font-semibold">Assign New Fee</h3>
                <button
                    class="text-red-500 text-xl hover:text-red-700"
                    onclick="closeModal('assignFeeModal')"
                >&times;</button>
            </div>

            <!-- Body -->
            <div class="p-3">
                <form action="{{ route('admin.fees.store') }}" method="POST" id="assignFeeForm">
                    @csrf

                    <!-- Student & Fee Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Student</label>
                            <select
                                name="student_id"
                                required
                                class="w-full text-xs py-1.5 px-2 border rounded-md focus:ring-1 focus:ring-indigo-500"
                            >
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->student_id }}">
                                        {{ $student->name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Fee Type</label>
                            <select
                                name="fee_type"
                                required
                                class="w-full text-xs py-1.5 px-2 border rounded-md focus:ring-1 focus:ring-indigo-500"
                            >
                                <option value="">Select Fee Type</option>
                                <option>Tuition Fee</option>
                                <option>Registration</option>
                                <option>Activity Fee</option>
                                <option>Technology Fee</option>
                                <option>Library Fee</option>
                            </select>
                        </div>
                    </div>

                    <!-- Installment & Academic Year -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Installment</label>
                            <select
                                name="installment_number"
                                class="w-full text-xs py-1.5 px-2 border rounded-md"
                            >
     <option value="Registration Fees">Registration Fees</option>
    <option value="1st installment">1st installment</option>
    <option value="2nd installment">2nd installment</option>
    <option value="3rd installment">3rd installment</option>
    <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Academic Year</label>
                            <input
                                type="text"
                                name="academic_year"
                                value="{{ date('Y') . '/' . (date('Y') + 1) }}"
                                required
                                class="w-full text-xs py-1.5 px-2 border rounded-md"
                            >
                        </div>
                    </div>

                    <!-- Amount & Due Date -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Amount</label>
                            <input
                                type="number"
                                step="0.01"
                                name="amount"
                                required
                                class="w-full text-xs py-1.5 px-2 border rounded-md"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Due Date</label>
                            <input
                                type="date"
                                name="due_date"
                                required
                                class="w-full text-xs py-1.5 px-2 border rounded-md"
                            >
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-3 py-2 rounded-b-md flex justify-end gap-2">
                        <!-- Cancel (UNCHANGED per request) -->
                        <button
    type="button"
    class="bg-red-600 text-white px-3 py-1 text-xs rounded-md hover:bg-red-700 flex items-center gap-1"
    onclick="closeModal('assignFeeModal')"
>
    <i class="fas fa-times text-xs"></i>
    Close
</button>

<button
    type="submit"
    class="bg-[#0a1f44] text-white px-3 py-1 text-xs rounded-md hover:opacity-90 flex items-center gap-1"
>
    <i class="fas fa-save text-xs"></i>
    Assign
</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Delete Fee Modal -->
<div
    id="deleteFeeModal"
    class="fixed inset-0 z-50 hidden
           flex items-center justify-center
           bg-black/60 backdrop-blur-sm px-2"
>
    <!-- Modal Box -->
    <div
        id="deleteFeeModalContent"
        class="bg-white w-full max-w-xs rounded-lg shadow-xl overflow-hidden
               transform scale-95 opacity-0 transition-all duration-200"
    >

        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 bg-red-600 text-white">
            <h3 class="text-xs font-semibold">Confirm Delete</h3>

            <button
                onclick="closeModal('deleteFeeModal')"
                class="p-1 rounded-full hover:bg-red-500 transition"
            >
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-3 space-y-2 text-xs">
            <p class="text-gray-700">
                Are you sure you want to delete this fee record?
            </p>

            <!-- Fee Details -->
            <div
                id="delete-fee-details"
                class="p-2 rounded-md bg-gray-50 border
                       text-gray-800 font-medium text-xs"
            >
                Selected fee
            </div>

            <p class="text-red-600 flex items-center gap-1 text-[11px]">
                <i class="fas fa-exclamation-triangle"></i>
                This action cannot be undone.
            </p>
        </div>

        <!-- Footer -->
        <div class="px-3 py-2 bg-gray-50 border-t flex justify-end gap-1">
            <button
                type="button"
                onclick="closeModal('deleteFeeModal')"
                class="px-2 py-1 text-xs rounded border hover:bg-gray-100"
            >
                Cancel
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="px-2 py-1 text-xs font-semibold
                           bg-red-600 text-white rounded
                           hover:bg-red-700
                           flex items-center gap-1"
                >
                    <i class="fas fa-trash text-xs"></i>
                    Delete
                </button>
            </form>
        </div>

    </div>
</div>

<!-- View Fee Modal -->
<div id="viewFeeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-2">
        <div
            id="viewFeeModalContent"
            class="bg-white rounded-md shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300"
        >

            <!-- Header -->
            <div class="bg-[#0a1f44] text-white px-4 py-3 rounded-t-md flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <button
                        onclick="enhancedPrintFeeDetails()"
                        class="bg-white bg-opacity-20 p-1.5 rounded-md hover:bg-opacity-30 transition"
                        title="Print Fee Details"
                    >
                        <i class="fas fa-print text-xs"></i>
                    </button>
                    <h3 class="text-sm sm:text-base font-semibold">Fee Details</h3>
                </div>

                <button
                    class="text-red-500 text-xl hover:text-red-700"
                    onclick="closeModal('viewFeeModal')"
                >&times;</button>
            </div>

            <!-- Body -->
            <div class="p-3 text-xs">
                <div id="printable-fee-details">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="font-medium text-gray-600">Student</label>
                            <p class="text-gray-900 truncate" id="view-student">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Fee Type</label>
                            <p class="text-gray-900 truncate" id="view-fee-type">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Installment</label>
                            <p class="text-gray-900" id="view-installment">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Academic Year</label>
                            <p class="text-gray-900" id="view-academic-year">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Amount</label>
                            <p class="text-gray-900 font-semibold" id="view-amount">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Paid</label>
                            <p class="text-gray-900 font-semibold" id="view-paid-amount">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Due Date</label>
                            <p class="text-gray-900" id="view-due-date">Loading...</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600">Status</label>
                            <p id="view-status">Loading...</p>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div class="mt-4">
                        <h4 class="font-semibold text-gray-700 mb-2 text-xs">
                            Payment History
                        </h4>

                        <div
                            id="payment-history-container"
                            class="space-y-2 max-h-48 overflow-y-auto pr-1"
                        >
                            <!-- Dynamic payments -->
                        </div>
                    </div>




                    <!-- Installments Table -->
<div class="mt-4">
    <h4 class="font-semibold text-gray-700 mb-2 text-xs">All Installments</h4>
    <table class="min-w-full text-xs border border-gray-200 rounded-md">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-2 py-1 text-left font-medium text-gray-500">Installment</th>
                <th class="px-2 py-1 text-left font-medium text-gray-500">Amount</th>
            </tr>
        </thead>
        <tbody id="installments-table-body" class="divide-y divide-gray-200">
            <!-- Dynamic rows inserted via JS -->
        </tbody>
    </table>
</div>

                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-3 py-2 rounded-b-md flex justify-end">
                <button
                    type="button"
                    class="bg-[#0a1f44] text-white px-3 py-1 text-xs rounded-md hover:opacity-90 flex items-center gap-1"
                    onclick="closeModal('viewFeeModal')"
                >
                    <i class="fas fa-times text-xs"></i>
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


<!-- Edit Fee Modal -->
<div id="editFeeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="fixed inset-0 flex items-center justify-center p-2">
        <div
            id="editFeeModalContent"
            class="bg-white rounded-md shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300"
        >

            <!-- Header -->
            <div class="bg-[#0a1f44] text-white px-4 py-3 rounded-t-md flex justify-between items-center">
                <h3 class="text-sm sm:text-base font-semibold">Edit Fee</h3>
                <button
                    class="text-red-500 text-xl hover:text-red-700"
                    onclick="closeModal('editFeeModal')"
                >&times;</button>
            </div>

            <!-- Body -->
            <div class="p-3">
                <form id="editFeeForm" method="POST" class="text-xs">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit-fee-id" name="fee_id">

                    <!-- Fee Type & Installment -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Fee Type</label>
                            <select
                                id="edit-fee-type"
                                name="fee_type"
                                required
                                class="w-full py-1.5 px-2 border rounded-md text-xs focus:ring-1 focus:ring-indigo-500"
                            >
                                <option value="">Select Fee Type</option>
                                <option value="Tuition Fee">Tuition Fee</option>
                                <option value="Registration Fee">Registration</option>
                                <option value="Activity Fee">Activity Fee</option>
                                <option value="Technology Fee">Technology Fee</option>
                                <option value="Library Fee">Library Fee</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Installment</label>
                            <select
                                id="edit-installment"
                                name="installment_number"
                                required
                                class="w-full py-1.5 px-2 border rounded-md text-xs"
                            >
     <option value="Registration Fees">Registration Fees</option>
     <option value="1st installment">1st installment</option>
    <option value="2nd installment">2nd installment</option>
    <option value="3rd installment">3rd installment</option>
    <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Amount & Paid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Amount</label>
                            <input
                                type="number"
                                id="edit-amount"
                                name="amount"
                                step="0.01"
                                required
                                class="w-full py-1.5 px-2 border rounded-md text-xs"
                            >
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Paid Amount</label>
                            <input
                                type="number"
                                id="edit-paid-amount"
                                name="paid_amount"
                                step="0.01"
                                class="w-full py-1.5 px-2 border rounded-md text-xs"
                            >
                        </div>
                    </div>

                    <!-- Due Date & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Due Date</label>
                            <input
                                type="date"
                                id="edit-due-date"
                                name="due_date"
                                required
                                class="w-full py-1.5 px-2 border rounded-md text-xs"
                            >
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Status</label>
                            <select
                                id="edit-status"
                                name="status"
                                required
                                class="w-full py-1.5 px-2 border rounded-md text-xs"
                            >
                                <option value="pending">Pending</option>
                                <option value="partial">Partial</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-3 py-2 rounded-b-md flex justify-end gap-2">
                        <button
                            type="button"
                            class="bg-red-600 text-white px-3 py-1 text-xs rounded-md hover:bg-red-700 flex items-center gap-1"
                            onclick="closeModal('editFeeModal')"
                        >
                            <i class="fas fa-times text-xs"></i>
                            Close
                        </button>

                        <button
                            type="submit"
                            class="bg-[#0a1f44] text-white px-3 py-1 text-xs rounded-md hover:opacity-90 flex items-center gap-1"
                        >
                            <i class="fas fa-save text-xs"></i>
                            Update
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<script>
// ==========NOTIFICATION SYSTEM ==========
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');

    const styles = {
        success: 'bg-green-600 border-green-700',
        error: 'bg-red-600 border-red-700',
        warning: 'bg-yellow-500 border-yellow-700',
        info: 'bg-blue-600 border-blue-700'
    };

    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-triangle',
        warning: 'fa-exclamation-circle',
        info: 'fa-info-circle'
    };

    notification.className = `
        fixed top-3 right-3 sm:top-4 sm:right-4 z-50
        transform translate-x-full opacity-0
        transition-all duration-300 ease-out
        ${styles[type]}
        text-white
        px-3 py-2
        rounded-lg shadow-lg
        border-l-4
        w-auto max-w-[90vw] sm:max-w-xs
        text-xs sm:text-sm
    `;

    notification.innerHTML = `
        <div class="flex items-start gap-2">
            <i class="fas ${icons[type]} text-sm sm:text-base mt-0.5"></i>
            <span class="flex-1 leading-snug">${message}</span>
            <button
                onclick="this.closest('div').parentElement.remove()"
                class="ml-1 text-white opacity-80 hover:opacity-100 transition"
                aria-label="Close notification"
            >
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Slide in
    setTimeout(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
        notification.classList.add('translate-x-0', 'opacity-100');
    }, 20);

    // Auto close
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.remove('translate-x-0', 'opacity-100');
            notification.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                notification.remove();
            }, 700);
        }
    }, 7000);
}

// Helper wrappers (UNCHANGED API)
function showSuccessMessage(message) {
    showNotification(message, 'success');
}

function showErrorMessage(message) {
    showNotification(message, 'error');
}

function showWarningMessage(message) {
    showNotification(message, 'warning');
}

function showInfoMessage(message) {
    showNotification(message, 'info');
}

// ========== MODAL FUNCTIONS ==========
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalId + 'Content');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalId + 'Content');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function closeAssignFeeModal() {
    closeModal('assignFeeModal');
    // Auto reload the page after modal closes
    setTimeout(() => {
        window.location.reload();
    }, 100);
}

// ========== DELETE FEE FUNCTIONALITY ==========
function confirmDelete(feeId, feeDetails) {
    document.getElementById('delete-fee-details').textContent = feeDetails;
    document.getElementById('deleteForm').action = '/admin/fees/' + feeId;
    openModal('deleteFeeModal');
}

function closeDeleteFeeModal() {
    closeModal('deleteFeeModal');
}

// Handle delete form submission with AJAX
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Delete fee form submitted via AJAX');
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';
            submitButton.disabled = true;

            fetch(this.action, {
                method: 'DELETE', 
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.redirected) {
                    return { success: true };
                }
                
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                console.log('Delete success data:', data);
                if (data.success) {
                    closeDeleteFeeModal();
                    showSuccessMessage('Fee record deleted successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to delete fee record');
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                showErrorMessage('Failed to delete fee record: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }
});

// ========== VIEW FEE FUNCTIONALITY ==========
async function viewFee(feeId) {
    console.log('Opening view modal for fee ID:', feeId);
    
    // Show loading state
    showInfoMessage('Loading fee details...');
    
    try {
        // Show loading states in modal
        setViewModalLoading(true);
        openModal('viewFeeModal');
        
        // Fetch real data from server
        const response = await fetch(`/admin/fees/${feeId}/details`);
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`Server returned ${response.status} status`);
        }
        
        const result = await response.json();
        console.log('Fee data received:', result);
        
        // Check if the request was successful
        if (result.success) {
            // Update modal with real data
            updateViewModalWithData(result);
            
            // Show success message
            showSuccessMessage('Fee details loaded successfully!');
        } else {
            throw new Error(result.message || 'Failed to load fee details');
        }
        
    } catch (error) {
        console.error('Error fetching fee details:', error);
        showErrorMessage('Failed to load fee details: ' + error.message);
        closeModal('viewFeeModal');
    }
}

function closeViewFeeModal() {
    closeModal('viewFeeModal');
}

// ========== EDIT FEE FUNCTIONALITY ==========
async function editFee(feeId) {
    console.log('Opening edit modal for fee ID:', feeId);
    
    // Show loading state
    showInfoMessage('Loading fee data for editing...');
    
    try {
        // Fetch real data from server
        const response = await fetch(`/admin/fees/${feeId}/edit`);
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`Server returned ${response.status} status`);
        }
        
        const result = await response.json();
        console.log('Edit data received:', result);
        
        // Check if the request was successful
        if (result.success) {
            // Populate form with real data
            populateEditForm(result);
            openModal('editFeeModal');
            
            // Show success message
            showSuccessMessage('Fee data loaded successfully!');
        } else {
            throw new Error(result.message || 'Failed to load fee data for editing');
        }
        
    } catch (error) {
        console.error('Error fetching fee data for editing:', error);
        showErrorMessage('Failed to load fee data for editing: ' + error.message);
    }
}

function closeEditFeeModal() {
    closeModal('editFeeModal');
}

// Handle edit form submission with AJAX
document.addEventListener('DOMContentLoaded', function() {
    const editFeeForm = document.getElementById('editFeeForm');
    if (editFeeForm) {
        editFeeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Edit fee form submitted via AJAX');
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
            submitButton.disabled = true;

            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.redirected) {
                    return { success: true };
                }
                
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    closeEditFeeModal();
                    showSuccessMessage('Fee record updated successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to update fee record');
                }
            })
            .catch(error => {
                console.error('Edit error:', error);
                showErrorMessage('Failed to update fee record: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }
});

// ========== ASSIGN FEE FUNCTIONALITY ==========
document.addEventListener('DOMContentLoaded', function() {
    const assignFeeForm = document.getElementById('assignFeeForm');
    if (assignFeeForm) {
        assignFeeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Assign fee form submitted via AJAX');
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Assigning...';
            submitButton.disabled = true;

            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.redirected) {
                    return { success: true };
                }
                
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    closeAssignFeeModal();
                    showSuccessMessage('Fee assigned successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to assign fee');
                }
            })
            .catch(error => {
                console.error('Assign fee error:', error);
                showErrorMessage('Failed to assign fee: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }
});

// ========== PAYMENT FUNCTIONALITY ==========
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Payment form submitted via AJAX');
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            submitButton.disabled = true;

            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.redirected) {
                    return { success: true };
                }
                
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        return { success: true };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    // Reset form
                    this.reset();
                    showSuccessMessage('Payment recorded successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to record payment');
                }
            })
            .catch(error => {
                console.error('Payment error:', error);
                showErrorMessage('Failed to record payment: ' + error.message);
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    }

    // Update payment form action dynamically
    const feeIdSelect = document.getElementById('fee_id');
    if (feeIdSelect) {
        feeIdSelect.addEventListener('change', function() {
            const feeId = this.value;
            const form = document.getElementById('paymentForm');
            form.action = `/admin/fees/${feeId}/payment`;
        });
    }
});

// ========== HELPER FUNCTIONS ==========
function setViewModalLoading(loading) {
    const elements = [
        'view-student', 'view-fee-type', 'view-installment', 
        'view-academic-year', 'view-amount', 'view-paid-amount', 
        'view-due-date', 'view-status'
    ];
    
    elements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = loading ? 'Loading...' : '';
        }
    });
}

function updateViewModalWithData(feeData) {
    // ---------- Existing Fee Details ----------
    document.getElementById('view-student').innerHTML = `
    ${feeData.student.name} (ID: ${feeData.student.student_id})
    <div class="mt-1 text-[14px]"
         style="color:#0a1f44; font-family:'Arial Black', Arial, sans-serif;">
     Class: ${feeData.student.class_applying_for}

    </div>
`;

    document.getElementById('view-fee-type').textContent = feeData.fee_type;
    document.getElementById('view-installment').textContent = feeData.installment_number;
    document.getElementById('view-academic-year').textContent = feeData.academic_year;
    document.getElementById('view-amount').textContent = `$${parseFloat(feeData.amount).toFixed(2)}`;
    document.getElementById('view-paid-amount').textContent = `$${parseFloat(feeData.paid_amount).toFixed(2)}`;
    document.getElementById('view-due-date').textContent = new Date(feeData.due_date).toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });

    const statusClass = {
        'pending': 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'partial': 'bg-blue-100 text-blue-800 border-blue-200',
        'paid': 'bg-green-100 text-green-800 border-green-200',
        'overdue': 'bg-red-100 text-red-800 border-red-200'
    }[feeData.status] || 'bg-gray-100 text-gray-800 border-gray-200';

    document.getElementById('view-status').innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-medium border ${statusClass}">${feeData.status.charAt(0).toUpperCase() + feeData.status.slice(1)}</span>`;

    // ---------- New Installments Table ----------
    const tbody = document.getElementById('installments-table-body');
    if(tbody) {
        tbody.innerHTML = ''; // Clear old rows if any

        // Loop through all installments
        feeData.installments_table.forEach(item => {
            const row = document.createElement('tr');

            const installmentCell = document.createElement('td');
            installmentCell.className = 'px-2 py-1 text-gray-900';
            installmentCell.textContent = item.installment;

            const amountCell = document.createElement('td');
            amountCell.className = 'px-2 py-1 font-semibold';
            amountCell.textContent = item.amount === 'Not assigned' ? 'Not assigned' : `$${parseFloat(item.amount).toFixed(2)}`;
            if(item.amount !== 'Not assigned') amountCell.classList.add('text-green-600'); // Optional color for assigned amounts

            row.appendChild(installmentCell);
            row.appendChild(amountCell);
            tbody.appendChild(row);
        });
    }
}


function populateEditForm(feeData) {
    document.getElementById('edit-fee-id').value = feeData.fee_id;
    document.getElementById('edit-fee-type').value = feeData.fee_type;
    document.getElementById('edit-installment').value = feeData.installment_number;
    document.getElementById('edit-amount').value = feeData.amount;
    document.getElementById('edit-paid-amount').value = feeData.paid_amount;
    document.getElementById('edit-due-date').value = feeData.due_date;
    document.getElementById('edit-status').value = feeData.status;
    
    document.getElementById('editFeeForm').action = `/admin/fees/${feeData.fee_id}`;
}

function getOrdinalSuffix(number) {
    const suffixes = [ ''];
    const value = number % 100;
    return suffixes[(value - 20) % 10] || suffixes[value] || suffixes[0];
}
// ========== SEARCH AND FILTER FUNCTIONALITY ==========
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('feeSearchInput');
    const statusFilter = document.getElementById('statusFilter');
    const feeTypeFilter = document.getElementById('feeTypeFilter');
    const gradeFilter = document.getElementById('gradeFilter');
    const clearSearchBtn = document.getElementById('clearSearch');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const searchResultsCount = document.getElementById('searchResultsCount');
    const feesTableBody = document.getElementById('feesTableBody');
    
    const tableRows = document.querySelectorAll('.fee-row');
    let searchTimeout;

    let activeFilters = {
        search: '',
        status: '',
        feeType: '',
        grade: ''
    };
    
    // Initial count
    updateResultsCount(tableRows.length);
    
    function showLoadingSpinner() {
        const spinner = document.getElementById('searchLoadingSpinner');
        const rows = feesTableBody.querySelectorAll('.fee-row');
        
        if (rows) {
            rows.forEach(row => {
                row.style.opacity = '0.6';
            });
        }
        
        spinner.classList.remove('hidden');
    }

    function hideLoadingSpinner() {
        const spinner = document.getElementById('searchLoadingSpinner');
        const rows = feesTableBody.querySelectorAll('.fee-row');
        
        if (rows) {
            rows.forEach(row => {
                row.style.opacity = '1';
            });
        }
        
        spinner.classList.add('hidden');
    }
    
    // Search input event with debouncing and spinner
    searchInput.addEventListener('input', function(e) {
        activeFilters.search = e.target.value.toLowerCase();
        clearSearchBtn.classList.toggle('hidden', !e.target.value);
        
        showLoadingSpinner();
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            filterTable();
            setTimeout(() => {
                hideLoadingSpinner();
            }, 300);
        }, 500);
    });
    
    // Status filter event
    statusFilter.addEventListener('change', function(e) {
        activeFilters.status = e.target.value;
        showLoadingSpinner();
        setTimeout(() => {
            filterTable();
            hideLoadingSpinner();
        }, 300);
    });
    
    // Fee type filter event
    feeTypeFilter.addEventListener('change', function(e) {
        activeFilters.feeType = e.target.value;
        showLoadingSpinner();
        setTimeout(() => {
            filterTable();
            hideLoadingSpinner();
        }, 300);
    });

    // Grade filter event
    gradeFilter.addEventListener('change', function(e) {
        activeFilters.grade = e.target.value.toLowerCase();
        showLoadingSpinner();
        setTimeout(() => {
            filterTable();
            hideLoadingSpinner();
        }, 300);
    });
    
    // Clear search button
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        activeFilters.search = '';
        clearSearchBtn.classList.add('hidden');
        showLoadingSpinner();
        setTimeout(() => {
            filterTable();
            hideLoadingSpinner();
        }, 300);
    });
    
    // Reset all filters
    resetFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        feeTypeFilter.value = '';
        gradeFilter.value = '';

        activeFilters = {
            search: '',
            status: '',
            feeType: '',
            grade: ''
        };

        clearSearchBtn.classList.add('hidden');
        showLoadingSpinner();
        setTimeout(() => {
            filterTable();
            hideLoadingSpinner();
        }, 300);
    });
    
    // Filter table function
function filterTable() {

    let visibleCount = 0;

    tableRows.forEach(row => {

        const studentName = row.cells[1].textContent.trim().toLowerCase();
        const grade = row.cells[2].textContent.trim().toLowerCase();
        const feeType = row.cells[3].textContent.trim().toLowerCase();
        const installment = row.cells[4].textContent.trim().toLowerCase();
        const amount = row.cells[5].textContent.trim().toLowerCase();
        const paidAmount = row.cells[6].textContent.trim().toLowerCase();
        const balance = row.cells[7].textContent.trim().toLowerCase();
        const dueDate = row.cells[8].textContent.trim().toLowerCase();
        const status = row.cells[9].textContent.trim().toLowerCase();

        const search = activeFilters.search.trim().toLowerCase();
        const statusFilter = activeFilters.status.trim().toLowerCase();
        const feeTypeFilter = activeFilters.feeType.trim().toLowerCase();
        const gradeFilter = activeFilters.grade.trim().toLowerCase();

        // Search match
        const matchesSearch =
            !search ||
            studentName.includes(search) ||
            feeType.includes(search) ||
            installment.includes(search) ||
            amount.includes(search) ||
            paidAmount.includes(search) ||
            balance.includes(search) ||
            dueDate.includes(search) ||
            status.includes(search);

        // Status match
        const matchesStatus =
            !statusFilter || status.includes(statusFilter);

        // Fee type match
        const matchesFeeType =
            !feeTypeFilter || feeType.includes(feeTypeFilter);

        // Grade match
        const matchesGrade =
            !gradeFilter || grade.includes(gradeFilter);

        if (matchesSearch && matchesStatus && matchesFeeType && matchesGrade) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }

    });

    updateResultsCount(visibleCount);
}
    function updateResultsCount(count) {
        searchResultsCount.textContent = `Showing ${count} record${count !== 1 ? 's' : ''}`;
        
        searchResultsCount.classList.add('text-blue-600', 'scale-105');
        setTimeout(() => {
            searchResultsCount.classList.remove('text-blue-600', 'scale-105');
        }, 500);
    }
    
    // Keyboard shortcut for search
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
        }
    });
});
// ========== MODAL CLOSE HANDLERS ==========
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed') && event.target.id.includes('Modal')) {
        const modalId = event.target.id;
        closeModal(modalId);
    }
});

// ========== ENHANCED PRINT FUNCTION (PRO DOCUMENT) ==========
function enhancedPrintFeeDetails() {

    const printableContent = document
        .getElementById('printable-fee-details')
        .cloneNode(true);

    const printHeader = printableContent.querySelector('.print-header');
    if (printHeader) {
        printHeader.classList.remove('hidden');
    }

    const schoolName =
        document.querySelector('.school-name')?.textContent ||
        'EDMOL Baptist School';

    // FULL LOGO PATH (fixes watermark issue)
    const logoPath = window.location.origin + "/kiddos-school-master/images/School_logo_reciept.jpeg";  

    const printWindow = window.open('', '_blank', 'width=900,height=650');

    printWindow.document.write(`
<!DOCTYPE html>
<html>
<head>
<title>Fee Receipt - ${schoolName}</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    margin:15px;
    font-size:13px;
    color:#000;
    position:relative;
}

/* WATERMARK LOGO */
body::before{
    content:"";
    position:fixed;
    top:50%;
    left:50%;
    width:380px;
    height:380px;
    background-image:url('${logoPath}');
    background-repeat:no-repeat;
    background-position:center;
    background-size:contain;
    opacity:0.05;
    transform:translate(-50%, -50%);
    z-index:0;
}

/* CONTENT ABOVE WATERMARK */

.header,
.section,
.footer{
    position:relative;
    z-index:2;
}

/* HEADER */

.header{
    text-align:center;
    margin-bottom:12px;
}

.school-name{
    font-size:22px;
    font-weight:bold;
    color:#0a1f44;
}

.school-address{
    font-size:12px;
    margin-top:2px;
}

.receipt-title{
    font-size:16px;
    font-weight:bold;
    margin-top:8px;
    color:#0a1f44;
}

.receipt-date{
    font-size:12px;
    margin-top:3px;
}

.divider{
    border-bottom:2px solid #0a1f44;
    margin-top:8px;
}

/* SECTIONS */

.section{
    border:1px solid #ccc;
    padding:10px;
    margin-bottom:10px;
    border-radius:5px;
    page-break-inside:avoid;
}

.section-title{
    font-weight:bold;
    font-size:14px;
    margin-bottom:6px;
    color:#0a1f44;
    border-bottom:1px solid #ddd;
    padding-bottom:3px;
}

.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px 16px;
}

.detail-group{
    margin-bottom:4px;
}

.detail-label{
    font-weight:bold;
}

.amount-total{color:#166534;font-weight:bold;}
.amount-paid{color:#065f46;font-weight:bold;}
.amount-balance{color:#b91c1c;font-weight:bold;}

.status-badge{
    display:inline-block;
    padding:3px 8px;
    border-radius:10px;
    font-size:11px;
    font-weight:bold;
    border:1px solid #999;
}

/* SIGNATURE */

.signature-section{
    margin-top:20px;
    display:flex;
    justify-content:space-between;
}

.signature-box{
    width:45%;
    text-align:center;
}

.signature-line{
    border-top:1px solid #000;
    margin-top:25px;
}

/* FOOTER */

.footer{
    margin-top:12px;
    font-size:11px;
    text-align:center;
    color:#444;
}

/* PRINT SETTINGS */

@media print{
    body{
        margin:10mm;
    }

    .section{
        page-break-inside:avoid;
    }
}

</style>
</head>

<body>

<div class="header">

<div class="school-name">
EDMOL MEMORIAL MATADI BAPTIST HIGH SCHOOL
</div>

<div class="school-address">
New Matadi Estate Drive, Opposite Don Bosco Youth Center
</div>

<div class="school-address">
P.O. Box: 4330 Monrovia, Liberia
</div>

<div class="school-address">
Email: emmmbhs@gmail.com
</div>

<div class="school-address">
0777-151-394 | 0771-761-098 | 0555-472-972
</div>

<div class="receipt-title">
OFFICIAL STUDENT FEE RECEIPT
</div>

<div class="receipt-date">
Date: ${new Date().toLocaleDateString()}
</div>

<div class="divider"></div>

</div>

${printableContent.innerHTML}

<div class="section">

<div class="section-title">Authorization</div>

<div class="signature-section">

<div class="signature-box">
<div class="signature-line"></div>
School Bursar / Accountant
</div>

<div class="signature-box">
<div class="signature-line"></div>
Authorized Signature
</div>

</div>

</div>

<div class="footer">

<div>
Printed on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}
</div>

<div>
This document is system-generated and valid without a stamp.
</div>

</div>

</body>
</html>
`);

    printWindow.document.close();

    printWindow.onload = function () {
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
        }, 300);
    };

}

</script>
@endsection