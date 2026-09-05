LIPA LMS – Course Structure & Management Reference
Project

Liberia Institute of Public Administration (LIPA)
Learning Management System (LMS)

1. Purpose of This Document

This document serves as a technical and functional reference for the completed course structure of the LIPA Learning Management System.

The following modules have been implemented:

Course Category Management
Course Management
Module Management

These three modules form the foundation for how courses and their learning structure are organized within the LIPA LMS.

The next module to be implemented is:

Learning Materials Management

2. Overall Course Structure

The LIPA LMS follows the following structure:

Course Category
│
▼
Course
│
▼
Modules
│
▼
Learning Materials

Example:

Public Administration
│
▼
Public Procurement Management
│
├── Module 1: Introduction to Public Procurement
│
├── Module 2: Procurement Planning
│
├── Module 3: Procurement Procedures
│
└── Module 4: Contract Management
│
▼
Learning Materials
├── Video
├── PDF
├── PowerPoint
├── Text Content
└── External Link

This structure allows the LMS to grow without requiring major changes to the core course architecture.

3. Course Category Management
   Purpose

Course Categories are used to organize related courses into logical groups.

Examples may include:

Information Technology
Business
Leadership
Public Administration
Digital Skills
Database Table
course_categories
Main Fields
Field Purpose
id Unique category ID
name Category name
slug URL-friendly unique identifier
image Optional category image
is_active Controls whether the category is active
created_by User who created the category
timestamps Created and updated timestamps
Category Functions

The Course Category Management module allows authorized users to:

Create a category
Edit a category
Archive or deactivate a category
Upload or manage a category image
Track which user created the category
Permissions

The module uses the permission:

manage course categories

The route is protected using route-level middleware.

Example:

Route::middleware(['auth', 'can:manage course categories'])->group(function () {
// Course category routes
}); 4. Course Management
Purpose

Course Management handles all courses offered through the LIPA LMS.

Each course belongs to a Course Category.

Database Table
courses
Important Course Fields
Field Purpose
id Unique course ID
title Course title
slug Unique course identifier
course_category_id Linked course category
group Course group
group_label Display label
programme_type Programme type
overview Course overview
target_audience Intended learners
entry_requirements Entry requirements
duration Course duration
schedule Course schedule
fee Course fee
seats Available seats
image Course image
is_active Active/inactive status 5. Course and Category Relationship

A Course belongs to one Course Category.

The relationship is:

Course Category
│
└──── Has Many Courses

Example:

Course Category:
Public Administration

Courses:

- Public Procurement Management
- Public Financial Management
- Leadership and Governance
  Database Relationship

The courses table contains:

course_category_id

The Course model relationship is:

public function category(): BelongsTo
{
return $this->belongsTo(
CourseCategory::class,
'course_category_id'
);
}

The Course Category model should have a relationship allowing it to access its courses.

Conceptually:

public function courses(): HasMany
{
return $this->hasMany(
Course::class,
'course_category_id'
);
} 6. Course Management Permissions

Course Management uses the permission:

manage courses

Authorized users can:

Create courses
Edit courses
Manage course information
Activate or deactivate courses
Assign a Course Category
Search courses
Delete courses when allowed 7. Course Deletion Protection

Courses cannot be deleted when they already have important related records.

The current Course model checks for:

Applications
Enrollments

The method is:

public function canBeDeleted(): bool
{
return ! $this->applications()->exists()
&& ! $this->enrollments()->exists();
}

This protects important student and application data from being accidentally removed.

As the LMS continues to grow, this logic may also need to consider:

Modules
Learning materials
Assessments
Student progress
Certificates

before allowing a course to be deleted.

8. Module Management
   Purpose

Module Management is used to organize the learning structure inside each Course.

LIPA confirmed that course content is organized using:

Module 1
Module 2
Module 3
Module 4

rather than using a general Lesson 1, Lesson 2 structure.

Therefore, the LMS internally uses the Module Management structure.

9. Module Structure

Each Course can contain multiple Modules.

Example:

Course:
Public Procurement Management

Modules:

Module 1
Introduction to Public Procurement

Module 2
Procurement Planning

Module 3
Procurement Methods

Module 4
Contract Management 10. Modules Database Table
modules

The table contains:

Field Purpose
id Unique module ID
course_id Course the module belongs to
title Module title
module_order Module position within the course
is_active Active/inactive status
created_by User who created the module
timestamps Created and updated timestamps 11. Course and Module Relationship

A Course can have many Modules.

The structure is:

Course
│
├── Module 1
│
├── Module 2
│
├── Module 3
│
└── Module 4

The Course model contains a relationship conceptually structured as:

public function modules(): HasMany
{
return $this->hasMany(Module::class);
}

Each Module belongs to a Course.

Conceptually:

public function course(): BelongsTo
{
return $this->belongsTo(Course::class);
} 12. Module Numbering System

The Module Number is not manually included in the Module Title.

Instead, the system stores two separate values.

Example:

title:
Introduction to Public Procurement

module_order:
1

The system then displays:

Module 1: Introduction to Public Procurement

Another example:

title:
Procurement Planning

module_order:
2

The UI displays:

Module 2: Procurement Planning
Why This Approach Is Used

Keeping the title separate from the module order provides flexibility.

The database stores:

module_order = 1
title = Introduction to Public Procurement

instead of:

title = Module 1: Introduction to Public Procurement

This prevents the module number from being duplicated inside the title and allows the system to control the numbering dynamically.

13. Module Ordering Rules

Module order is unique within each Course.

For example:

Public Procurement Management
Module Order 1
Module Order 2
Module Order 3
Digital Skills

The numbering can start again:

Module Order 1
Module Order 2
Module Order 3

Therefore, the following combination must be unique:

course_id + module_order

The database enforces this rule using:

$table->unique(['course_id', 'module_order']);

This prevents two modules within the same course from having the same order number.

14. Module Deletion Behavior

The Module Management system currently allows a gap in numbering when a module is deleted.

Example:

Before deletion:

Module 1
Module 2
Module 3
Module 4

If Module 2 is deleted:

Module 1
Module 3
Module 4

The system does not automatically renumber the remaining modules.

This was the selected implementation approach.

Future enhancements can introduce automatic reordering if required.

15. Module Permission

Module Management uses the permission:

manage modules

The module is protected at the route level.

Authorized users can:

View modules
Create modules
Edit modules
Delete modules
Select the Course a module belongs to
Set module order
Activate or deactivate modules
Search modules
Filter modules by Course 16. Module Creation Logic

When creating a Module, the administrator selects:

Course

The course dropdown dynamically loads existing active courses.

Module Title

Example:

Introduction to Public Procurement
Module Order

Example:

1
Status
Active
Inactive
Created By

The system automatically records the authenticated user who created the module.

17. Course Deletion and Modules

The current modules table uses:

cascadeOnDelete()

for the course_id relationship.

This means that if a Course is deleted, its related Modules are automatically deleted.

Conceptually:

Course Deleted
│
▼
Related Modules Deleted

This prevents orphaned Module records.

However, future development should review Course deletion rules once Learning Materials, Assessments, Student Progress, and other course data are connected.

A possible future approach may be to prevent deletion of a Course when it contains:

Modules
Learning Materials
Student enrollments
Assignments
Quizzes
Student progress records 18. Completed LMS Course Structure

The current completed structure is:

COURSE CATEGORY MANAGEMENT
│
▼
COURSE MANAGEMENT
│
▼
MODULE MANAGEMENT
│
▼
LEARNING MATERIALS
│
▼
STUDENT LEARNING EXPERIENCE

Currently completed:

Module 5
Course Category Management
Module 6
Course Management
Module 7
Module Management 19. Next Module: Learning Materials

The next development phase is:

Learning Materials Management

Learning Materials will be connected to individual Modules.

The expected structure will be:

Course
│
▼
Module
│
├── Video
│
├── PDF
│
├── PowerPoint
│
├── Text Content
│
├── Word Document
│
├── Downloadable Resource
│
└── External Link

Example:

Course:
Public Procurement Management

Module 1:
Introduction to Public Procurement

Learning Materials:

1. Introduction Video
2. Module Presentation
3. PDF Reading Material
4. Additional Resource
5. Recommended Database Relationship for the Next Phase

The planned relationship should follow:

CourseCategory
│
└── Courses
│
└── Modules
│
└── Learning Materials

Conceptually:

Course Category
↓
Course
↓
Module
↓
Learning Material

This provides a clear, scalable hierarchy for the LIPA LMS.

21. Important Naming Convention

Although the original LMS requirements referred to Lesson Management, LIPA confirmed that their actual course structure uses:

Module 1
Module 2
Module 3

Therefore, the implemented system uses:

Module Management

The sidebar may display:

LESSON MANAGEMENT

Course Categories
Courses
Lesson Modules
Learning Materials

However, technically and within the database, the content structure is based on:

Course → Module → Learning Material 22. Current Development Status
Module Status
Course Category Management ✅ Completed
Course Management ✅ Completed
Module Management ✅ Completed
Learning Materials Management ⏳ Next
Student Course Learning Interface Future
Progress Tracking Future
Assignments Future
Quizzes & Assessments Future
Certificates Future 23. Core Architecture Reference

The core LIPA LMS learning architecture should be preserved as:

┌─────────────────────────────┐
│ COURSE CATEGORY │
│ │
│ Public Administration │
│ Information Technology │
│ Business │
└──────────────┬──────────────┘
│
▼
┌─────────────────────────────┐
│ COURSE │
│ │
│ Public Procurement │
│ Management │
└──────────────┬──────────────┘
│
▼
┌─────────────────────────────┐
│ MODULE │
│ │
│ Module 1 │
│ Module 2 │
│ Module 3 │
└──────────────┬──────────────┘
│
▼
┌─────────────────────────────┐
│ LEARNING MATERIALS │
│ │
│ Video │
│ PDF │
│ PowerPoint │
│ Text Content │
│ External Link │
│ Downloadable Resources │
└─────────────────────────────┘
Final Reference

The completed architecture establishes a clear foundation:

Category → Course → Module → Learning Material

This should remain the central content structure as the LIPA LMS continues into the Learning Materials module and later into the student learning experience, progress tracking, assignments, quizzes, and certificates.






LIPA LMS
LEARNING MATERIALS MANAGEMENT
Module 8 – Implementation & Reference Guide

This guide defines the recommended implementation of the Learning Materials module, building directly on the completed Course Category Management, Course Management, and Lesson Module Management features.

1. Purpose

Manage and organize all learning resources attached to a specific course module. Materials may include videos, PDFs, PowerPoint presentations, Word documents, text content, external links, and downloadable resources.

2. Core Structure

The hierarchy should remain: Course → Module → Learning Materials. A learning material belongs to one module, and the module belongs to one course.

3. Supported Material Types

Video; PDF Document; PowerPoint Presentation; Word Document; Text Content; External Link; Downloadable Resource / ZIP File.

4. Admin Management

Authorized staff can add, edit, preview, download where applicable, replace uploaded files, activate or deactivate materials, delete materials, search, and filter by course, module, material type, and status.

5. Student Access

Students should only see active materials that belong to modules available to them through their enrolled course. The student learning interface should present materials in the order configured by staff.

6. Recommended Learning Materials Table

#

Title

Course

Module

Type

File / Link

Order

Status

Uploaded By

Actions

1

Introduction Video

Public Procurement

Module 1: Introduction

Video

intro.mp4

1

Active

Admin User

Preview / Edit / Delete

7. Add / Edit Learning Material Form

Course * – dropdown of active courses

Module * – dynamically filtered by the selected course

Material Type * – selects the type of learning material

Title *

File Upload or External URL, depending on material type

Description – optional

Material Order – controls display order within the module

Status – Active / Inactive

8. Database Recommendation

Column

Purpose

Example

id

Primary key

1

module_id

Links material to a module

1

title

Material title

Introduction Video

type

Material type

video / pdf / powerpoint / word / text / link / resource

file_path

Stored file path

learning-materials/intro.mp4

external_url

External URL when applicable

https://example.com

content

Text content when applicable

Lesson notes...

description

Optional material description

Introduction resource

material_order

Display order within module

1

is_active

Controls availability

true

created_by

User who created the material

1

timestamps

Created and updated timestamps

created_at / updated_at

9. Recommended Workflow

1. Staff selects a Course.

2. System loads the modules belonging to that Course.

3. Staff selects the target Module.

4. Staff selects the Material Type.

5. Staff uploads a file, enters text content, or provides an external link.

6. Staff sets the display order and status.

7. The material is saved and becomes available to eligible students when active.

10. Implementation Notes

Use the existing LIPA admin layout, sidebar, modal styling, table styling, notifications, pagination, and permission patterns.

Recommended permission: manage learning materials.

Route protection should follow the existing route-level middleware approach used by Course Categories and Modules.

Course selection should show active courses only when creating or editing a material.

Module options should depend on the selected course to prevent incorrect relationships.

Material order should be unique within a module if ordering is implemented manually.

Preview behavior should depend on type: video player for videos, browser/PDF preview for PDFs where supported, text view for text content, and open/download behavior for other resources.

11. Visual Reference

The visual concept below is a design reference only. The implementation should remain compatible with the existing LIPA LMS Blade layout and styling.



Prepared as a future reference for the LIPA LMS development workflow.