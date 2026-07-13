<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Senior-report edmol</title>
    <style>
   body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 17px;
    margin: 20px;
}

/* HEADER */
.school-header {
    text-align: center;
}

.school-header h2 {
    margin: 0;
    font-weight: bold;
}

.school-header p {
    margin: 2px 0;
}

.school-header a {
    color: blue;
    text-decoration: underline;
}

h3.report-title {
    text-align: center;
    color: navy;
    font-weight: bold;
    margin: 10px 0;
}

.student-info {
    margin: 15px 0;
    font-weight: bold;
}

/* ================= TABLE (MAIN FIX) ================= */

/* Default = compact (fixes spacing issue) */
table {
    width: auto;                 /* 🔥 prevents stretching */
    margin: 0 auto;              /* center table */
    border-collapse: collapse;
    
    table-layout: fixed;
}

/* Full width only for large tables */
.full-width-table {
    width: 100%;
}

/* Borders */
table, th, td {
    border: 2px solid black;
}

/* Cell spacing */
th, td {
    padding: 6px 8px;
    text-align: center;
}

/* First column (Subject) */
table tr th:first-child,
table tr td:first-child {
    min-width: 120px;
    max-width: 110px;
    white-space: normal;
    word-wrap: break-word;
    text-align: left;
    padding-left: 10px;
}
  
/* Other columns (grades) */
table tr th:not(:first-child), 
table tr td:not(:first-child) {
    min-width: 45px;
    white-space: nowrap;
    font-size: 17px;
}

/* Period view (few columns) */
.period-view th:first-child,
.period-view td:first-child {
    width: 70%;
}

.period-view th:last-child,
.period-view td:last-child {
    width: 30%;
}

/* ================= COLORS =================, */

.red-grade {
    color: rgb(236, 3, 3);
    font-weight: bold;
}

.blue-grade {
    color: #0267fd;
    font-weight: bold;
}

/* ================= BUTTON ================= */

.print-button {
    margin-bottom: 20px;
    padding: 8px 16px;
    background-color: #002966;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.print-button:hover {
    background-color: #063dac;
}

/* ================= SIGNATURE ================= */

.signature {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
}

.signature div {
    text-align: center;
    width: 200px;
}


/* ================= PRINT ================= */

@media print {

    body {
        margin: 0;
        font-size: 18px;
        color: #000;
         -webkit-print-color-adjust: exact;
        
    }

     /* 🔥 Prevent auto shrink */
    html, body {
        zoom: 1; 
    }

    .print-button {
        display: none;
    }

    /* 🔥 CRITICAL FIX FOR PRINT */
    table {
        width: auto !important;   /* prevents stretching */
        margin: 0 auto;
        font-size: 20px;
    }

    th, td {
        padding: 4px;
        text-align: center;
        white-space: nowrap;
        font-size: 17px;  /* NEW NEW */
    }

     

    /* Allow subject wrapping */
    th:first-child,
    td:first-child {
        white-space: normal;
        width: 35%;
        text-align: left;
    }

    /* Prevent row breaking */
    tr {
        page-break-inside: avoid;
    }

    .school-header {
        margin-bottom: 5px;
    }

    .school-header h2 {
        font-size: 18px;
    }

    .student-info {
        margin: 8px 0;
    }

    .signature {
        margin-top: 25px;
    }

    .signature div {
        page-break-inside: avoid;
    }
}

/* HEADER LAYOUT  for logo and image*/
.school-header {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 10px;
}

/* HEADER CONTAINER (FIXED HEIGHT ISSUE) */
.school-header {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;

    min-height: 110px; /* 🔥 IMPORTANT: controls space for images */
}

/* LEFT LOGO */
.header-left {
    position: absolute;
    left: 0;

    top: 50%; /* 🔥 vertical center */
    transform: translateY(-50%);
}

/* RIGHT IMAGE (STUDENT PHOTO) */
.header-right {
    position: absolute;
    right: 0;

    top: 50%; /* 🔥 vertical center */
    transform: translateY(-50%);
}

/* CENTER TEXT */
.header-center {
    text-align: center;
    width: 100%;
}

/* LOGO + STUDENT IMAGE STYLE */
.school-logo {
    width: 80px;
    height: 80px;
    object-fit: cover;
    object-position: center; /* 🔥 FIX 1: centers image properly */
    border-radius: 45%;
    border: 2px solid #0e0e14;
    display: block; /* 🔥 FIX 2: prevents inline distortion */
}
/* REPORT TITLE BOX */
.report-title-box {
    text-align: center;
    
    border: 5px solid #0c0c0c; /* 🔥 CHANGE COLOR HERE */
    /* Example:
       border: 3px solid red;   #990000
       border: 3px solid #002966;
       border: 3px solid green;
    */

    padding: 6px;
    font-weight: bold;
    font-size: 15px;
    width: 70%;
    margin: 10px auto;
}

/* MOBILE */
@media (max-width: 768px) {

    .school-logo {
        width: 50px;
        height: 50px;
    }

    .report-title-box {
        width: 90%;
        font-size: 14px;
    }
}

@media print {

    .school-header {
        min-height: 80px; /* 🔥 MUST match image size */
    }

    .header-left,
    .header-right {
        top: 45%;
        transform: translateY(-45%);
    }

    .school-logo {
        width: 75px;   /* 🔥 adjust print size */
        height: 75px;

        object-fit: cover;
        object-position: center;

        border-radius: 45%;
        display: block;
         border: 2px solid #0e0e14;

        overflow: hidden; /* 🔥 prevents cut-off */
    }


    .report-title-box {
      
        border: 5px solid #0c0c0c; 
    }

    .school-header h2 {
        font-size: 15px;
    }
}

/* 🔥 School header colorl here */
.school-header h2 {
    margin: 0;
    font-weight: bold;
    color: navy; /* 🔥 CHANGE COLOR HERE */
    
}

/* FOOTER LEGAL NOTE */
.footer-note {
    text-align: center;
    font-size: 16px;
    margin-top: 15px;

    font-style: italic;
    color: #242323;

    border-top: 1px solid #999;
    padding-top: 6px;

    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.footer-note {
    font-size: 16px;
    color: #000;

    border-top: 1px solid #000;
    font-weight: 500;
    letter-spacing: 0.3px;
}

    </style>
</head>
<body>


<!-- Print button -->
<button class="print-button" onclick="window.print()">🖨 Print Report Card</button>

<!-- School header -->
<!-- School header -->
@php
if(!isset($grades)){
    $grades = \App\Models\StudentGrade::where('student_id', $student->id)->get();
    // Default report period if not provided
    $period = $period ?? 'yearly';
}
@endphp

@if(request()->query('showHeader', 1)) {{-- default to 1 if missing --}}
<div class="school-header">

    <!-- LEFT: SCHOOL LOGO -->
    <div class="header-left">
        <img src="{{ asset('kiddos-school-master/images/School_logo_reciept.jpeg') }}" 
             alt="School Logo" 
             class="school-logo">
    </div>  

    <!-- CENTER: SCHOOL TEXT -->
    <div class="header-center">
        <h2>ED MOL MEMORIAL MATADI BAPTIST HIGH SCHOOL</h2>
        <p>New Matadi Estate Drive, Opposite Don Bosco Youth Center</p>
        <p>P.O. Box: 4330 - Monrovia, Liberia</p>
        <p>
            <a href="mailto:emmmbhs@gmail.com">emmmbhs@gmail.com</a> 
            - +231555472972 / +231776597201
        </p>
    </div>
   <!-- RIGHT: STUDENT IMAGE -->
<div class="header-right">
    <img 
        src="{{ $student->image 
                ? asset('storage/'.$student->image) 
                : asset('kiddos-school-master/images/user-default-avatar.jpg') }}"   avatardefault_92824
        
        alt="Student Photo"     
        class="school-logo"
        
        onerror="this.onerror=null;this.src='{{ asset('kiddos-school-master/images/user-default-avatar.jpg') }}';"  
    >
</div>
</div>

<!-- REPORT TITLE -->
<div class="report-title-box">
    SENIOR HIGH GRADE SHEET
</div>


<!-- Student information -->
<div class="student-info">
    <span>STUDENT'S NAME: {{ $student->name }}</span>
    <span style="float: right;">GRADE: {{ $student->class_applying_for }}</span>
</div>

<div class="student-info">
     <span style="float: right;">ID: {{ $student->student_id }}</span>
    <span>ACADEMIC YEAR: {{ $grades->first()->academic_year ?? 'N/A' }}</span>
    
</div>
@endif

<!-- Report card table -->
<table class="{{ in_array($period,['p1','p2','p3','p4','p5','p6']) ? 'period-view' : '' }}">
    <thead>
        <tr>
            <th>Subject</th>
            <!-- Display columns dynamically based on selected period -->
            @if(in_array($period, ['p1','semester1','yearly']))<th>1st Period</th>@endif
            @if(in_array($period, ['p2','semester1','yearly']))<th>2nd Period</th>@endif
            @if(in_array($period, ['p3','semester1','yearly']))<th>3rd Period</th>@endif
            @if(in_array($period, ['semester1','yearly']))<th>1st Sem. Exam</th><th>1st Sem. Average</th>@endif
            @if(in_array($period, ['p4','semester2','yearly']))<th>4th Period</th>@endif
            @if(in_array($period, ['p5','semester2','yearly']))<th>5th Period</th>@endif
            @if(in_array($period, ['p6','semester2','yearly']))<th>6th Period</th>@endif
            @if(in_array($period, ['semester2','yearly']))<th>2nd Sem. Exam</th><th>2nd Sem. Average</th>@endif
            @if($period === 'yearly')<th>Yearly Average</th>@endif
        </tr>
    </thead>
    <tbody>
        @php
            // Initialize totals and subject count
            $firstSemTotal = 0;
            $secondSemTotal = 0;
            $subjectCount = $grades->count();

            // Grade color logic: red if score <= 69
            // Grade color logic: red if score <= 69
$color = function ($val) {
    if ($val === null || $val === '') {
        return 'blue-grade';
    }

    return $val <= 69 ? 'red-grade' : 'blue-grade';
};

// Display value
$display = function ($val) {
    return ($val === null || $val === '') ? 'NG' : $val;
};
        @endphp

        @foreach($grades as $grade)
            @php
                // Calculate semester and yearly averages
                $periodAvg1 = ($grade->period1 + $grade->period2 + $grade->period3) / 3;
                $firstSemAvg = round(($periodAvg1 + $grade->exam1) / 2);

                $periodAvg2 = ($grade->period4 + $grade->period5 + $grade->period6) / 3;
                $secondSemAvg = round(($periodAvg2 + $grade->exam2) / 2);

                $yearAvg = round(($firstSemAvg + $secondSemAvg) / 2, 2);

                // ---------------- PERIOD AVERAGE CALCULATION ----------------

// If the report is P1 → add Period1 score
if($period === 'p1') {
    $firstSemTotal += $grade->period1; // P1 average = sum(period1 scores) / subject count
}

// If the report is P2 → add Period2 score
elseif($period === 'p2') {
    $firstSemTotal += $grade->period2; // P2 average = sum(period2 scores) / subject count
}

// If the report is P3 → add Period3 score
elseif($period === 'p3') {
    $firstSemTotal += $grade->period3; // P3 average = sum(period3 scores) / subject count
}

// Semester 1 → use calculated semester average
elseif($period === 'semester1') {
    $firstSemTotal += $firstSemAvg; // Semester1 average = ((P1+P2+P3)/3 + Exam1)/2
}

// If the report is P4
elseif($period === 'p4') {
    $firstSemTotal += $grade->period4;
}

// If the report is P5
elseif($period === 'p5') {
    $firstSemTotal += $grade->period5;
}

// If the report is P6
elseif($period === 'p6') {
    $firstSemTotal += $grade->period6;
}

// Semester 2
elseif($period === 'semester2') {
    $firstSemTotal += $secondSemAvg; // Semester2 average = ((P4+P5+P6)/3 + Exam2)/2
}

// Yearly report
elseif($period === 'yearly') {
    $firstSemTotal += $yearAvg; // Yearly average = (Semester1 + Semester2) / 2
}
            @endphp

            <tr>
                <td>{{ $grade->subject->name }}</td>

                <!-- Dynamic period columns -->
                @if(in_array($period, ['p1','semester1','yearly']))<td class="{{ $color($grade->period1) }}"> <strong>{{ $display($grade->period1) }}</strong></td>@endif
                @if(in_array($period, ['p2','semester1','yearly']))<td class="{{ $color($grade->period2) }}"><strong>{{ $display($grade->period2) }}</strong></td>@endif
                @if(in_array($period, ['p3','semester1','yearly']))<td class="{{ $color($grade->period3) }}"><strong>{{ $display($grade->period3) }}</strong></td>@endif
                @if(in_array($period, ['semester1','yearly']))
                    <td class="{{ $color($grade->exam1) }}"><strong>{{ $display($grade->exam1) }}</strong></td>
                    <td class="{{ $color($firstSemAvg) }}"><strong>{{ $firstSemAvg }}</strong></td>
                @endif
                @if(in_array($period, ['p4','semester2','yearly']))<td class="{{ $color($grade->period4) }}"><strong>{{ $display($grade->period4) }}</strong></td>@endif
                @if(in_array($period, ['p5','semester2','yearly']))<td class="{{ $color($grade->period5) }}"><strong>{{ $display($grade->period5) }}</strong></td>@endif
                @if(in_array($period, ['p6','semester2','yearly']))<td class="{{ $color($grade->period6) }}"><strong>{{ $display($grade->period6) }}</strong></td>@endif
                @if(in_array($period, ['semester2','yearly']))
                    <td class="{{ $color($grade->exam2) }}"><strong>{{ $display($grade->exam2) }}</strong></td>
                    <td class="{{ $color($secondSemAvg) }}"><strong>{{ $secondSemAvg }}</strong></td>
                @endif
                @if($period === 'yearly')<td class="{{ $color($yearAvg) }}"><strong>{{ $yearAvg }}</strong></td>@endif
            </tr>
        @endforeach

      @php
    // 1. Calculate the values you want to show
    $firstSemTotal = $firstSemTotal ?? 0;
    $subjectCount = $subjectCount ?? 1; // Division by zero check
    $overallAverage = round($firstSemTotal / $subjectCount, 2);

    // 2. Calculate how many columns are actually displayed in the current view
    $totalCols = 1; // The "Subject" column

    if (in_array($period, ['p1', 'p2', 'p3', 'p4', 'p5', 'p6'])) {
        $totalCols += 1; 
    } elseif (in_array($period, ['semester1', 'semester2'])) {
        $totalCols += 5; // 3 periods + 1 exam + 1 average
    } elseif ($period === 'yearly') {
        $totalCols += 11; // All columns
    }
@endphp
<tr style="background:#f3f4f6; font-weight: bold;">
    <td>Average</td>

    @if(in_array($period, ['p1','semester1','yearly']))
        <td class="{{ $color($periodAverages['p1'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['p1'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['p2','semester1','yearly']))
       <td class="{{ $color($periodAverages['p2'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['p2'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['p3','semester1','yearly']))
        <td class="{{ $color($periodAverages['p3'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['p3'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['semester1','yearly']))
        {{-- ✅ FIXED: exam1 average --}}
       <td class="{{ $color($periodAverages['exam1'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['exam1'][$student->id] ?? 0,2) }}</strong>
</td>

        <td class="{{ $color($periodAverages['semester1'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['semester1'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['p4','semester2','yearly']))
        <td class="{{ $color($periodAverages['p4'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['p4'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['p5','semester2','yearly']))
      <td class="{{ $color($periodAverages['p5'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['p5'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['p6','semester2','yearly']))
      <td class="{{ $color($periodAverages['p6'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['p6'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if(in_array($period, ['semester2','yearly']))
        {{-- ✅ FIXED: exam2 average --}} 
        <td class="{{ $color($periodAverages['exam2'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['exam2'][$student->id] ?? 0,2) }}</strong>
</td>

       <td class="{{ $color($periodAverages['semester2'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['semester2'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif

    @if($period === 'yearly')
       <td class="{{ $color($periodAverages['yearly'][$student->id] ?? null) }}">
    <strong>{{ round($periodAverages['yearly'][$student->id] ?? 0,2) }}</strong>
</td>
    @endif
</tr>
 

<tr style="background:#f3f4f6; font-weight: bold;">
    <td>Rank</td>

    @if(in_array($period, ['p1','semester1','yearly']))
        <td>{{ $periodRanks['p1'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['p2','semester1','yearly']))
        <td>{{ $periodRanks['p2'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['p3','semester1','yearly']))
        <td>{{ $periodRanks['p3'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['semester1','yearly']))
        {{-- ✅ FIXED: exam1 rank --}}
        <td>{{ $periodRanks['exam1'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>

        <td>{{ $periodRanks['semester1'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['p4','semester2','yearly']))
        <td>{{ $periodRanks['p4'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['p5','semester2','yearly']))
        <td>{{ $periodRanks['p5'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['p6','semester2','yearly']))
        <td>{{ $periodRanks['p6'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if(in_array($period, ['semester2','yearly']))
        {{-- ✅ FIXED: exam2 rank --}}
        <td>{{ $periodRanks['exam2'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>

        <td>{{ $periodRanks['semester2'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif

    @if($period === 'yearly')
        <td>{{ $periodRanks['yearly'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
    @endif
</tr>

<tr style="background:#f3f4f6; font-weight: bold;">
    <td>Conduct</td>
    @for($i = 0; $i < ($totalCols - 2); $i++)
        <td></td>
    @endfor
    <td style="text-align: center;">{{ $conduct ?? '-' }}</td>
</tr>

{{-- Repeat same logic for Rank and Conduct --}}

    </tbody>
</table>


<!-- Signature / Footer -->
@if(request()->query('showFooter', 1))

<div class="signature">
    <div>
        Signed: ______________________<br>
        Class Sponsor
    </div>

    <div>
        Approved: ______________________<br>
        Principal
    </div>
</div>

<!-- 🔒 LEGAL NOTICE -->
<div class="footer-note">
    Any alteration of this document renders it invalid. <br>
    Invalid without school stamp.
</div>
@endif

</body>
</html>