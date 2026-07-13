@extends('public.layouts.public')

@section('title', 'Liberia Institute of Public Administration')

@section('description', 'Liberia Institute of Public Administration')

@section('content')

    <!-- Everything that was INSIDE <main> from index.html goes here -->
         <main>
        <!--? slider Area Start-->
       <!--? slider Area Start-->
<section class="slider-area" style="position: relative;"> <div class="slider-active">

            <div class="single-slider slider-height d-flex align-items-center hero-slide-1">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-12">
                            <div class="hero__caption">
                                <h1 data-animation="fadeInLeft" data-delay="0.2s">Building Capacity for National Development</h1>
                                <p data-animation="fadeInLeft" data-delay="0.4s">Empowering Liberia's public sector through quality training, leadership development, and professional programmes that strengthen institutions and improve public service delivery.</p>
                                <a href="#" class="btn hero-btn">Explore Programmes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="single-slider slider-height d-flex align-items-center hero-slide-2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-12">
                            <div class="hero__caption">
                                <h1 data-animation="fadeInLeft" data-delay="0.2s">Developing Public<br>Sector Leaders</h1>
                                <p data-animation="fadeInLeft" data-delay="0.4s">Enhancing leadership, management, and administrative excellence through innovative training programmes designed for government institutions and public servants.</p>
                                <a href="#" class="btn hero-btn" data-animation="fadeInLeft" data-delay="0.7s">View Training</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="single-slider slider-height d-flex align-items-center hero-slide-3">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-12">
                            <div class="hero__caption">
                                <h1 data-animation="fadeInLeft" data-delay="0.2s">Strengthening Public Service Excellence</h1>
                                <p data-animation="fadeInLeft" data-delay="0.4s">Providing education, research, and consultancy services that build institutional capacity and support sustainable national development across Liberia.</p>
                                <a href="#" class="btn hero-btn" data-animation="fadeInLeft" data-delay="0.7s">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <div class="custom-slider-dots">
            <span class="custom-dot active" data-slide="0"></span>
            <span class="custom-dot" data-slide="1"></span>
            <span class="custom-dot" data-slide="2"></span>
        </div>

    </section>
        <!-- ? services-area -->
        <div class="services-area">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                               
                                 <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/icon1.svg') }}" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>1,500+ Happy Clients</h3>
                                <p>Serving public institutions and professionals through quality training and capacity development programmes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                               <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/icon2.svg') }}" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>37 Training Programmes</h3>
                                <p>Professional courses focused on leadership, governance, and effective public sector management.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/icon3.svg') }}" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>2,250+ Graduates</h3>
                                <p>Successful graduates contributing to stronger institutions and improved public service delivery.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Certificate Level Courses Section -->
        <div class="courses-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Certificate Level Courses</h2>
                        </div>
                    </div>
                </div>
                <div class="courses-actives">
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->


                    <!-- Single 6 -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Find out more</a>
                            </div>

                        </div>
                    </div>
<!-- single slide 6 -->



<!-- Single 7 -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Find out more</a>
                            </div>

                        </div>
                    </div>
<!-- single slide 7-->

<!-- Single 8 -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Find out more</a>
                            </div>

                        </div>
                    </div>
<!-- single slide 8 -->


<!-- Single 9 -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
<!-- single slide 8-->

                </div>
            </div>
        </div>
        <!-- Certificate Level Courses Section  area End -->



        <!-- Flagship Training Programs Section -->
        
            <div class="courses-area section-padding40 flagship-programs fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Flagship Training Programmes</h2>
                        </div>
                    </div>
                </div>
                <div class="courses-actives">
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                </div>
            </div>
        </div>
        <!--  Flagship Training Programs Section-->

        <!-- Public Sector Orientation Programs Section -->
        
            <div class="courses-area section-padding40 flagship-programs fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Public Sector Orientation Programmes</h2>
                        </div>
                    </div>
                </div>
                <div class="courses-actives">
                    <!-- Single -->
                    <div class="properties pb-20">
                        <div class="properties__card">
                            <div class="properties__img overlay1">
                               <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image13.jpg') }}" alt=""></a>
                            </div>
                            <div class="properties__caption">
                                <p>Public Service Orientation</p>
                                <h3><a href="#">Public Sector Orientation Programme I</a></h3>
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">
                        <div class="properties__card">
                            <div class="properties__img overlay1">
                               <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image13.jpg') }}" alt=""></a>
                            </div>
                            <div class="properties__caption">
                                <p>Civil Service Development</p>
                                <h3><a href="#">Public Sector Orientation Programme II</a></h3>
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Single -->
                    <!-- Single -->
                    <div class="properties pb-20">  
                        <div class="properties__card">
                            <div class="properties__img overlay1">
                            <a href="#"><img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/image5.jpg') }}" alt=""></a>
                            </div>
                            <div class="properties__caption">
                                <p>Leadership & Governance</p>
                                <h3><a href="#">Public Sector Orientation Programme III</a></h3>
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
                                <a href="#" class="border-btn border-btn2">Learn More</a>
                            </div>

                        </div>
                    </div>
                    <!-- Single -->
                </div>
            </div>
        </div>
        <!-- Public Sector Orientation Programs Section area End -->

        <!--? About Area-1 Start -->
        <section class="about-area1 fix pt-10">
            <div class="support-wrapper align-items-center">
                <div class="left-content1">
                    <div class="about-icon">
                       
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/about.svg') }}" alt="">
                    </div>
                    <!-- section tittle -->
                    <div class="section-tittle section-tittle2 mb-55">
                        <div class="front-text">
                            <h2 class="">Building Public Sector Capacity for National Development</h2>
                            <p>Liberia Institute of Public Administration (LIPA) is committed to developing competent public servants through quality training, research, consultancy, and leadership development programmes.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/right-icon.svg') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Delivering professional training programmes that strengthen leadership, governance, and public administration.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/right-icon.svg') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Providing research and consultancy services that support institutional performance and national development.</p>
                        </div>
                    </div>

                    <div class="single-features">
                        <div class="features-icon">
                           <img src="{{ asset('lipa-liberia-public-site/assets/img/icon/right-icon.svg') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Preparing public servants with practical knowledge and skills to deliver efficient, transparent, and accountable public services..</p>
                        </div>
                    </div>
                </div>
                 <div class="right-content1">
    <div class="right-img">
        <iframe
            width="100%"
            height="500"
           src="https://www.youtube.com/embed/cHiDEkoZ_r0?autoplay=1&mute=1&loop=1&playlist=cHiDEkoZ_r0&rel=0"
            title="Liberia Institute of Public Administration"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>

    </div>
</div>
            </div>
        </section>
        <!-- About Area End -->
        <!--? top subjects Area Start -->
        <div class="topic-area section-padding40">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Explore Our Gallary</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                               <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">LIPA Campus</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                               
                                <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Graduation Ceremony</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Leadership Development</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                 <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Professional Seminars</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                  <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Research & Consultancy</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Public Service Training</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                 <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Certificate Awards</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                 <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo2 (1).png') }}" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3><a href="#">Programing</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="section-tittle text-center mt-20">
                            <a href="courses.html" class="border-btn">View More Subjects</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- top subjects End -->
        <!--? About Area-3 Start -->
        <section class="about-area3 fix">
            <div class="support-wrapper align-items-center">
                <div class="right-content3">
                    <!-- img -->
                    <div class="right-img">
                       <img src="{{ asset('lipa-liberia-public-site/assets/img/hero/lipa_building2.png') }}" alt="">
                    </div>
                </div>
                <div class="left-content3">
                    <!-- section tittle -->
                    <div class="section-tittle section-tittle2 mb-20">
                        <div class="front-text">
                            <h2 class="">Why Choose LIPA for Professional Development</h2>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Gain practical knowledge and professional skills that strengthen performance across Liberia's public sector institutions.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                          <p>Learn from experienced facilitators with expertise in public administration, leadership, and governance.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img//team4.png') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Receive nationally recognized training that supports career growth, institutional excellence, and public service delivery.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->
        <!--? Team -->
        <section class="team-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Meet Our Facilitators</h2>
                        </div>
                    </div>
                </div>
                <div class="team-active">
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo1.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">George C. Nyanti</a></h5>
                            <p>Training Director
Master of Public Sector Management (MPSM).</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                             <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo1.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Tom Nimely Fannoh</a></h5>
                            <p>Training Coordinator
Master of Public Sector Management (MPSM)</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                             <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo1.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Richard G. Greenfield</a></h5>
                            <p>Training Specialist
MSc Development Finance & Public Sector Management.</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                          <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo1.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">William T. Buxton</a></h5>
                            <p>Information Technology Officer
Bachelor of Science (BSc).</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                           <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/lipa_logo1.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Amed D. Dunor</a></h5>
                            <p>The automated process all your website tasks.</p>
                        </div>
                    </div>
                </div>

                <!-- ADD THIS HERE -->
<div class="row justify-content-center mt-30">
    <div class="col-xl-12 text-center">
        <a href="{{ url('/facilitators') }}" class="border-btn">
            View All Facilitators
        </a>
    </div>
</div>
            </div>
        </section>
        <!-- Services End -->
        <!--? About Area-2 Start -->
        <section class="about-area2 fix pb-padding">
            <div class="support-wrapper align-items-center">
                <div class="right-content2">
                    <!-- img -->
                    <div class="right-img">
                        
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/hero/student_image.png') }}" alt="">
                    </div>
                </div>
                <div class="left-content2">
                    <!-- section tittle -->
                    <div class="section-tittle section-tittle2 mb-20">
                        <div class="front-text">
                            <h2 class=""> Take the next step
toward advancing your
public service career
with LIPA.</h2>
                            <p>Advance your knowledge through professional training programmes designed to strengthen leadership, management, and public sector performance in Liberia.</p>
                            <a href="#" class="btn">Apply Now!</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Our Partners -->
<section class="partner-area section-padding40">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="section-tittle text-center mb-55">
                    <h2>Our Partners</h2>
                    <p>
                        We proudly collaborate with government institutions, development
                        partners, and organizations committed to strengthening public sector
                        capacity and national development in Liberia.
                    </p>
                </div>
            </div>
        </div> 

        <div class="row align-items-center justify-content-center">
 
            <div class="col-lg-3 col-md-3 col-6 mb-4 text-center">
                <img src="{{ asset('lipa-liberia-public-site/assets/img/partners/partner.jpg') }}" alt="Partner 1">
            </div>

            <div class="col-lg-3 col-md-3 col-6 mb-4 text-center">
                <img src="{{ asset('lipa-liberia-public-site/assets/img/partners/partner2.png') }}" alt="Partner 2">
            </div>

            <div class="col-lg-3 col-md-3 col-6 mb-4 text-center">
                <img src="{{ asset('lipa-liberia-public-site/assets/img/partners/partner3.jpg') }}" alt="Partner 3">
            </div>

            <div class="col-lg-3 col-md-3 col-6 mb-4 text-center">
                <img src="{{ asset('lipa-liberia-public-site/assets/img/partners/government.jpg') }}" alt="Partner 4">
            </div>

        </div>

    </div>
</section>
        <!-- About Area End -->
    </main>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 1. Target your active slider instance
    var $slider = $('.slider-active');

    // 2. Click Handler: Force slick to navigate to the targeted slide index
    $(document).on('click', '.custom-dot', function(e) {
        e.preventDefault();
        var slideIndex = $(this).data('slide');
        
        // Directly invoke Slick's method to go to the specific slide index
        $slider.slick('slickGoTo', parseInt(slideIndex));
    });

    // 3. Real-time Synced Event Handler
    $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('.custom-dot').removeClass('active');
        $('.custom-dot[data-slide="' + nextSlide + '"]').addClass('active');
    });
});
</script>
@endsection