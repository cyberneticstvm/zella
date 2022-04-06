<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zella Boutique.">
    <meta name="keyword" content="Zella Boutique">
    <title>:: ZELLA ::</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="public/css/al.style.min.css">
    <!-- project layout css file -->
    <link rel="stylesheet" href="public/css/layout.a.min.css">
</head>

<body>

<div id="layout-a" class="theme-blue">

    <!-- main body area -->
    <div class="main auth-div6">
        
        <!-- Body: Body -->
        <div class="body">
            <div class="login-form custom_scroll">
                <!-- Form -->
                <form class="row g-3" action="{{ route('user.login') }}" method="post">
                    @csrf
                    <div class="col-12 text-center mb-4">
                        <h1>Welcome to <span class="text-gradient fw-bold">ZELLA</span></h1>
                        <span>Way to access our CRM.</span>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" placeholder="Username" name="username">
                        @error('username')
                        <small class="text-danger">{{ $errors->first('username') }}</small>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="form-label">
                            <span class="d-flex justify-content-between align-items-center">
                                Password
                            </span>
                        </div>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="***************">
                        @error('password')
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                        @enderror
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-login px-4 btn-dark lift text-uppercase">SIGN IN</button>
                    </div>
                    @if (count($errors) > 0)
                    <div role="alert" class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                    @endif
                </form>
                <!-- End Form -->
            </div>
            <div class="login-text d-none d-md-flex">
                <div>
                    <h2 class="bg-text fw-bold">Make a Dream.</h2>
                    <p class="lead">Build a beautiful, modern website with flexible Bootstrap components built from scratch.</p>
                    <button type="submit" class="btn btn-lg bg-secondary text-uppercase lift">View more</button>
                    <div class="mt-5 pt-3">
                        <a href="#" class="me-2 text-light"><i class="fa fa-facebook-square fa-lg"></i></a>
                        <a href="#" class="me-2 text-light"><i class="fa fa-github-square fa-lg"></i></a>
                        <a href="#" class="me-2 text-light"><i class="fa fa-linkedin-square fa-lg"></i></a>
                        <a href="#" class="me-2 text-light"><i class="fa fa-twitter-square fa-lg"></i></a>
                    </div>
                </div>
                <svg class="svg-1" version="1.1" viewBox="0 0 146.6 134.7">
                    <circle class="st0" cx="7.3" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="45" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="129.6" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="45" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="111.8" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="94" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="94" r="2.9"/>
                    <circle class="st0" cx="45" cy="94" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="94" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="94" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="94" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="94" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="94" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="45" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="76.3" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="45" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="58.5" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="45" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="40.7" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="45" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="22.9" r="2.9"/>
                    <circle class="st0" cx="7.3" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="26.2" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="45" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="63.9" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="82.7" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="101.6" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="120.5" cy="5.1" r="2.9"/>
                    <circle class="st0" cx="139.3" cy="5.1" r="2.9"/>
                </svg>
                <svg class="svg-2" version="1.1" viewBox="0 0 58 58">
                    <path d="M29,57.1c-0.1,0-0.1,0-0.2-0.1L1,29.2c-0.1-0.1-0.1-0.3,0-0.4L28.8,1c0.1-0.1,0.3-0.1,0.4,0    L57,28.8c0.1,0.1,0.1,0.3,0,0.4L29.2,57C29.1,57.1,29.1,57.1,29,57.1z M1.6,29L29,56.4L56.4,29L29,1.6L1.6,29z"/>
                    <path d="M29,47.7c-0.1,0-0.1,0-0.2-0.1L10.4,29.2c-0.1-0.1-0.1-0.3,0-0.4l18.4-18.4    c0.1-0.1,0.3-0.1,0.4,0l18.4,18.4c0.1,0.1,0.1,0.3,0,0.4L29.2,47.6C29.1,47.6,29.1,47.7,29,47.7z M11,29l18,18l18-18L29,11L11,29z"/>
                    <path d="M29,38.3c-0.1,0-0.1,0-0.2-0.1l-9-9c-0.1-0.1-0.1-0.3,0-0.4l9-9c0.1-0.1,0.3-0.1,0.4,0l9,9    c0.1,0.1,0.1,0.1,0.1,0.2s0,0.1-0.1,0.2l-9,9C29.1,38.2,29.1,38.3,29,38.3z M20.4,29l8.6,8.6l8.6-8.6L29,20.4L20.4,29z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Modal: Setting -->
    <div class="modal fade" id="SettingsModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">AL-UI Setting</h5>
                    </div>
                    <div class="modal-body custom_scroll">
                    <!-- Settings: Font -->
                    <div class="setting-font">
                        <small class="card-title text-muted">Google font Settings</small>
                        <ul class="list-group font_setting mb-3 mt-1">
                            <li class="list-group-item py-1 px-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="font" id="font-opensans" value="font-opensans" checked="">
                                    <label class="form-check-label" for="font-opensans">
                                        Open Sans Google Font
                                    </label>
                                </div>
                            </li>
                            <li class="list-group-item py-1 px-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="font" id="font-quicksand" value="font-quicksand">
                                    <label class="form-check-label" for="font-quicksand">
                                        Quicksand Google Font
                                    </label>
                                </div>
                            </li>
                            <li class="list-group-item py-1 px-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="font" id="font-nunito" value="font-nunito">
                                    <label class="form-check-label" for="font-nunito">
                                        Nunito Google Font
                                    </label>
                                </div>
                            </li>
                            <li class="list-group-item py-1 px-2">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="font" id="font-Raleway" value="font-raleway">
                                    <label class="form-check-label" for="font-Raleway">
                                        Raleway Google Font
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Settings: Color -->
                    <div class="setting-theme">
                        <small class="card-title text-muted">Theme Color Settings</small>
                        <ul class="list-unstyled d-flex justify-content-between choose-skin mb-2 mt-1">
                            <li data-theme="indigo"><div class="indigo"></div></li>
                            <li data-theme="blue" class="active"><div class="blue"></div></li>
                            <li data-theme="cyan"><div class="cyan"></div></li>
                            <li data-theme="green"><div class="green"></div></li>
                            <li data-theme="orange"><div class="orange"></div></li>
                            <li data-theme="blush"><div class="blush"></div></li>
                            <li data-theme="red"><div class="red"></div></li>
                            <li data-theme="dynamic"><div class="dynamic"><i class="fa fa-paint-brush"></i></div></li>
                        </ul>
                    </div>
                    <!-- Settings: Theme dynamics -->
                    <div class="dt-setting">
                        <small class="card-title text-muted">Dynamic Color Settings</small>
                        <ul class="list-group list-unstyled mb-3 mt-1">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                <label>Primary Color</label>
                                <button id="primaryColorPicker" class="btn bg-primary avatar xs border-0 rounded-0"></button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                <label>Secondary Color</label>
                                <button id="secondaryColorPicker" class="btn bg-secondary avatar xs border-0 rounded-0"></button>
                            </li>
                        </ul>
                    </div>
                    <!-- Settings: Light/dark -->
                    <div class="setting-mode">
                        <small class="card-title text-muted">Light/Dark & Contrast Layout</small>
                        <ul class="list-group list-unstyled mb-0 mt-1">
                            <li class="list-group-item d-flex align-items-center py-1 px-2">
                                <div class="form-check form-switch theme-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="theme-switch">
                                    <label class="form-check-label" for="theme-switch">Enable Dark Mode!</label>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center py-1 px-2">
                                <div class="form-check form-switch theme-high-contrast mb-0">
                                    <input class="form-check-input" type="checkbox" id="theme-high-contrast">
                                    <label class="form-check-label" for="theme-high-contrast">Enable High Contrast</label>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center py-1 px-2">
                                <div class="form-check form-switch theme-rtl mb-0">
                                    <input class="form-check-input" type="checkbox" id="theme-rtl">
                                    <label class="form-check-label" for="theme-rtl">Enable RTL Mode!</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start text-center">
                    <button type="button" class="btn flex-fill btn-primary lift">Save Changes</button>
                    <button type="button" class="btn flex-fill btn-white border lift" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <a class="page-setting" href="#" title="Settings" data-bs-toggle="modal" data-bs-target="#SettingsModal"><i class="fa fa-gear"></i></a>

</div>

<!-- Jquery Core Js -->
<script src="public/bundles/libscripts.bundle.js"></script>

<script>
    $(function(){
        "use strict";
        $('form').submit(function(){
            $(".btn-login").attr("disabled", true);
            $(".btn-login").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>&nbsp;Loading...");
        });
    })
</script>
<!-- Jquery Page Js -->

</body>
</html>