<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
          integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    <!-- Custom fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title>Sofra</title>
</head>

<body>

<!--==============navbar section=======-->
<div class="container-fluid">
    <div class="row">
        <nav class="navbar navbar-light" style="background-color: #ECECEC;">
            <div class="col-md-4 col-sm-12">
                <a href="client/cart">
                    <i class="fas fa-shopping-cart"> </i>
                </a>
                <div class="dropdown">
                    <i class="fas fa-user-circle dropbtn "></i>
                    <div class="dropdown-content">
                        @if(auth()->guard('restaurant-web')->check())
                            <a href="resturant/my-products"> الحساب الشخصي</a>
                            <a href="resturant/update-account">تعديل الحساب الشخصي</a>
                            <a href="{{url('resturant/logout')}}">تسجيل الخروج</a>
                        @elseif(auth()->guard('client-web')->check())
                            <a href="client/update-account/{{auth()->guard('client-web')->user()->id}}">تعديل الحساب الشخصي</a>
                            <a href="client/logout">تسجيل الخروج</a>
                            @elseif(auth()->guard('restaurant-web')->check())

                        <a href="resturant/login">تسجيل الدخول</a>
                            <a href="resturant/register">تسجيل حساب جديد</a>
                                      @else
                                <a href="client/login">تسجيل الدخول</a>
                                <a href="{{url('client/register')}}">تسجيل حساب جديد</a>

                        @endif
{{--                        <a href="logout">تسجيل الخروج</a>--}}
                        <a href="#">Link 3</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 logo-up">
                <img class="logo" src="{{asset('front/images/sofra%20logo-1@2x.png')}}">
            </div>
            <div class="col-md-4 col-sm-12 burger">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01"
                        aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-hamburger"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse " id="navbarsExample01">
                <ul class="navbar-nav custom">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us">تواصل معنا</a>
                        <a class="nav-link" href="#">Link</a>
                        <a class="nav-link" href="#">Link</a>

                    </li>
                </ul>

            </div>
        </nav>
    </div>
</div>



{{-- Start Content--}}
@yield('content')
{{-- End content--}}

<!-- Start Footer Section
<footer>
    <div class="container">
        <div class="footer-desc">
            <div class="who-us">
                <i class="fa fa-pencil"></i>
                <h3>من نحن</h3>
            </div>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.<br> Nam enim voluptatibus ullam deleniti
                culpa accusamus <br> fugit doloremque blanditiis provident pariatur, maiores harum error<br> porro
                nihil quidem eligendi magnam sunt aut?</p>
            <ul class="list-unstyled links">
                <li>
                    <a href="#" class="fa fa-facebook-square"></a>
                </li>
                <li>
                    <a href="#" class="fa fa-twitter"></a>
                </li>
                <li>
                    <a href="#" class="fa fa-instagram"></a>
                </li>
            </ul>
        </div>
        <a href="index.html" class="footer-logo">
            <img src="images/sofra logo-1.png" alt="Footer-logo">
        </a>
    </div>
</footer>
<End Footer Section -->

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-desc">
                    <div class="who-us">
                        <i class="fa fa-pencil"></i>
                        <h3>من نحن</h3>
                    </div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit.<br> Nam enim voluptatibus ullam
                        deleniti culpa accusamus <br> fugit doloremque blanditiis provident pariatur, maiores harum
                        error<br> porro nihil quidem eligendi magnam sunt aut?</p>
                    <ul class="list-unstyled links">
                        <li>
                            <a href="#" class="fa fa-facebook-square"></a>
                        </li>
                        <li>
                            <a href="#" class="fa fa-twitter"></a>
                        </li>
                        <li>
                            <a href="#" class="fa fa-instagram"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <a href="index.html" class="footer-logo">
                    <img src="{{asset('front/images/sofra logo-1.png')}}" alt="Footer-logo">
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

@stack('scripts')
</body>

</html>
