<?php
session_start();

// If the user is not logged in, redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Assuming your JSON data is in 'data.json'
$jsonFilePath = 'data.json';
$uniqueCategories = [];

if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $data = json_decode($jsonContent, true);

    if ($data !== null && isset($data['result']['payload']['product_stock_details'])) {
        foreach ($data['result']['payload']['product_stock_details'] as $product) {
            $category = $product['product_category'];
            if (!in_array($category, $uniqueCategories)) {
                $uniqueCategories[] = $category;
            }
        }
    }
}

require_once __DIR__ . '/lib/category_helper.php';
$grouped_menu = get_grouped_menu($uniqueCategories, is_admin_view());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:type" content="website">
    <meta property="og:image" content="./assets/images/common/og-image.jpg">

    <link rel="stylesheet" href="./assets/vendors/liquid-icon/lqd-essentials/lqd-essentials.min.css">
    <link rel="stylesheet" href="./assets/css/theme.min.css">
    <link rel="stylesheet" href="./assets/css/utility.min.css">
    <link rel="stylesheet" href="./assets/css/demo/asymmetric-agency/base.css">
    <link rel="stylesheet" href="./assets/css/demo/asymmetric-agency/asymmetric-agency-expertise.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <title>Saudi Motosport - Product Catalogue </title>
    <style>
        .nav-trigger.style-2 .bar:after,
        .nav-trigger.style-2 .bar:before {
            background: #fff !important;
        }

        /* Accordion Menu Styles */
        .category-accordion {
            padding: 0;
        }

        .category-accordion .cat-group {
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .category-accordion .cat-group:last-child {
            border-bottom: none;
        }

        .category-accordion summary {
            list-style: none;
            cursor: pointer;
            padding: 9px 4px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: color 0.2s ease, padding-left 0.2s ease;
            user-select: none;
        }

        .category-accordion summary::-webkit-details-marker { display: none; }

        .category-accordion summary:hover {
            color: var(--primary, #d4af37);
            padding-left: 8px;
        }

        .category-accordion details[open] > summary {
            color: var(--primary, #d4af37);
            border-left: 3px solid var(--primary, #d4af37);
            padding-left: 8px;
            margin-left: -11px;
        }

        .category-accordion .cat-parent-icon {
            display: inline-flex;
            align-items: center;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .category-accordion .cat-parent-icon i {
            width: 16px;
            height: 16px;
        }

        .category-accordion .cat-parent-label {
            flex: 1;
        }

        .category-accordion .cat-parent-count {
            font-size: 10.5px;
            font-weight: 600;
            color: rgba(0, 0, 0, 0.4);
            letter-spacing: 0;
            background: rgba(0, 0, 0, 0.04);
            padding: 1px 7px;
            border-radius: 10px;
            min-width: 24px;
            text-align: center;
        }

        .category-accordion .cat-parent-count:empty {
            display: none;
        }

        .category-accordion details[open] > summary .cat-parent-count {
            background: var(--primary, #d4af37);
            color: white;
        }

        .category-accordion .cat-parent-arrow {
            display: inline-flex;
            align-items: center;
            transition: transform 0.25s ease;
            color: rgba(0, 0, 0, 0.3);
        }

        .category-accordion .cat-parent-arrow i {
            width: 16px;
            height: 16px;
        }

        .category-accordion details[open] > summary .cat-parent-arrow {
            transform: rotate(90deg);
            color: var(--primary, #d4af37);
        }

        /* Children — animated reveal */
        .category-accordion .cat-children {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease-out;
            padding-left: 28px;
        }

        .category-accordion details[open] > .cat-children {
            max-height: 1000px;
            padding-top: 2px;
            padding-bottom: 8px;
        }

        .category-accordion .cat-children li {
            margin-bottom: 2px;
        }

        .category-accordion .category-link,
        .category-accordion .cat-children a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 4px 8px;
            font-size: 12.5px;
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
            color: rgba(0, 0, 0, 0.7);
            border-radius: 4px;
            transition: background 0.15s ease, color 0.15s ease, padding-left 0.15s ease;
            text-decoration: none;
        }

        .category-accordion .category-link:hover,
        .category-accordion .cat-children a:hover {
            color: var(--primary, #d4af37);
            background: rgba(0, 0, 0, 0.025);
            padding-left: 12px;
        }

        .category-accordion .category-link.active {
            color: var(--primary, #d4af37);
            background: rgba(212, 175, 55, 0.08);
            font-weight: 600;
        }

        .category-accordion .cat-child-count {
            font-size: 10px;
            font-weight: 500;
            color: rgba(0, 0, 0, 0.35);
            background: rgba(0, 0, 0, 0.04);
            padding: 1px 6px;
            border-radius: 10px;
            min-width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        .category-accordion .cat-child-count:empty {
            display: none;
        }

        .category-accordion .category-link.active .cat-child-count {
            background: var(--primary, #d4af37);
            color: white;
        }

        /* Pure CSS Background Slider - Updated for 10 images */
        .bg-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1);
            animation: slideAnimation 40s infinite;
            /* 10 slides * 4s each */
        }

        /* Delays for each of the 10 images */
        .bg-slide:nth-child(1) { animation-delay: 0s; }
        .bg-slide:nth-child(2) { animation-delay: 4s; }
        .bg-slide:nth-child(3) { animation-delay: 8s; }
        .bg-slide:nth-child(4) { animation-delay: 12s; }
        .bg-slide:nth-child(5) { animation-delay: 16s; }
        .bg-slide:nth-child(6) { animation-delay: 20s; }
        .bg-slide:nth-child(7) { animation-delay: 24s; }
        .bg-slide:nth-child(8) { animation-delay: 28s; }
        .bg-slide:nth-child(9) { animation-delay: 32s; }
        .bg-slide:nth-child(10) { animation-delay: 36s; }

        @keyframes slideAnimation {
            0% { opacity: 0; transform: scale(1); }
            2% { opacity: 1; }
            8% { opacity: 1; }
            10% { opacity: 0; transform: scale(1.05); }
            100% { opacity: 0; }
        }

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>



</head>

<body
    style="background-color: #032824; background-image: url(https://saudimotorsport.com/static/pattern-bg-138686d69440bf998f880b4ef82ec35f.svg);"
    class="lqd-cc-outer-hidden" data-lqd-cc="true" data-mobile-nav-breakpoint="1199" data-mobile-nav-style="modern"
    data-mobile-nav-scheme="dark" data-mobile-nav-trigger-alignment="right" data-mobile-header-scheme="gray"
    data-mobile-logo-alignment="default" data-overlay-onmobile="false">

    <div id="loading-overlay">
        <div class="loader"></div>
    </div>

    <div id="loading-overlay"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 9999; display: none; justify-content: center; align-items: center;">
        <div class="loader"
            style="border: 16px solid #f3f3f3; border-top: 16px solid #3498db; border-radius: 50%; width: 120px; height: 120px; animation: spin 2s linear infinite;">
        </div>
    </div>

    <div id="loading-overlay">
        <div class="loader"></div>
    </div>

    <div id="wrap">

        <div class="lqd-sticky-placeholder hidden"></div>
        <header style="background:white;"
            class="site-header main-header sticky-header-noshadow main-header-dynamiccolors" data-sticky-header="true"
            data-sticky-values-measured="false"
            data-sticky-options='{"disableOnMobile":true,"stickyTrigger":"first-section","dynamicColors":true}'>
            <div class="lqd-head-sec-wrap lqd-hide-onstuck relative pr-35 pl-20 md:hidden">
                <div class="w-full flex items-center justify-between">
                    <div class="col-auto lqd-head-col flex-grow-1 justify-start">
                        <div class="header-module module-primary-nav static">
                            <div class="navbar-collapse lqd-submenu-default-style inline-flex flex-col items-stretch h-full"
                                aria-expanded="false" role="navigation">
                                <ul class="main-nav lqd-menu-counter-right main-nav-hover-default flex reset-ul flex-nowrap items-stretch justify-end link-16 link-medium link-black"
                                    data-submenu-options='{"toggleType": "fade", "handler": "mouse-in-out"}'
                                    data-localscroll="true"
                                    data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto lqd-head-col flex-grow-1 justify-center">
                        <div class="header-module module-logo no-rotate navbar-brand-plain pt-25 pb-25">
                            <a class="navbar-brand" href="index.php" rel="home">
                                <span class="navbar-brand-inner">
                                    <img class="logo-light"
                                        src="https://images.ctfassets.net/5deddylq7ay4/6fDc8dxbuziV4fofcmlCmo/c4121c9a14d78c18961a6e2eeecdc363/SMC_Logo_2024.png"
                                        style="width:200px;" alt="Logo">
                                    <img class="logo-default"
                                        src="https://images.ctfassets.net/5deddylq7ay4/6fDc8dxbuziV4fofcmlCmo/c4121c9a14d78c18961a6e2eeecdc363/SMC_Logo_2024.png"
                                        style="width:200px;" alt="Logo">
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-auto lqd-head-col flex-grow-1 justify-end">
                        <div class="header-module module-primary-nav static">
                            <div class="navbar-collapse lqd-submenu-default-style inline-flex flex-col items-stretch h-full"
                                aria-expanded="false" role="navigation">
                                <ul class="main-nav lqd-menu-counter-right main-nav-hover-default flex reset-ul flex-nowrap items-stretch justify-end link-16 link-medium link-black"
                                    data-submenu-options='{"toggleType": "fade", "handler": "mouse-in-out"}'
                                    data-localscroll="true"
                                    data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lqd-stickybar-wrap lqd-stickybar-left link-black link-medium pointer-events-none">
                <div class="lqd-stickybar w-full h-full relative vertical-rl overflow-visible flex justify-between">
                    <div class="col lqd-head-col justify-center p-0">
                        <div
                            class="ld-module-sd header-module header-module-rotate ld-module-sd-hover no-rotate ld-module-sd-right py-10">
                            <button
                                class="nav-trigger style-2 fill-none flex p-0 border-none rounded-full relative pointer-events-auto bg-transparent text-black items-center justify-center transition-all txt-right collapsed header-sidedrawer horizontal-tb pl-40"
                                type="button" data-ld-toggle="true" data-bs-toggle="collapse"
                                data-toggle-options='{"type" : "hover"}' data-bs-target="#header-sidedrawer"
                                aria-expanded="false" aria-controls="header-sidedrawer"
                                data-lqd-interactive-color="true">
                                <span class="bars">
                                    <span class="bars-inner w-full h-full flex rounded-inherit flex-col">
                                        <span class="bar relative bg-white transition-all"></span>
                                        <span class="bar relative bg-white transition-all"></span>
                                        <span class="bar relative bg-white transition-all"></span>
                                    </span>
                                </span>
                                <span style="color:white;" class="txt">CATALOGUE</span>
                            </button>
                            <div class="ld-module-dropdown collapse pointer-events-auto" aria-valuemin="0"
                                aria-valuenow="0" aria-valuemax="100" id="header-sidedrawer" role="slider">
                                <div class="ld-sd-wrap">
                                    <div class="w-full relative flex flex-wrap h-full justify-between -mr-15 -ml-15">

                                        <div class="w-full flex flex-auto flex-col items-start justify-center px-15">
                                            <div class="header-module no-rotate">
                                                <div class="lqd-fancy-menu lqd-custom-menu lqd-menu-td-none">

                                                    <div class="d-flex align-items-center mb-15"
                                                        style="gap: 10px; font-size: 14px; padding-left: 0;">
                                                        <span
                                                            class="text-uppercase tracking-widest text-10 opacity-50">Sort:</span>
                                                        <a href="#"
                                                            class="sort-btn text-black hover:text-primary font-bold"
                                                            data-sort="asc">A-Z</a>
                                                        <span class="text-muted">|</span>
                                                        <a href="#"
                                                            class="sort-btn text-black hover:text-primary font-bold"
                                                            data-sort="desc">Z-A</a>
                                                    </div>

                                                    <ul id="category-list" class="reset-ul category-accordion" data-localscroll="true"
                                                        data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
                                                        <?php foreach ($grouped_menu as $group): ?>
                                                            <li class="cat-group">
                                                                <details class="cat-group-details">
                                                                    <summary class="cat-parent" data-parent="<?= htmlspecialchars($group['parent']); ?>">
                                                                        <span class="cat-parent-icon">
                                                                            <i data-lucide="<?= htmlspecialchars(get_parent_icon($group['parent'])); ?>"></i>
                                                                        </span>
                                                                        <span class="cat-parent-label"><?= htmlspecialchars($group['parent']); ?></span>
                                                                        <span class="cat-parent-count" data-parent-count="<?= htmlspecialchars($group['parent']); ?>"></span>
                                                                        <span class="cat-parent-arrow">
                                                                            <i data-lucide="chevron-right"></i>
                                                                        </span>
                                                                    </summary>
                                                                    <ul class="reset-ul cat-children">
                                                                        <?php foreach ($group['children'] as $category): ?>
                                                                            <li>
                                                                                <a href="#"
                                                                                   class="category-link"
                                                                                   data-category="<?= htmlspecialchars($category); ?>">
                                                                                    <span class="cat-child-label"><?= htmlspecialchars($category); ?></span>
                                                                                    <span class="cat-child-count" data-child-count="<?= htmlspecialchars($category); ?>"></span>
                                                                                </a>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                </details>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="lqd-module-backdrop"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lqd-mobile-sec d-lg-flex relative">
                <div class="lqd-mobile-sec-inner float-left navbar-header w-full flex items-stretch">
                    <div class="lqd-mobile-modules-container"></div>

                    <a class="text-start navbar-brand" href="#">
                        <span class="navbar-brand-inner justify-start">
                            <img class="logo-default" src="./assets/images/sms_logo.png" alt="Hub Theme">
                        </span>
                    </a>
                </div>

            </div>
        </header>

        <main class="content bg-center-top bg-repeat z-2" id="lqd-site-content"
            style="background-image: url(./assets/images/demo/asymmetric-agency/bg-lines.svg);">
            <div id="lqd-contents-wrap">





                <section class="lqd-section case-studies pt-70 pb-50" data-custom-animations="true"
                    data-ca-options='{"animationTarget": ".lqd-split-lines .lqd-lines .split-inner, .animation-element", "duration" : 750, "startDelay" : 250, "delay" : 55, "ease": "expo.out", "initValues": {"y": "100px", "opacity" : 0}, "animations": {"y": "0px", "opacity" : 1}}'>
                    <div class="container">
                        <div class="row">
                            <div class="col col-12 flex flex-col items-center text-center">

                                <div class="ld-fancy-heading relative mask-text">
                                    <h2 style="color:white;"
                                        class="ld-fh-element mb-0/75em inline-block relative lqd-split-lines"
                                        data-split-text="true" data-split-options='{"type": "lines"}'></h2>
                                </div>
                            </div>
                            <div class="col col-12">


                                <!-------------------------------------------------------- Products ---------------------------------------------------------->
                                <div id="productsContainer" class="lqd-pf-row row flex flex-wrap -mr-15 -ml-15"
                                    data-liquid-masonry="true"
                                    data-masonry-options='{ "filtersID":  "#pf-filter-case-studies" ,  "filtersCounter":  true }'>

                                    <div class="content bg-center-top bg-repeat z-2 bg-white" id="lqd-site-content"
                                        style="background-image: url(./assets/images/demo/asymmetric-agency/bg-lines.svg);">
                                        <div id="lqd-contents-wrap">

                                            <!-- Start About Us -->
                                            <section class="lqd-section about-us pt-50 pb-50"
                                                data-section-luminosity="light">
                                                <div class="container">
                                                    <div class="row items-center">
                                                        <div class="col col-12 col-md-8" data-custom-animations="true"
                                                            data-ca-options='{"triggerHandler":"inview","animationTarget":"all-childs","duration":"1600","delay":"12","ease":"power4.out","direction":"forward","initValues":{"rotationX":75,"rotationY":10,"rotationZ":10,"transformOriginX":50,"transformOriginY":0,"opacity":0},"animations":{"rotationX":0,"rotationY":0,"rotationZ":0,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":1}}'>
                                                            <!--<h6 class="ld-fh-element lqd-split-lines mb-1/5em text-10 uppercase font-semibold tracking-0/1em text-black" data-split-text="true" data-split-options='{"type":"lines"}'> About Us</h6> -->
                                                            <h2 class="ld-fh-element lqd-split-chars pl-30 mb-0 text-36 font-medium leading-1/1em"
                                                                data-split-text="true"
                                                                data-split-options='{"type":"chars, words"}'>Gear up for
                                                                a thrilling experience with our exclusive collection -
                                                                meticulously curated for the high-octane world of moto
                                                                events.</h2>
                                                        </div>
                                                        <div class="col col-12 col-md-3 " data-custom-animations="true"
                                                            data-ca-options='{"triggerHandler":"inview","direction":"forward","initValues":{"y":30,"scaleY":1.1,"rotationX":21,"rotationZ":3,"transformOriginX":0,"transformOriginY":50,"transformOriginZ":"0px","opacity":0},"animations":{"y":0,"scaleY":1,"rotationX":0,"rotationZ":0,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":1}}'>

                                                            <div
                                                                class="lqd-counter lqd-counter-default mb-0 text-black text-end sm:text-start">
                                                                <div class="lqd-counter-element relative mb-0 text-120  font-bold"
                                                                    data-enable-counter="true"
                                                                    data-counter-options='{"targetNumber":"2,331"}'>
                                                                    <span>9</span>
                                                                </div>
                                                            </div>
                                                            <p
                                                                class="ld-fh-element relative mb-0/5em ml-30percent text-16 leading-1em text-black">
                                                                Items in Catalogue</p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- End About Us -->

                                            <!-- Start Hero -->
                                            <section class="lqd-section hero" id="banner" data-parallax="true"
                                                data-parallax-from='{"opacity":1}' data-parallax-to='{"opacity":0}'
                                                data-parallax-options='{"start":"top","end":"bottom top","staticSentinel":".lqd-css-sticky-wrap"}'>
                                                <div
                                                    class="row-bg-wrap inline-block absolute top-0 right-0 bottom-0 left-0 pointer-events-none overflow-hidden">
                                                    <div
                                                        class="row-bg-inner inline-block absolute top-0 right-0 bottom-0 left-0 transition-all">
                                                        <div class="bg-slider">
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/1.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/2.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/3.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/4.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/5.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/6.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/7.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/8.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/9.jpeg');">
                                                            </div>
                                                            <div class="bg-slide"
                                                                style="background-image: url('assets/images/slider/10.jpeg');">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col col-12" data-custom-animations="true"
                                                            data-ca-options='{"triggerHandler":"inview","animationTarget":"all-childs","duration":"1800","delay":"180","ease":"power4.out","direction":"forward","initValues":{"y":120,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":0},"animations":{"y":0,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":1}}'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- End Hero -->


                                            <!-- Start Count -->
                                            <section class="lqd-section team pt-60 pb-100" id="team"
                                                data-section-luminosity="light">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col col-12 col-md-4 col-xl-4 text-center">
                                                            <div
                                                                class="lqd-counter lqd-counter-default pl-30 mb-0 text-black text-end sm:text-start">
                                                                <div class="lqd-counter-element relative mb-0 text-120 leading-0/5em font-bold"
                                                                    data-enable-counter="true"
                                                                    data-counter-options='{"targetNumber":"129,269"}'>
                                                                    <span>9</span>
                                                                </div>
                                                            </div>
                                                            <p
                                                                class="ld-fh-element relative mb-0/5em ml-30percent text-16 leading-1em text-black">
                                                                Total Number of Products</p>
                                                        </div>
                                                        <div
                                                            class="col col-12 col-md-4 col-xl-2 offset-md-4 text-center">
                                                            <div
                                                                class="lqd-counter lqd-counter-default mb-0 text-black text-end sm:text-start">
                                                                <div class="lqd-counter-element relative mb-0 text-120 leading-0/5em font-bold"
                                                                    data-enable-counter="true"
                                                                    data-counter-options='{"targetNumber":"39"}'>
                                                                    <span>9</span>
                                                                </div>
                                                            </div>
                                                            <p
                                                                class="ld-fh-element relative mb-0/5em ml-30percent text-16 leading-1em text-black">
                                                                Categories</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </section>
                                            <!-- End Count -->


                                        </div>
                                    </div>
                                    <div style="height:60px; width:100%; background:#ebebeb;">
                                        <p class="center text-center relative pt-15 text-16 text-black">Powered by
                                            Ardhalfan Infotech | <a href="#" id="fetch-data-btn">Fetch Data</a></p>
                                    </div>
                                </div>


                                <!-------------------------------------------------------- End Products ---------------------------------------------------------->

                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </main>


    </div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
<!-------------------------------------------------------- CODE ---------------------------------------------------------->

<script src="./assets/vendors/jquery.min.js"></script>
<script src="./assets/vendors/jquery-ui/jquery-ui.min.js"></script>
<script src="./assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="./assets/vendors/gsap/minified/gsap.min.js"></script>
<script src="./assets/vendors/gsap/minified/ScrollTrigger.min.js"></script>
<script src="./assets/vendors/gsap/utils/SplitText.min.js"></script>
<script src="./assets/vendors/fastdom/fastdom.min.js"></script>
<script src="./assets/vendors/isotope/isotope.pkgd.min.js"></script>
<script src="./assets/vendors/isotope/packery-mode.pkgd.min.js"></script>
<script src="./assets/vendors/flickity/flickity.pkgd.min.js"></script>
<script src="./assets/vendors/lity/lity.min.js"></script>
<script src="./assets/vendors/particles.min.js"></script>
<script src="./assets/vendors/fontfaceobserver.js"></script>
<script src="./assets/vendors/tinycolor-min.js"></script>
<script src="./assets/vendors/fresco/js/fresco.js"></script>
<script src="./assets/js/theme.min.js"></script>
<script src="./assets/js/liquid-ajax-contact-form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php
if (isset($_SESSION['flash_message'])) {
    echo "<script>toastr.options = {\"closeButton\": true, \"progressBar\": true, \"positionClass\": \"toast-top-right\"}; toastr.success('" . $_SESSION['flash_message'] . "')</script>";
    unset($_SESSION['flash_message']);
}
?>
<script>
    // Global cache object to store data by category
    const dataCache = {};
    const categoryCounts = {};
    let totalProductCount = 0;

    document.addEventListener("DOMContentLoaded", function () {
        // Fetch all category counts on initial page load
        fetchCategoryCounts();

        document.querySelectorAll('.category-link').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                var selectedCategory = this.getAttribute('data-category');

                // Update the heading dynamically based on the selected category
                var headingElement = document.querySelector('.ld-fancy-heading h2');
                if (headingElement) {
                    const count = categoryCounts[selectedCategory] || '';
                    // Display category name with product count
                    headingElement.textContent = `${selectedCategory} ${count ? `(${count} products)` : ''}`;
                }

                createSearchBar();
                loadProductsByCategory(selectedCategory);
            });
        });

        document.getElementById('fetch-data-btn').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('loading-overlay').style.display = 'flex';

            fetch('fetch.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loading-overlay').style.display = 'none';
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(() => location.reload(true), 2000);
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    document.getElementById('loading-overlay').style.display = 'none';
                    toastr.error('An error occurred while fetching data.');
                    console.error('Error:', error);
                });
        });
    });

    // Fetch counts for all categories
    function fetchCategoryCounts() {
        fetch('get_category_counts.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Store category counts
                Object.assign(categoryCounts, data.children || {});

                // Calculate total product count
                totalProductCount = data.total || 0;

                // Update the total counter in the About Us section
                updateTotalProductCounter(totalProductCount);

                // Update category links with counts
                updateCategoryCountsInMenu();
            })
            .catch(error => {
                console.error('Error loading category counts:', error);
            });
    }

    // Update the total product counter in the About Us section
    function updateTotalProductCounter(count) {
        // Update the counter element
        const counterElement = document.querySelector('.lqd-counter-element span');
        if (counterElement) {
            counterElement.textContent = count.toLocaleString();
        }

        // Update the counter options for animation
        const counterParent = document.querySelector('.lqd-counter-element');
        if (counterParent) {
            // Update the data attribute for the counter animation
            const counterOptions = JSON.parse(counterParent.getAttribute('data-counter-options') || '{"targetNumber":"0"}');
            counterOptions.targetNumber = count.toLocaleString();
            counterParent.setAttribute('data-counter-options', JSON.stringify(counterOptions));

            // If the counter plugin is already initialized, we might need to reinitialize it
            // This depends on how the specific counter plugin works
            if (typeof $.fn.liquidCounter === 'function') {
                $(counterParent).liquidCounter();
            }
        }

        // Update the text below the counter
        const counterText = document.querySelector('.ld-fh-element.mb-0\\/5em');
        if (counterText) {
            counterText.textContent = count === 1 ? ' Item in Catalogue' : ' Items in Catalogue';
        }
    }

    // Update the category menu with product counts
    function updateCategoryCountsInMenu() {
        document.querySelectorAll('.category-link').forEach(function (item) {
            const category = item.getAttribute('data-category');
            const count = categoryCounts[category];

            if (count !== undefined) {
                // Append count in parentheses
                item.innerHTML = `${category} <span class="category-count">(${count})</span>`;
            }
        });
    }









    // Create search bar if it doesn't exist
    function createSearchBar() {
        // Check if the search bar already exists to avoid duplicates
        if (!document.getElementById('searchContainer')) {
            // Create the search container div
            let searchContainer = document.createElement('div');
            searchContainer.id = 'searchContainer';
            searchContainer.style.textAlign = 'center';
            searchContainer.style.padding = '20px';

            // Create the input field
            let input = document.createElement('input');
            input.type = 'text';
            input.id = 'productSearch';
            input.placeholder = 'Search products...';
            input.style.width = '50%';
            input.style.padding = '10px';
            input.style.marginBottom = '20px';
            input.onkeyup = searchProducts;

            // Create the search button
            let button = document.createElement('button');
            button.onclick = searchProducts;
            button.style.padding = '10px';
            button.textContent = 'Search';

            // Append input and button to searchContainer
            searchContainer.appendChild(input);
            searchContainer.appendChild(button);

            // Insert the searchContainer before the productsContainer
            let productsContainer = document.getElementById('productsContainer');
            productsContainer.parentNode.insertBefore(searchContainer, productsContainer);
        }
    }

    // Function to load products with caching and progressive loading
    function loadProductsByCategory(category) {
        const productsContainer = document.querySelector('#productsContainer');

        // Show loading indicator
        productsContainer.innerHTML = '<div class="loading-indicator text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p>Loading products...</p></div>';

        // Check if data is already cached
        if (dataCache[category]) {
            console.log("Using cached data for category:", category);
            renderProducts(dataCache[category], category);
            return;
        }

        // If not cached, fetch from server
        let url = `load_products_2.php?page=1&limit=200`;
        if (category) url += `&category=${encodeURIComponent(category)}`;
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Cache the data
                dataCache[category] = data.products;

                // Update category count if not already known
                if (categoryCounts[category] === undefined) {
                    categoryCounts[category] = data.totalProducts;
                    updateCategoryCountsInMenu();
                }

                renderProducts(data.products, category);
            })
            .catch(error => {
                console.error('Error loading products:', error);
                productsContainer.innerHTML = `<div class="alert alert-danger">Error loading products: ${error.message}</div>`;
            });
    }

    // Separate rendering function to process cached or fetched data
    function renderProducts(products, category) {
        const productsContainer = document.querySelector('#productsContainer');
        productsContainer.innerHTML = ''; // Clear current products

        // Add category information at the top
        const categoryInfoHTML = `
                    <div class="col-12 mb-4">
                       
                        <hr>
                    </div>
                `;
        productsContainer.innerHTML = categoryInfoHTML;

        // If we have a large dataset, use chunked rendering
        if (products.length > 50) {
            renderProductsInChunks(products, 0);
        } else {
            // For smaller datasets, render all at once
            renderProductBatch(products, productsContainer);
        }
    }

    // Render products in smaller batches to prevent UI freezing
    function renderProductsInChunks(products, startIndex) {
        const productsContainer = document.querySelector('#productsContainer');
        const chunkSize = 20; // Number of products to render at once
        const endIndex = Math.min(startIndex + chunkSize, products.length);
        const chunk = products.slice(startIndex, endIndex);

        // Render this chunk
        renderProductBatch(chunk, productsContainer, false);

        // If there are more products to render, schedule the next chunk
        if (endIndex < products.length) {
            // Add a "Loading more..." message
            let loadingMore = document.createElement('div');
            loadingMore.id = 'loading-more';
            loadingMore.className = 'col-12 text-center p-3';
            loadingMore.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading more products...';
            productsContainer.appendChild(loadingMore);

            // Use requestAnimationFrame for better performance
            window.requestAnimationFrame(() => {
                setTimeout(() => {
                    // Remove the loading indicator before loading next batch
                    document.getElementById('loading-more')?.remove();
                    renderProductsInChunks(products, endIndex);
                }, 100);
            });
        } else {
            // All chunks rendered, add footer
            addFooter(productsContainer);

            // After all products are loaded, equalize heights
            setTimeout(() => equalizeHeights('.lqd-pf-column'), 200);
        }
    }

    // Render a batch of products
    function renderProductBatch(productBatch, container, addFooterAfter = true) {
        let productsHTML = '';

        productBatch.forEach(product => {
            // Ensure that missing data is handled gracefully
            const description = product.description || 'No description available';
            const imageSrc = product.images || 'path/to/default/image.png';
            const name = product.name || 'Unnamed Product';
            const ref = product.internal_reference || 'No Ref';
            const quantity = product.stock_quantity || '0';
            const unit = product.product_unit || 'units';

            productsHTML += `
                        <div class="lqd-pf-column col-12 col-md-3 col-lg-3 px-15 masonry-item digital-design ecommerce portfolio-single">
                            <article class="lqd-pf-item lqd-pf-item-style-6 px-1em pb-1em pt-1/6em lqd-pf-dark post-3869 liquid-portfolio type-liquid-portfolio status-publish format-standard has-post-thumbnail hentry liquid-portfolio-category-digital-design liquid-portfolio-category-ecommerce liquid-portfolio-category-portfolio-single">
                                <div class="lqd-pf-item-inner">
                                    <a href="${imageSrc}" class="fresco">
                                    <div class="lqd-pf-img mb-1em relative rounded-10 overflow-hidden product_image">
                                        <img style="height:250px; width:none; max-width:none;" src="${imageSrc}" alt="${name}" loading="lazy">
                                        <span class="lqd-pf-overlay-bg lqd-overlay flex items-center justify-center bg-transparent" style="background-image: linear-gradient(180deg, #675DE100 0%, #284541 100%);"></span>
                                    </div>
                                    </a>
                                    <div class="lqd-pf-details">
                                        <div class="flex justify-between">
                                            <h3 class="lqd-pf-title mt-0 items-center">${name}</h3>
                                        </div>
                                        <ul class="reset-ul inline-nav" style="font-size:14px;">
                                            <li class="ref_product">Ref : ${ref}</li></br>
                                            <li class="quantity_product">Quantity : ${quantity} ${unit}</li></br>
                                            <li class="description_product">${description}</li>
                                        </ul>
                                    </div>
                                </div>
                            </article>
                        </div>
                    `;
        });

        // Append the HTML to the container
        container.innerHTML += productsHTML;

        // Add footer if this is the last batch
        if (addFooterAfter) {
            addFooter(container);
            // Equalize heights after rendering
            setTimeout(() => equalizeHeights('.lqd-pf-column'), 200);
        }
    }

    // Add footer to the container
    function addFooter(container) {
        const footerHTML = `
                    <div style="height:60px; width:100%; background:#ebebeb;">
                        <p class="center text-center relative pt-15 text-16 text-black">Powered by Ardhalfan Infotech</p>
                    </div>
                `;
        container.innerHTML += footerHTML;
    }

    // Search products function
    function searchProducts() {
        let input = document.getElementById('productSearch');
        let filter = input.value.toUpperCase();
        let productsContainer = document.getElementById('productsContainer');
        let products = productsContainer.getElementsByClassName('lqd-pf-column');

        let matchCount = 0;

        for (let i = 0; i < products.length; i++) {
            // Access the elements for title, reference, description, and quantity
            let title = products[i].querySelector(".lqd-pf-title");
            let ref = products[i].querySelector(".ref_product");
            let description = products[i].querySelector(".description_product");
            let quantity = products[i].querySelector(".quantity_product");

            // Combine text values from all these elements
            let textValues = [title, ref, description, quantity]
                .filter(element => element)
                .map(element => element.textContent || element.innerText)
                .join(" ");

            // Check if the combined text values contain the search filter
            if (textValues.toUpperCase().indexOf(filter) > -1) {
                products[i].style.display = "";
                matchCount++;
            } else {
                products[i].style.display = "none";
            }
        }

        // Update the count badge to show filtered count
        const countBadge = document.querySelector('.product-count-badge');
        if (countBadge && filter) {
            countBadge.textContent = `${matchCount} Products (filtered)`;
        } else if (countBadge) {
            // Restore original count
            const category = document.querySelector('.ld-fancy-heading h2')?.textContent.split(' (')[0];
            if (category && categoryCounts[category]) {
                countBadge.textContent = `${categoryCounts[category]} Products`;
            }
        }
    }

    // Equalize product item heights
    function equalizeHeights(selector) {
        // Reset heights first
        const items = document.querySelectorAll(selector);
        items.forEach(item => {
            item.style.height = 'auto';
        });

        // Calculate and set new heights
        let maxHeight = 0;
        items.forEach(item => {
            if (item.offsetHeight > maxHeight) {
                maxHeight = item.offsetHeight;
            }
        });

        items.forEach(item => {
            item.style.height = `${maxHeight}px`;
        });
    }

    // Force browser to load images in a controlled way
    function preloadImages(category) {
        if (dataCache[category]) {
            const imageUrls = dataCache[category]
                .map(product => product.images)
                .filter(url => url);

            imageUrls.forEach((url, index) => {
                if (index < 10) { // Just preload first 10 images
                    const img = new Image();
                    img.src = url;
                }
            });
        }
    }

    // Handle window resize for responsive layouts
    window.addEventListener('resize', () => {
        equalizeHeights('.lqd-pf-column');
    });

    // Force Initialize Hero Slider
    document.addEventListener('DOMContentLoaded', function () {
        var sliderSelector = '#hero-slider';
        var sliderElement = document.querySelector(sliderSelector);

        if (sliderElement) {
            // Try Bootstrap 5
            if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                var carousel = new bootstrap.Carousel(sliderElement, {
                    interval: 4000,
                    ride: 'carousel',
                    pause: false
                });
                carousel.cycle();
            }
            // Try jQuery / Bootstrap 4
            else if (typeof jQuery !== 'undefined' && jQuery(sliderSelector).carousel) {
                jQuery(sliderSelector).carousel({
                    interval: 4000,
                    ride: 'carousel',
                    pause: false
                });
                jQuery(sliderSelector).carousel('cycle');
            }
        }
    });

    // Sorting Logic
    const sortBtns = document.querySelectorAll('.sort-btn');
    const categoryList = document.getElementById('category-list');
    
    if (categoryList && sortBtns.length > 0) {
        sortBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const sortType = btn.getAttribute('data-sort');
                const items = Array.from(categoryList.children);
                
                items.sort((a, b) => {
                    const linkA = a.querySelector('.category-link');
                    const linkB = b.querySelector('.category-link');
                    
                    if (!linkA || !linkB) return 0;
                    
                    const textA = linkA.innerText.trim().toUpperCase();
                    const textB = linkB.innerText.trim().toUpperCase();
                    
                    if (sortType === 'asc') {
                        return textA.localeCompare(textB);
                    } else {
                        return textB.localeCompare(textA);
                    }
                });
                
                // Clear and re-append sorted items
                categoryList.innerHTML = '';
                items.forEach(item => categoryList.appendChild(item));
            });
        });
    }

    // Accordion and Parent Filtering Logic
    (function() {
        'use strict';

        var accordion = document.getElementById('category-list');
        if (!accordion) return;

        // 1. Accordion behavior — only one <details> open at a time
        accordion.addEventListener('toggle', function(e) {
            if (!e.target.matches('details.cat-group-details')) return;
            if (e.target.open) {
                var others = accordion.querySelectorAll('details.cat-group-details[open]');
                others.forEach(function(d) {
                    if (d !== e.target) d.removeAttribute('open');
                });
            }
        }, true);

        // 2. Parent click → trigger filter for all children of that parent
        accordion.addEventListener('click', function(e) {
            var summary = e.target.closest('summary.cat-parent');
            if (!summary) return;

            var parentName = summary.getAttribute('data-parent');
            if (!parentName) return;

            var details = summary.parentElement;
            var isClosing = details.hasAttribute('open');

            // Update heading
            var headingElement = document.querySelector('.ld-fancy-heading h2');
            if (headingElement) {
                headingElement.textContent = isClosing ? 'All Products' : parentName;
            }

            if (isClosing) {
                triggerFilter({ reset: true });
            } else {
                triggerFilter({ parent: parentName });
            }
        });

        // 3. Hand off to the existing filter system
        window.triggerFilter = function(opts) {
            const productsContainer = document.querySelector('#productsContainer');
            productsContainer.innerHTML = '<div class="loading-indicator text-center py-5"><div class="spinner-border text-primary" role="status"></div><p>Loading products...</p></div>';

            let url = `load_products_2.php?page=1&limit=200`;
            if (opts.category) url += `&category=${encodeURIComponent(opts.category)}`;
            if (opts.parent) url += `&parent=${encodeURIComponent(opts.parent)}`;
            if (opts.reset) url += `&parent=ALL`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Cache results if it's a category
                    if (opts.category) dataCache[opts.category] = data.products;
                    renderProducts(data.products, opts.category || opts.parent || 'All');
                })
                .catch(error => {
                    console.error('Error in triggerFilter:', error);
                    productsContainer.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        };

        // 4. On page load: read URL params, expand the matching parent
        function autoExpandFromUrl() {
            var params = new URLSearchParams(window.location.search);
            var activeChild = params.get('category');
            var activeParent = params.get('parent');

            if (activeParent) {
                var summary = accordion.querySelector('summary[data-parent="' + cssEscape(activeParent) + '"]');
                if (summary) summary.parentElement.setAttribute('open', '');
                triggerFilter({ parent: activeParent });
                return;
            }

            if (activeChild) {
                var childLink = accordion.querySelector('a.category-link[data-category="' + cssEscape(activeChild) + '"]');
                if (childLink) {
                    childLink.classList.add('active');
                    var details = childLink.closest('details.cat-group-details');
                    if (details) details.setAttribute('open', '');
                    triggerFilter({ category: activeChild });
                }
            }
        }

        function cssEscape(s) {
            return s.replace(/(["\\])/g, '\\$1');
        }

        // Populate count badges
        fetch('get_category_counts.php')
            .then(function(r) { return r.json(); })
            .then(function(counts) {
                if (counts.error) {
                    console.warn('Category counts unavailable:', counts.error);
                    return;
                }
                Object.keys(counts.parents || {}).forEach(function(parent) {
                    var el = document.querySelector('[data-parent-count="' + cssEscape(parent) + '"]');
                    if (el) el.textContent = counts.parents[parent];
                });
                Object.keys(counts.children || {}).forEach(function(child) {
                    var el = document.querySelector('[data-child-count="' + cssEscape(child) + '"]');
                    if (el) el.textContent = counts.children[child];
                });
            })
            .catch(function(err) {
                console.warn('Could not load category counts:', err);
            });

        autoExpandFromUrl();
    })();
</script>

</body>

</html>