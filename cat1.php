<?php
// Specify the path to the JSON file
$jsonFilePath = 'data.json';

// Check if the file exists
if (file_exists($jsonFilePath)) {
    // Read the contents of the JSON file
    $jsonContent = file_get_contents($jsonFilePath);

    // Decode the JSON data into a PHP array
    $data = json_decode($jsonContent, true);

    // Check if decoding was successful
    if ($data !== null && isset($data['result']['payload']['product_stock_details'])) {
        // Extract the product stock details
        $productStockDetails = $data['result']['payload']['product_stock_details'];
        
        
        $uniqueCategories = [];
         foreach ($productStockDetails as $product) {
            // Check if the category exists in the product and is not already in the array
            if (!in_array($product['product_category'], $uniqueCategories)) {
                $uniqueCategories[] = $product['product_category'];
            }
        }

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

		<title>Saudi Motosport - Product Catalog </title>
	</head>

	<body style="background-color: #032824; background-image: url(https://saudimotorsport.com/static/pattern-bg-138686d69440bf998f880b4ef82ec35f.svg);" class="lqd-cc-outer-hidden" data-lqd-cc="true" data-mobile-nav-breakpoint="1199" data-mobile-nav-style="modern" data-mobile-nav-scheme="dark" data-mobile-nav-trigger-alignment="right" data-mobile-header-scheme="gray" data-mobile-logo-alignment="default" data-overlay-onmobile="false">
		<div id="wrap">

			<div class="lqd-sticky-placeholder hidden"></div>
			<header class="site-header main-header sticky-header-noshadow main-header-dynamiccolors" data-sticky-header="true" data-sticky-values-measured="false" data-sticky-options='{"disableOnMobile":true,"stickyTrigger":"first-section","dynamicColors":true}'>
				<div class="lqd-head-sec-wrap lqd-hide-onstuck relative pr-35 pl-20 md:hidden">
					<div class="w-full flex items-center justify-between">
						<div class="col-auto lqd-head-col flex-grow-1 justify-start">
							<div class="header-module module-primary-nav static">
								<div class="navbar-collapse lqd-submenu-default-style inline-flex flex-col items-stretch h-full" aria-expanded="false" role="navigation">
									<ul class="main-nav lqd-menu-counter-right main-nav-hover-default flex reset-ul flex-nowrap items-stretch justify-end link-16 link-medium link-black" data-submenu-options='{"toggleType": "fade", "handler": "mouse-in-out"}' data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
									
									</ul>
								</div>
							</div>
						</div>
						<div class="col-auto lqd-head-col flex-grow-1 justify-center">
							<div class="header-module module-logo no-rotate navbar-brand-plain pt-40 pb-30">
								<a class="navbar-brand" href="./index-asymmetric-agency.html" rel="home">
									<span class="navbar-brand-inner">
										<img class="logo-light" src="./assets/images/sms_logo.png" alt="Hub Theme">
										<img class="logo-default" src="./assets/images/sms_logo.png" style="width:250px;" alt="Hub Theme">
									</span>
								</a>
							</div>
						</div>
						<div class="col-auto lqd-head-col flex-grow-1 justify-end">
							<div class="header-module module-primary-nav static">
								<div class="navbar-collapse lqd-submenu-default-style inline-flex flex-col items-stretch h-full" aria-expanded="false" role="navigation">
									<ul class="main-nav lqd-menu-counter-right main-nav-hover-default flex reset-ul flex-nowrap items-stretch justify-end link-16 link-medium link-black" data-submenu-options='{"toggleType": "fade", "handler": "mouse-in-out"}' data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
										
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="lqd-stickybar-wrap lqd-stickybar-left link-black link-medium pointer-events-none md:hidden">
					<div class="lqd-stickybar w-full h-full relative vertical-rl overflow-visible flex justify-between">
						<div class="col lqd-head-col justify-center p-0">
							<div class="ld-module-sd header-module header-module-rotate ld-module-sd-hover no-rotate ld-module-sd-right py-10">
								<button class="nav-trigger style-2 fill-none flex p-0 border-none rounded-full relative pointer-events-auto bg-transparent text-black items-center justify-center transition-all txt-right collapsed header-sidedrawer horizontal-tb pl-40" type="button" data-ld-toggle="true" data-bs-toggle="collapse" data-toggle-options='{"type" : "hover"}' data-bs-target="#header-sidedrawer" aria-expanded="false" aria-controls="header-sidedrawer" data-lqd-interactive-color="true">
									<span class="bars">
										<span class="bars-inner w-full h-full flex rounded-inherit flex-col">
											<span class="bar relative bg-black transition-all"></span>
											<span class="bar relative bg-black transition-all"></span>
											<span class="bar relative bg-black transition-all"></span>
										</span>
									</span>
									<span class="txt">Categories</span>
								</button>
								<div class="ld-module-dropdown collapse pointer-events-auto" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" id="header-sidedrawer" role="slider">
									<div class="ld-sd-wrap">
										<div class="w-full relative flex flex-wrap h-full justify-between -mr-15 -ml-15">
											<div class="w-full flex flex-auto flex-col items-start justify-start px-15">
												<div class="header-module module-logo no-rotate navbar-brand-plain py-25">
													<a class="navbar-brand" href="./index-asymmetric-agency.html" rel="home">
														<span class="navbar-brand-inner">
															<img class="logo-light" src="./assets/images/sms_logo.png" alt="Hub Theme">
															<img class="logo-default" src="./assets/images/sms_logo.png" alt="Hub Theme">
														</span>
													</a>
												</div>
											</div>
											<div class="w-full flex flex-auto flex-col items-start justify-center px-15">
												<div class="header-module no-rotate">
													<div class="lqd-fancy-menu lqd-custom-menu lqd-menu-td-none">
														<ul class="reset-ul" data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
															<?php foreach ($uniqueCategories as $category) { ?>
															<li class="mb-15">
																<a class="flex leading-1/5em hover:text-primary" href="#banner" aria-current="page"><?php echo htmlspecialchars($category); ?></a>
															</li>
															<?php } ?>
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
				<div class="lqd-stickybar-wrap lqd-stickybar-right lqd-show-onstuck pointer-events-none pb-80 md:hidden">
					<div class="lqd-stickybar flex flex-col">
						<div class="col lqd-head-col"></div>
						<div class="col lqd-head-col"></div>
						<div class="col lqd-head-col flex-col justify-end">
							<div class="header-module module-button pointer-events-auto">
								<a href="#lity-modal-mini" class="btn btn-icon-block btn-icon-top btn-icon-custom-size btn-icon-circle btn-icon-solid btn-no-label rounded-full bg-blue-900" data-lity=" #lity-modal-mini">
									<span class="btn-icon w-60 h-60 text-white text-20 my-0">
										<i class="lqd-icn-ess icon-lqd-pen"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="lqd-mobile-sec d-lg-flex relative">
					<div class="lqd-mobile-sec-inner float-left navbar-header w-full flex items-stretch">
						<div class="lqd-mobile-modules-container"></div>
						<button type="button" class="justify-end navbar-toggle collapsed nav-trigger flex p-0 border-none rounded-full relative bg-transparent text-black items-center justify-center transition-all style-mobile" data-ld-toggle="true" data-bs-toggle="collapse" data-bs-target="#lqd-mobile-sec-nav" aria-expanded="false" data-toggle-options='{"changeClassnames" : {"html" : "mobile-nav-activated"}}'>
							<span class="sr-only">Toggle navigation</span>
							<span class="bars">
								<span class="bars-inner w-full h-full flex rounded-inherit flex-col">
									<span class="bar bg-black transition-all"></span>
									<span class="bar bg-black transition-all"></span>
									<span class="bar bg-black transition-all"></span>
								</span>
							</span>
						</button>
						<a class="text-start navbar-brand" href="./index-asymmetric-agency.html">
							<span class="navbar-brand-inner justify-start">
								<img class="logo-default" src="./assets/images/demo/asymmetric-agency/logo.svg" alt="Hub Theme">
							</span>
						</a>
					</div>
					<div class="lqd-mobile-sec-nav w-full absolute z-index-10">
						<div class="mobile-navbar-collapse navbar-collapse collapse text-white" id="lqd-mobile-sec-nav" aria-expanded="false" role="navigation">
							<ul id="mobile-primary-nav" class="lqd-mobile-main-nav main-nav nav" data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
								<li>
									<a href="#banner" aria-current="page">Home<sup class="link-sup">01</sup></a>
								</li>
								<li>
									<a href="./page-asymmetric-agency-about-us.html">About<sup class="link-sup">02</sup></a>
								</li>
								<li class="menu-item-has-children">
									<a href="./page-asymmetric-agency-case-studies.html">
										Case Studies
										<span class="submenu-expander inline-flex bg-white-5 absolute"></span>
										<sup class="link-sup">03</sup>
									</a>
								</li>
								<li>
									<a href="./page-asymmetric-agency-our-approach.html">Approach<sup class="link-sup">04</sup></a>
								</li>
								<li>
									<a href="./page-asymmetric-agency-expertise.html">Expertise<sup class="link-sup">05</sup></a>
								</li>
								<li>
									<a href="./index-asymmetric-agency.html#blog">Blog<sup class="link-sup">06</sup></a>
								</li>
								<li>
									<a href="./index-asymmetric-agency.html#contact">Contact<sup class="link-sup">06</sup></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</header>

			<main class="content bg-center-top bg-repeat z-2" id="lqd-site-content" style="background-image: url(./assets/images/demo/asymmetric-agency/bg-lines.svg);">
				<div id="lqd-contents-wrap">

				
				
				   
				
					<section class="lqd-section case-studies pt-70 pb-50" data-custom-animations="true" data-ca-options='{"animationTarget": ".lqd-split-lines .lqd-lines .split-inner, .animation-element", "duration" : 750, "startDelay" : 250, "delay" : 55, "ease": "expo.out", "initValues": {"y": "100px", "opacity" : 0}, "animations": {"y": "0px", "opacity" : 1}}'>
						<div class="container">
							<div class="row">
								<div class="col col-12 flex flex-col items-center text-center">
									
									<div class="ld-fancy-heading relative mask-text">
										<h2 class="ld-fh-element mb-0/75em inline-block relative lqd-split-lines" data-split-text="true" data-split-options='{"type": "lines"}'> Furnitures </h2>
									</div>
								</div>
								<div class="col col-12">
								
								       
                                        
										<div class="lqd-pf-row row flex flex-wrap -mr-15 -ml-15" data-liquid-masonry="true" data-masonry-options='{ "filtersID":  "#pf-filter-case-studies" ,  "filtersCounter":  true }'>
											
											
											<!-- Start  -->
					
					
											<?php foreach ($productStockDetails as $product) { ?>
                                            <?php if($product['product_category']=="FURNITURE"){ ?>
                                            
											<div class="lqd-pf-column col-12 col-md-6 col-lg-4 px-15 masonry-item digital-design ecommerce portfolio-single">
												<article class="lqd-pf-item lqd-pf-item-style-6 rounded-6 px-1em pb-1em pt-1/6em lqd-pf-dark post-3869 liquid-portfolio type-liquid-portfolio status-publish format-standard has-post-thumbnail hentry liquid-portfolio-category-digital-design liquid-portfolio-category-ecommerce liquid-portfolio-category-portfolio-single">
													<div class="lqd-pf-item-inner">
														<div class="lqd-pf-img mb-1em relative rounded-10 overflow-hidden">
															<figure>
																<figure class="w-full">
																	<img width="auto" height="478" src="<?= $product['images']; ?>" alt="case studies">
																</figure>
															</figure>
															<span class="lqd-pf-overlay-bg lqd-overlay flex items-center justify-center bg-transparent" style="background-image: linear-gradient(180deg, #675DE100 0%, #284541 100%);"></span>
														</div>
														<div class="lqd-pf-details">
															<div class="flex justify-between">
																<h3 class="lqd-pf-title mt-0 items-center"><?= $product['name']; ?></h3>
															</div>
															<ul class="reset-ul inline-nav" style="font-size:14px;">
																<li><a href="#">Ref : <?= $product['internal_reference']; ?></a></li></br>
																<li><a href="#">Quantity : <?= htmlspecialchars($product['stock_quantity']) ?> <?= htmlspecialchars($product['product_unit']) ?></a></li></br>
																<li><a href="#"><?= $product['description']; ?></a></li>
															</ul>
													</div>
												</article>
											</div>
											<?php } ?>
                                            <?php }  ?>
									
											
											<!-- End  -->
											
											
											
										
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- End Case Studies -->




				
                    
                    
                 

				</div>
			</main>

		</div>

		<!-- Contact modal -->
		<div id="contact-modal" class="lity-modal lqd-modal lity-hide" data-modal-type="fullscreen">
			<div class="lqd-modal-inner">
				<div class="lqd-modal-head"></div>
				<section class="lqd-section lqd-modal-content flex items-center link-black bg-center bg-cover bg-norepeat h-100vh py-80 sm:h-auto" style="background-image: url(./assets/images/common/modal-bg.jpeg);">
					<div class="container flex items-center sm:p-0">
						<div class="row items-center content-center h-full">
							<div class="col col-12 col-md-6 mb-30">
								<div class="ld-fancy-heading">
									<h2 class="ld-fh-element text-120 mb-0/5em leading-0/8em text-medium">Send a <span>message.</span></h2>
								</div>
								<div class="ld-fancy-heading">
									<p class="ld-fh-element mb-2/5em">We're here to answer any question you may have.</p>
								</div>
							</div>
							<div class="col col-12 col-md-6 -mb-100 module-col">
								<div class="lqd-contact-form lqd-contact-form-inputs-underlined lqd-contact-form-button-lg lqd-contact-form-button-block py-45 px-65 -mb-50 md:p-0">
									<div role="form">
										<div class="screen-reader-response">
											<p role="status" aria-live="polite" aria-atomic="true"></p>
										</div>
										<form action="./assets/php/mailer.php" method="post" class="lqd-cf-form" novalidate="novalidate" data-status="init">
											<div class="row">
												<div class="col col-md-6 col-12">
													<p class="m-0 text-black-30 text-12">Your name</p>
													<p>
														<span class="lqd-form-control-wrap text">
															<input class="text-13 text-black border-black-10 font-bold bg-transparent" type="text" name="name" value="" size="40" aria-required="true" aria-invalid="false" placeholder="Full name">
														</span>
													</p>
												</div>
												<div class="col col-md-6 col-12">
													<p class="m-0 text-black-30 text-12">Email address</p>
													<p>
														<span class="lqd-form-control-wrap email">
															<input class="text-13 text-black border-black-10 font-bold bg-transparent" type="email" name="email" value="" size="40" aria-required="true" aria-invalid="false" placeholder="Email Address">
														</span>
													</p>
												</div>
												<div class="col col-md-6 col-12">
													<p class="m-0 text-black-30 text-12">(Optional)</p>
													<p>
														<span class="lqd-form-control-wrap tel">
															<input class="text-13 text-black border-black-10 font-bold bg-transparent" type="tel" name="tel" value="" size="40" aria-invalid="false" placeholder="Phone number">
														</span>
													</p>
												</div>
												<div class="col col-md-6 col-12">
													<p class="m-0 text-black-30 text-12">Subject</p>
													<p>
														<span class="lqd-form-control-wrap text">
															<input class="text-13 text-black border-black-10 font-bold bg-transparent" type="text" name="project-name" value="" size="40" aria-required="true" aria-invalid="false" placeholder="New Project">
														</span>
													</p>
												</div>
												<div class="col col-12">
													<p class="m-0 text-black-30 text-12">Your message</p>
													<p>
														<span class="lqd-form-control-wrap textarea">
															<textarea class="text-13 text-black border-black-10 font-bold bg-transparent" name="message" cols="10" rows="4" aria-required="true" aria-invalid="false" placeholder="Tell us about your project"></textarea>
														</span>
													</p>
												</div>
												<div class="col col-12">
													<span class="lqd-form-control-wrap acceptance">
														<span class="lqd-cf-form-control lqd-cf-acceptance">
															<span class="lqd-cf-list-item">
																<label>
																	<input type="checkbox" name="acceptance" value="1" aria-invalid="false">
																	<span class="lqd-cf-list-item-label">I am bound by the terms of the Service I accept Privacy Policy</span>
																</label>
															</span>
														</span>
													</span>
												</div>
												<div class="col col-12">
													<input type="submit" value="Send message" class="lqd-cf-form-control bg-primary text-white text-17 leading-1/5em font-medium">
												</div>
											</div>
										</form>
										<div class="lqd-cf-response-output"></div>
									</div>
								</div>
							</div>
							<div class="col col-12 col-md-3">
								<div class="ld-fancy-heading relative">
									<h6 class="ld-fh-element text-14 font-bold mb-1/25em tracking-0 inline-block relative">careers</h6>
								</div>
								<div class="ld-fancy-heading relative">
									<p class="ld-fh-element text-16 leading-1/2em mb-0/75em inline-block relative text-black">Would you like to join our growing team?</p>
								</div>
								<div class="ld-fancy-heading relative">
									<p class="ld-fh-element mb-0/5em inline-block relative font-bold leading-1/2em text-16 text-black">careers@hub.com</p>
								</div>
							</div>
							<div class="col col-12 col-md-3">
								<div class="ld-fancy-heading relative">
									<h6 class="ld-fh-element text-14 font-bold mb-1/25em tracking-0 inline-block relative">Feedbacks</h6>
								</div>
								<div class="ld-fancy-heading relative">
									<p class="ld-fh-element text-16 leading-1/2em mb-0/75em inline-block relative text-black">Have a project in mind? Send a message.</p>
								</div>
								<div class="ld-fancy-heading relative">
									<p class="ld-fh-element mb-0/5em inline-block relative font-bold leading-1/2em text-16 text-black">info@hub.com</p>
								</div>
							</div>
						</div>
					</div>
				</section>
				<div class="lqd-modal-foot"></div>
			</div>
		</div>
		<!-- Contact modal -->

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
		<script src="./assets/js/theme.min.js"></script>
		<script src="./assets/js/liquid-ajax-contact-form.min.js"></script>

		<!-- Start custom cursor
		<div class="lqd-cc lqd-cc--inner fixed pointer-events-none"></div>
		<div class="lqd-cc--el lqd-cc-solid lqd-cc-explore flex items-center justify-center rounded-full fixed pointer-events-none">
			<div class="lqd-cc-solid-bg flex absolute lqd-overlay"></div>
			<div class="lqd-cc-solid-txt flex justify-center text-center relative">
				<div class="lqd-cc-solid-txt-inner">Explide</div>
			</div>
		</div>
		<div class="lqd-cc--el lqd-cc-solid lqd-cc-drag flex items-center justify-center rounded-full fixed pointer-events-none">
			<div class="lqd-cc-solid-bg flex absolute lqd-overlay"></div>
			<div class="lqd-cc-solid-ext lqd-cc-solid-ext-left inline-flex items-center">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M19.943 6.07L9.837 14.73a1.486 1.486 0 0 0 0 2.25l10.106 8.661c.96.826 2.457.145 2.447-1.125V7.195c0-1.27-1.487-1.951-2.447-1.125z"></path></svg>
			</div>
			<div class="lqd-cc-solid-txt flex justify-center text-center relative">
				<div class="lqd-cc-solid-txt-inner">Drag</div>
			</div>
			<div class="lqd-cc-solid-ext lqd-cc-solid-ext-right inline-flex items-center">
				<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M11.768 25.641l10.106-8.66a1.486 1.486 0 0 0 0-2.25L11.768 6.07c-.96-.826-2.457-.145-2.447 1.125v17.321c0 1.27 1.487 1.951 2.447 1.125z"></path></svg>
			</div>
		</div>
		<div class="lqd-cc--el lqd-cc-arrow inline-flex items-center fixed top-0 left-0 pointer-events-none">
			<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M60.4993 0V4.77005H8.87285L80 75.9207L75.7886 79.1419L4.98796 8.35478V60.4993H0V0H60.4993Z"/>
			</svg>
		</div>
		<div class="lqd-cc--el lqd-cc-custom-icon rounded-full fixed pointer-events-none">
			<div class="lqd-cc-ci inline-flex items-center justify-center rounded-full relative">
				<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M16.03 6a1 1 0 0 1 1 1v8.02h8.02a1 1 0 1 1 0 2.01h-8.02v8.02a1 1 0 1 1-2.01 0v-8.02h-8.02a1 1 0 1 1 0-2.01h8.02v-8.01a1 1 0 0 1 1.01-1.01z"></path></svg>
			</div>
		</div>
		<div class="lqd-cc lqd-cc--outer fixed top-0 left-0 pointer-events-none"></div>
		<!-- End custom cursor -->

		<template id="lqd-snickersbar">
			<div class="lqd-snickersbar flex flex-wrap lqd-snickersbar-in" data-item-id>
				<div class="lqd-snickersbar-inner flex flex-wrap items-center">
					<div class="lqd-snickersbar-detail">
						<p class="hidden lqd-snickersbar-addding-temp my-0">Adding {{itemName}} to cart</p>
						<p class="hidden lqd-snickersbar-added-temp my-0">Added {{itemName}} to cart</p>
						<p class="my-0 lqd-snickersbar-msg flex items-center my-0"></p>
						<p class="my-0 lqd-snickersbar-msg-done flex items-center my-0"></p>
					</div>
					<div class="lqd-snickersbar-ext ml-4"></div>
				</div>
			</div>
		</template>
		<template id="lqd-temp-sticky-header-sentinel">
			<div class="lqd-sticky-sentinel invisible absolute pointer-events-none"></div>
		</template>
		<div class="lity" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1" data-modal-type="default">
			<div class="lity-wrap" data-lity-close role="document">
				<div class="lity-loader" aria-hidden="true">Loading...</div>
				<div class="lity-container">
					<div class="lity-content"></div>
				</div>
				<button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>&times;</button>
			</div>
		</div>
	</body>

</html>
  <?php }  ?>
    <?php }  ?>