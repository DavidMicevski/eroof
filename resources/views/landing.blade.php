<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="theme-color" content="#fafafa">
        <title>Roof Ruler</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ asset("/bower_components/AdminLTE/dist/img/icon.png") }}" type="image/x-icon"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css")}}" rel="stylesheet" type="text/css" />
        <!-- <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" /> -->
        <!-- <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" /> -->
        <link href="{{ asset('css/app-template.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/leaflet.css') }}" rel="stylesheet">
        <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
        <link href="{{ asset('css/leaflet.draw.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    </head>
    <body>
        <header class="site-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <a href="#"><img src="{{ asset("/bower_components/AdminLTE/dist/img/logo-main.png") }}" class="sitelogo"></a>
                    </div>

                    <div class="col-md-9">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#products">Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#pricing">Pricing</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#contactus">Contact Us</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="button-quote">
                                <a href="#contactus" class="btn btn-primary">GET STARTED</a>
                                <a href="/login" class="btn btn-primary">Login</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <section class="main-site-banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">  
                        <h2>GET HIGHEST RESOULATION IMAGERY</h2>
                        <p>We are a software company that was built from the ground up to provide solutions to problems we have seen
                        in the roofing industry. We are driven to provide high quality applications for roofers and insurance
                        adjusters. </p>
                        <a class="btn btn-primary" href="#contactus">GET STARTED</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="our-products" id="products">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mt-5 mb-3">
                        <h2>OUR PRODUCTS</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="product-item">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/product-1.jpg") }}">
                            <h3>Desktop & Mobile</h3>
                            <p>Roof Ruler is the best roofing application available for your computer or mobile device. Create accurate
                              aerial roof measurements, estimates, material orders, contracts, and more. Roof Ruler's mobile app for
                              Android and iOS is a great tool for insurance adjusters and roofers to use in the field. Roof Ruler can
                              also be accessed from your desktop or laptop browser and is optimized for use on the big screen. From
                              simple to complex roofs, you can easily measure and estimate with Roof Ruler in less time than it takes to
                              receive a report from another source. </p>
                            <a href="#contactus" class="btn">GET STARTED</a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="product-item">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/product-2.jpg") }}">
                            <h3>Sketch Order Service</h3>
                             <p> Not a fan of drawing the roof yourself? You can order roof measurements from Roof Ruler and our SketchOS
                              technicians will create the measurement diagram for you. Within hours, the completed project is uploaded
                              into your Roof Ruler account. The sketch is a dynamic, fully editable drawing that you can customize with
                              inspection photos and notes and use to create an estimate in Roof Ruler. Then, have your customers sign
                              the contract right on your device. Check out our pricing page to see the value.
                            </p>
                            <a href="#contactus" class="btn">GET STARTED</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pricing py-5 mt-5" id="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h2>OUR PRICING</h2>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Monthly</h5>
                                <h6 class="card-price text-center">$99<span class="period">/month per User</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span><strong>Per User</strong></li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Unlimited Projects</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>$99/month per user<br><small>(Additional usersat $99 each)</small></li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span> 5 HD Images/month<br>
                                    <small>For DIY Projects</small></li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Exclusive SketchOS Pricing</li>
                                </ul>
                                <a href="#" class="btn btn-block btn-primary text-uppercase">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Starter</h5>
                                <h6 class="card-price text-center">$1776<span class="period">/Year</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span><strong>Up to 2 Users</strong></li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Unlimited Projects</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>$74/month per user</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span> 480 HD Images/year<br>
                                        <small>For DIY Projects</small> 
                                    </li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Exclusive SketchOS Pricing</li>
                                </ul>
                                <a href="#" class="btn btn-block btn-primary text-uppercase">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mb-5">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Pro</h5>
                                <h6 class="card-price text-center">$3,480<span class="period">/Year</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span><strong>Up to 5 Users</strong></li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Unlimited Projects</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>$58/month per user</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span> 1,200 HD Images/year<br>
                                    <small>For DIY Projects</small> </li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Exclusive SketchOS Pricing</li>
                                </ul>
                                <a href="#" class="btn btn-block btn-primary text-uppercase">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Pro</h5>
                                <h6 class="card-price text-center">$5,880<span class="period">/Year</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span><strong>Up to 10 Users</strong></li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Unlimited Projects</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>$49/month per user</li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span> 2,400 HD Images/year<br>
                                    <small>For DIY Projects</small> </li>
                                    <li><span class="fa-li"><i class="fa fa-check"></i></span>Exclusive SketchOS Pricing</li>
                                </ul>
                                <a href="#" class="btn btn-block btn-primary text-uppercase">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="explore mt-5 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>EXPLORE ALL YOU CAN DO WITH ROOF RULER</h2>
                    </div>

                    <div class="col-md-3">
                        <div class="explore-item">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/icon-1.png") }}">
                            <h4>Measure roofs instantly</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="explore-item">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/icon-2.png") }}">
                            <h4>Automate BOMs, costs, and profit</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="explore-item">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/icon-3.png") }}">
                            <h4>Send quotes and get signatures.</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="explore-item">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/icon-4.png") }}">
                            <h4>Track jobs on-the-go. Get roof reports</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="quote-form" id="contactus">
            <div class="container contact-form">
                <div class="contact-image">
                    <img src="{{ asset("/bower_components/AdminLTE/dist/img/rocket_contact.png") }}" alt="rocket_contact" />
                </div>
                <form method="post">
                    <h3>Roof Ruler has everything to run your business with ease.</h3>
                    <p>Let’s talk about getting you started with Roof Ruler.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <input type="text" name="txtName" class="form-control" placeholder="Your Name *" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="txtEmail" class="form-control" placeholder="Your Email *" value="" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="txtPhone" class="form-control" placeholder="Your Phone Number *" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="txtPhone" class="form-control" placeholder="Your Subject" value="" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="txtMsg" class="form-control" placeholder="Your Message *" style="width: 100%; height: 150px;"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btnContact" value="Send Message" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <footer class="page-footer font-small unique-color-dark">
            <div class="strip-footer">
                <div class="container">
                    <div class="row py-4 d-flex align-items-center">
                        <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                            <h6 class="mb-0">Get connected with us on social networks!</h6>
                        </div>
                        <div class="col-md-6 col-lg-7 text-center text-md-right">
                            <a class="fb-ic" href="#"><i class="fa fa-facebook-f white-text mr-4"> </i></a>
                            <a class="fb-ic" href="#"><i class="fa fa-twitter white-text mr-4"> </i></a>
                            <a class="fb-ic" href="#"><i class="fa fa-instagram white-text"> </i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container text-center text-md-left mt-5">
                <div class="row mt-3">
                    <div class="col-md-6 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase font-weight-bold">About Roof Ruler</h6>
                        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p>Roof Ruler is a software and a service. Use the app to measure and estimate from anywhere or request measurements from our Sketch Ordering Service.</p>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p> <a href="index.html">Home</a> </p>
                        <p> <a href="#products">Products</a> </p>
                        <p> <a href="#pricing">Pricing</a> </p>
                        <p> <a href="#contactus">Get Started</a> </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase font-weight-bold">Contact</h6>
                        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <p> <i class="fa fa-home mr-3"></i> New York, NY 10012, US</p> 
                        <p> <i class="fa fa-envelope mr-3"></i> info@roofruler.com</p>
                        <p> <i class="fa fa-phone mr-3"></i> + 01 234 567 88</p>
                        <p> <i class="fa fa-print mr-3"></i> + 01 234 567 89</p>
                    </div>
                </div>
            </div>
            <div class="footer-copyright text-center py-3"><a href="#"> Roof Ruler</a> © 2020 Copyright. All Rights Reserved.
            </div>
        </footer>
    </body>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
</html>
