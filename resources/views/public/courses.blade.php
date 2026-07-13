@extends('public.layouts.public')

@section('title', 'About Us | Liberia Institute of Public Administration')

@section('description', 'Learn about the Liberia Institute of Public Administration (LIPA), our history, mission, vision, and commitment to building public sector capacity through professional training, research, and consultancy.')

@section('content')

    <!-- Everything that was INSIDE <main> from about.html goes here -->


      <!-- Header End -->
    <main>
        <!--? slider Area Start-->
        <section class="slider-area slider-area2">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-11 col-md-12">
                                <div class="hero__caption hero__caption2">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Our courses</h1>
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item"><a href="#">Services</a></li> 
                                        </ol>
                                    </nav>
                                    <!-- breadcrumb End -->
                                </div>
                            </div>
                        </div>
                    </div>          
                </div>
            </div>
        </section>
        <!-- Courses area start -->
        <div class="courses-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                          <h2>Certificate Level Courses</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                    <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image1.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                   <p>Public Procurement</p>
                                     <h3><a href="#">Public Procurement Management</a></h3>
                                      <p>Develop practical procurement planning, compliance, and contract management skills for effective public sector service delivery.</p>
                                    </p>
                                    <div class="properties__footer d-flex justify-content-between align-items-center">
                                        <div class="restaurant-name">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half"></i>
                                            </div>
                                          <p><span>(4.5)</span> Certificate Programme</p>
                                        </div>
                                        <div class="price">
                                            <span>$265 → 48 Hrs</span>
                                        </div>
                                    </div>
                                    <a href="#" class="border-btn border-btn2">Apply Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                   <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image2.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                     <p>Project Management</p>
                                <h3><a href="#">Project Planning & Management</a></h3>
                                <p>Strengthen project leadership, planning, monitoring, and implementation skills for complex public sector programmes.
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                       <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                       <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                               <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                    <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image3.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                    <p>Monitoring & Evaluation</p>
                                <h3><a href="#">Monitoring & Evaluation</a></h3>
                                <p>Develop practical monitoring and evaluation skills to measure programme performance and improve organizational results.
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                       <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                         <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                               <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                    <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image4.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                    <p>Public Finance</p>
                                <h3><a href="#">Public Financial Management</a></h3>
                                <p>Strengthen budgeting, accountability, and financial management skills for improved public sector performance and governance.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                        <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                               <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                     <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image5.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                    <p>Human Resources</p>
                                <h3><a href="#">HR & Performance Management</a></h3>
                                <p>Develop practical human resource management and performance improvement skills for public institutions.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                         <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image6.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                   <p>Internal Audit</p>
                                <h3><a href="#">Internal Audit & Control</a></h3>
                                <p>Build competencies in internal auditing, risk management, and effective organizational control systems.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                        <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                               <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                       <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image7.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                    <p>Administration</p>
                                <h3><a href="#">Administrative Management</a></h3>
                                <p>Strengthen office administration, organizational management, and professional workplace communication skills.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                        <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                               <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                      <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image8.jpg') }}" alt=""></a>
                                
                                </div>
                                <div class="properties__caption">
                                    <p>Strategic Planning</p>
                                <h3><a href="#">Public Sector Policy Analysis</a></h3>
                                <p>Develop policy analysis and strategic planning skills to support effective governance and national development.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                         <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                     <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image5.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                    <p>Human Resources</p>
                                <h3><a href="#">HR & Performance Management</a></h3>
                                <p>Develop practical human resource management and performance improvement skills for public institutions.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span> Certificate Programme</p>
                                    </div>
                                    <div class="price">
                                         <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
        <!-- Courses area End -->



        <!-- Courses area start -->
        <div class="courses-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Flagship Training Programmes</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                             <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image4.jpg') }}" alt=""></a>

                                </div>
                                <div class="properties__caption">
                                    <p>Leadership Development</p>
                                <h3><a href="#">Young Public Administrators Programme I</a></h3>
                                <p>Prepare future public servants through leadership, governance, and career development training programmes..</p>
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span>Flagship Training</p>
                                    </div>
                                    <div class="price">
                                         <span>$150 → 6 Weeks</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                     <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image5.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                   <p>Leadership Development</p>
                                <h3><a href="#">Young Public Administrators Programme II</a></h3>
                                <p>Advance career readiness through practical leadership, public administration, and professional development training.
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                       <p><span>(4.5)</span> Flagship Training</p>
                                    </div>
                                    <div class="price">
                                       <span>$200 → 6 Weeks</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image11.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                     <p>Women Leadership</p>
                                <h3><a href="#">Women in Public Sector Leadership</a></h3>
                                <p>Empower women leaders through strategic leadership, governance, and management skills development programmes.
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                       <p><span>(4.5)</span>Flagship Training</p>
                                    </div>
                                    <div class="price">
                                         <span>$250 → 50 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image12.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                     <p>Professional Development</p>
                                <h3><a href="#">Service Officers Empowerment Training</a></h3>
                                <p>Support retiring service officers with practical skills for leadership, entrepreneurship, and lifelong development.

                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div> 
                                        <p><span>(4.5)</span>Flagship Training</p>  
                                    </div>
                                    <div class="price">
                                        <span>$265 → 60 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Courses area End -->




        
        <!-- Courses area start -->
        <div class="courses-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                             <h2>Public Sector Orientation Programmes</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                               <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image13.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                    <p>Public Service Orientation</p>
                                <h3><a href="#">Project Planning & Management  Intermediate</a></h3> 
                                <p>Build a strong foundation in public service values, ethics, and professional responsibilities for government institutions.</p>
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <p><span>(4.5)</span>Orientation Programme</p>
                                    </div>
                                    <div class="price">
                                         <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                               <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image13.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                  <p>Civil Service Development</p>
                                 <h3><a href="#">Project Planning & Management  Intermediate</a></h3> 
                                <p>Strengthen administrative knowledge, workplace professionalism, and effective service delivery across public institutions.
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                       <p><span>(4.5)</span> Flagship Training</p>
                                    </div>
                                    <div class="price">
                                       <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                 <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image5.jpg') }}" alt=""></a>
                                </div>
                                <div class="properties__caption">
                                     <p>Leadership & Governance</p>
                                <h3><a href="#">Project Planning & Management  Intermediate</a></h3> 
                                <p>Develop leadership, teamwork, and governance skills that support accountability and institutional excellence.
                                </p>
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div class="restaurant-name">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                       <p><span>(4.5)</span>Orientation Programme</p>
                                    </div>
                                    <div class="price">
                                         <span>$265 → 48 Hrs</span>
                                    </div>
                                </div>
                                <a href="#" class="border-btn border-btn2">Apply Now</a>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Courses area End -->

        <!-- ? services-area -->
        <div class="services-area services-area2 section-padding40">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="assets/img/icon/icon1.svg" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>60+ UX courses</h3>
                                <p>The automated process all your website tasks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="assets/img/icon/icon2.svg" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>Expert instructors</h3>
                                <p>The automated process all your website tasks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="assets/img/icon/icon3.svg" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>Life time access</h3>
                                <p>The automated process all your website tasks.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

      @endsection



