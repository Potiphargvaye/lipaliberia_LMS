@extends('public.layouts.public')

@section('title', 'About Us | Liberia Institute of Public Administration')

@section('description', 'Learn about the Liberia Institute of Public Administration (LIPA), our history, mission, vision, and commitment to building public sector capacity through professional training, research, and consultancy.')

@section('content')

    <!-- Everything that was INSIDE <main> from about.html goes here -->


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
                                    <h1 data-animation="bounceIn" data-delay="0.2s">About us</h1>
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item"><a href="#">about</a></li> 
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
        <div class="services-area services-area2 section-padding40">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="assets/img/icon/icon1.svg" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>1,500+ Professionals</h3>
                                <p>Public servants and professionals trained through quality capacity development programmes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="assets/img/icon/icon2.svg" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>37 Training Programmes</h3>
                                <p>Professional courses designed to strengthen leadership, governance, and public service.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="assets/img/icon/icon3.svg" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>2,250+ Graduates</h3>
                                <p>Graduates equipped with practical skills to improve public sector performance nationwide.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--? About Area-1 Start -->
        <section class="about-area1 fix pt-10">
            <div class="support-wrapper align-items-center">
                <div class="left-content1">
                    <div class="about-icon">
                        <img src="assets/img/icon/about.svg" alt="">
                    </div>
                    <!-- section tittle -->
                    <div class="section-tittle section-tittle2 mb-55">
                        <div class="front-text">
                            <h2 class="">About LIPA Since 1969</h2>
                            <p>Liberia Institute of Public Administration <b>(LIPA)</b> is Liberia's premier institution dedicated to training and developing public servants through quality education, professional development, research, and consultancy services.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Established in 1969, LIPA has remained committed to building public sector capacity and promoting national development.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <p>We deliver professional training programmes that strengthen leadership, management, governance, and public administration.</p>
                        </div>
                    </div>

                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Our research and consultancy services support government institutions in improving performance, accountability, and service delivery.</p>
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
                           <h2>Our Core Areas of Excellence</h2>
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
                                        <h3><a href="#">Public Sector Training</a></h3>
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
                                        <h3><a href="#">Public Administration</a></h3>
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
                                        <h3><a href="#">Procurement Management</a></h3>
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
                                        <h3><a href="#">Public Financial Management</a></h3>
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
                                        <h3><a href="#">HR & Performance Management</a></h3>
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
                                        <h3><a href="#">Policy Analysis & Strategic Planning</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="section-tittle text-center mt-20">
                            <a href="courses.html" class="border-btn">View All Programmes</a>
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
                            <h2 class="">Why Choose LIPA?</h2>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Receive practical training designed to strengthen leadership, governance, and public sector management skills.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                        </div>
                        <div class="features-caption">
                          <p>Learn from experienced facilitators and public administration professionals with extensive government expertise.</p>
                        </div>
                    </div>
                    <div class="single-features">
                        <div class="features-icon">
                            <img src="assets/img/icon/right-icon.svg" alt="">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img//team4.png') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <p>Build the knowledge and competencies needed to improve public service delivery and national development.</p>
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
                            <h2>What Our Participants Say</h2>
                          <p>Hear from professionals who have strengthened their leadership, management, and public service skills through LIPA's training programmes.</p>
                        </div>
                    </div>
                </div>
                <div class="team-active">
                    <div class="single-cat text-center"> 
                        <div class="cat-icon">
                           <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/user_avatar.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Sarah Johnson</a></h5>
                            <p>LIPA's training strengthened my procurement knowledge and improved my confidence in delivering quality public services.</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                           <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/user_avatar.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Michael Williams</a></h5>
                            <p>The practical learning experience helped me improve workplace performance and develop effective leadership skills.</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/user_avatar.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Grace Anderson</a></h5>
                            <p>The facilitators were knowledgeable, and the training provided practical solutions that I immediately applied at work.</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/user_avatar.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">David Cooper</a></h5>
                            <p>LIPA offers high-quality professional development that equips participants with practical tools for better decision-making.</p>
                        </div>
                    </div>
                    <div class="single-cat text-center">
                        <div class="cat-icon">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/gallery/user_avatar.jpg') }}" alt="">
                        </div>
                        <div class="cat-cap">
                            <h5><a href="services.html">Emily Roberts</a></h5>
                            <p>The programme enhanced my leadership abilities and prepared me to contribute more effectively to national development.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services End -->
    </main>








      @endsection