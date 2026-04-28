<?php
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

		<title>Saudi Motosport - Product Catalogue </title>
		<style>.nav-trigger.style-2 .bar:after, .nav-trigger.style-2 .bar:before{background:#fff!important;}</style>
	</head>

	<body style="background-color: #032824; background-image: url(https://saudimotorsport.com/static/pattern-bg-138686d69440bf998f880b4ef82ec35f.svg);"  class="lqd-cc-outer-hidden" data-lqd-cc="true" data-mobile-nav-breakpoint="1199" data-mobile-nav-style="modern" data-mobile-nav-scheme="dark" data-mobile-nav-trigger-alignment="right" data-mobile-header-scheme="gray" data-mobile-logo-alignment="default" data-overlay-onmobile="false">
		
		<div id="wrap">

			<div class="lqd-sticky-placeholder hidden"></div>
			<header style="background:white;" class="site-header main-header sticky-header-noshadow main-header-dynamiccolors" data-sticky-header="true" data-sticky-values-measured="false" data-sticky-options='{"disableOnMobile":true,"stickyTrigger":"first-section","dynamicColors":true}'>
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
							<div class="header-module module-logo no-rotate navbar-brand-plain pt-25 pb-25">
								<a class="navbar-brand" href="index.php" rel="home">
									<span class="navbar-brand-inner">
										<img class="logo-light" src="https://images.ctfassets.net/5deddylq7ay4/6fDc8dxbuziV4fofcmlCmo/c4121c9a14d78c18961a6e2eeecdc363/SMC_Logo_2024.png" style="width:200px;" alt="Logo">
										<img class="logo-default" src="https://images.ctfassets.net/5deddylq7ay4/6fDc8dxbuziV4fofcmlCmo/c4121c9a14d78c18961a6e2eeecdc363/SMC_Logo_2024.png" style="width:200px;" alt="Logo">
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
				<div class="lqd-stickybar-wrap lqd-stickybar-left link-black link-medium pointer-events-none">
					<div class="lqd-stickybar w-full h-full relative vertical-rl overflow-visible flex justify-between">
						<div class="col lqd-head-col justify-center p-0">
							<div class="ld-module-sd header-module header-module-rotate ld-module-sd-hover no-rotate ld-module-sd-right py-10">
								<button class="nav-trigger style-2 fill-none flex p-0 border-none rounded-full relative pointer-events-auto bg-transparent text-black items-center justify-center transition-all txt-right collapsed header-sidedrawer horizontal-tb pl-40" type="button" data-ld-toggle="true" data-bs-toggle="collapse" data-toggle-options='{"type" : "hover"}' data-bs-target="#header-sidedrawer" aria-expanded="false" aria-controls="header-sidedrawer" data-lqd-interactive-color="true">
									<span class="bars">
										<span class="bars-inner w-full h-full flex rounded-inherit flex-col">
											<span class="bar relative bg-white transition-all"></span>
											<span class="bar relative bg-white transition-all"></span>
											<span class="bar relative bg-white transition-all"></span>
										</span>
									</span>
									<span style="color:white;" class="txt">CATALOGUE</span>
								</button>
								<div class="ld-module-dropdown collapse pointer-events-auto" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" id="header-sidedrawer" role="slider">
									<div class="ld-sd-wrap">
										<div class="w-full relative flex flex-wrap h-full justify-between -mr-15 -ml-15">
											
											<div class="w-full flex flex-auto flex-col items-start justify-center px-15">
												<div class="header-module no-rotate">
													<div class="lqd-fancy-menu lqd-custom-menu lqd-menu-td-none">
														<ul class="reset-ul" data-localscroll="true" data-localscroll-options='{"itemsSelector":"> li > a", "trackWindowScroll": true, "includeParentAsOffset": true}'>
															 <?php foreach ($uniqueCategories as $category): ?>
                                                                <li class="mb-15">
                                                                    <a href="#" class="category-link flex leading-1/5em hover:text-primary"  aria-current="page" data-category="<?= htmlspecialchars($category); ?>"><?= htmlspecialchars($category); ?></a>
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

			<main class="content bg-center-top bg-repeat z-2" id="lqd-site-content" style="background-image: url(./assets/images/demo/asymmetric-agency/bg-lines.svg);">
				<div id="lqd-contents-wrap">

				
				
				   
				
					<section class="lqd-section case-studies pt-70 pb-50" data-custom-animations="true" data-ca-options='{"animationTarget": ".lqd-split-lines .lqd-lines .split-inner, .animation-element", "duration" : 750, "startDelay" : 250, "delay" : 55, "ease": "expo.out", "initValues": {"y": "100px", "opacity" : 0}, "animations": {"y": "0px", "opacity" : 1}}'>
						<div class="container">
							<div class="row">
								<div class="col col-12 flex flex-col items-center text-center">
									
									<div class="ld-fancy-heading relative mask-text">
										<h2 style="color:white;" class="ld-fh-element mb-0/75em inline-block relative lqd-split-lines" data-split-text="true" data-split-options='{"type": "lines"}'></h2>
									</div>
								</div>
								<div class="col col-12">
								
								       
                                        <!-------------------------------------------------------- CODE ---------------------------------------------------------->
										<div id="productsContainer" class="lqd-pf-row row flex flex-wrap -mr-15 -ml-15" data-liquid-masonry="true" data-masonry-options='{ "filtersID":  "#pf-filter-case-studies" ,  "filtersCounter":  true }'>
										        
										        <div class="content bg-center-top bg-repeat z-2 bg-white" id="lqd-site-content" style="background-image: url(./assets/images/demo/asymmetric-agency/bg-lines.svg);">
                                    				<div id="lqd-contents-wrap">
                                    
                                    					<!-- Start About Us -->
                                    					<section class="lqd-section about-us pt-50 pb-50" data-section-luminosity="light">
                                    						<div class="container">
                                    							<div class="row items-center">
                                    								<div class="col col-12 col-md-8" data-custom-animations="true" data-ca-options='{"triggerHandler":"inview","animationTarget":"all-childs","duration":"1600","delay":"12","ease":"power4.out","direction":"forward","initValues":{"rotationX":75,"rotationY":10,"rotationZ":10,"transformOriginX":50,"transformOriginY":0,"opacity":0},"animations":{"rotationX":0,"rotationY":0,"rotationZ":0,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":1}}'>
                                    									<!--<h6 class="ld-fh-element lqd-split-lines mb-1/5em text-10 uppercase font-semibold tracking-0/1em text-black" data-split-text="true" data-split-options='{"type":"lines"}'> About Us</h6> -->
                                    									<h2 class="ld-fh-element lqd-split-chars pl-30 mb-0 text-36 font-medium leading-1/1em" data-split-text="true" data-split-options='{"type":"chars, words"}'>Gear up for a thrilling experience with our exclusive collection - meticulously curated for the high-octane world of moto events.</h2>
                                    								</div>
                                    								<div class="col col-12 col-md-3 " data-custom-animations="true" data-ca-options='{"triggerHandler":"inview","direction":"forward","initValues":{"y":30,"scaleY":1.1,"rotationX":21,"rotationZ":3,"transformOriginX":0,"transformOriginY":50,"transformOriginZ":"0px","opacity":0},"animations":{"y":0,"scaleY":1,"rotationX":0,"rotationZ":0,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":1}}'>
                                    									
                                    									<div class="lqd-counter lqd-counter-default mb-0 text-black text-end sm:text-start">
                                    										<div class="lqd-counter-element relative mb-0 text-120  font-bold" data-enable-counter="true" data-counter-options='{"targetNumber":"2201"}'>
                                    											<span>9</span>
                                    										</div>
                                    									</div>
                                    									<p class="ld-fh-element relative mb-0/5em ml-30percent text-16 leading-1em text-black"> Items in Catalogue</p>
                                    									
                                    								</div>
                                    							</div>
                                    						</div>
                                    					</section>
                                    					<!-- End About Us -->
                                    
                                    					<!-- Start Hero -->
                                    					<section class="lqd-section hero" id="banner" data-parallax="true" data-parallax-from='{"opacity":1}' data-parallax-to='{"opacity":0}' data-parallax-options='{"start":"top","end":"bottom top","staticSentinel":".lqd-css-sticky-wrap"}'>
                                    						<div class="row-bg-wrap inline-block absolute top-0 right-0 bottom-0 left-0 pointer-events-none overflow-hidden">
                                    							<div class="row-bg-inner inline-block absolute top-0 right-0 bottom-0 left-0 transition-all">
                                    								<figure class="row-bg absolute -top-5 -right-5 -bottom-5 -left-5 bg-no-reapet bg-cover bg-center" style="background-image: url(https://images.ctfassets.net/5deddylq7ay4/6wdsjEgj8wBo0xlIP9TWUg/1e964f417bbbe71783960c2b0e9e7d5d/Frame__3_.png);"></figure>
                                    							</div>
                                    						</div>
                                    						<div class="container">
                                    							<div class="row">
                                    								<div class="col col-12" data-custom-animations="true" data-ca-options='{"triggerHandler":"inview","animationTarget":"all-childs","duration":"1800","delay":"180","ease":"power4.out","direction":"forward","initValues":{"y":120,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":0},"animations":{"y":0,"transformOriginX":50,"transformOriginY":50,"transformOriginZ":"0px","opacity":1}}'>
                                    								</div>
                                    							</div>
                                    						</div>
                                    					</section>
                                    					<!-- End Hero -->
                                                        
                                                        
                                                        	<!-- Start Count -->
                                    					<section class="lqd-section team pt-60 pb-100" id="team" data-section-luminosity="light">
                                    						<div class="container">
                                    							<div class="row">
                                    								<div class="col col-12 col-md-4 col-xl-4 text-center">
                                    									<div class="lqd-counter lqd-counter-default pl-30 mb-0 text-black text-end sm:text-start">
                                    										<div class="lqd-counter-element relative mb-0 text-120 leading-0/5em font-bold" data-enable-counter="true" data-counter-options='{"targetNumber":"113001"}'>
                                    											<span>9</span>
                                    										</div>
                                    									</div>
                                    									<p class="ld-fh-element relative mb-0/5em ml-30percent text-16 leading-1em text-black">Total Number of Products</p>
                                    								</div>
                                    								<div  class="col col-12 col-md-4 col-xl-2 offset-md-4 text-center">
                                    									<div class="lqd-counter lqd-counter-default mb-0 text-black text-end sm:text-start">
                                    										<div class="lqd-counter-element relative mb-0 text-120 leading-0/5em font-bold" data-enable-counter="true" data-counter-options='{"targetNumber":"29"}'>
                                    											<span>9</span>
                                    										</div>
                                    									</div>
                                    									<p class="ld-fh-element relative mb-0/5em ml-30percent text-16 leading-1em text-black"> Categories</p>
                                    								</div>
                                    								
                                    							</div>
                                    						</div>
                                    					</section>
                                    					<!-- End Count -->
                                    					
                                    	
									                </div>
									            </div>
								        </div>
							    </div>
						    </div>
					    </div>
					</section>
					
                

                    

				
                    
                    
                 

				</div>
			</main>
        
        
        
        
        
        
                                        
		</div>
		
		                      
		                      
		                      
		
	        
	        
	        
        
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
        <script>
        
           document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('.category-link').forEach(function(item) {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        var selectedCategory = this.getAttribute('data-category');
            
                        // Update the heading dynamically based on the selected category
                        var headingElement = document.querySelector('.ld-fancy-heading h2');
                        if (headingElement) {
                            headingElement.textContent = selectedCategory; // Change 'Furnitures' to the selected category
                        }
            
                        fetch(`load_products.php?category=${encodeURIComponent(selectedCategory)}`)
                            .then(response => response.json())
                            .then(data => {
                                const productsContainer = document.querySelector('#productsContainer');
                                productsContainer.innerHTML = ''; // Clear current products
            
                                data.forEach(product => {
                                    // Ensure that missing data is handled gracefully
                                    const description = product.description ? product.description : 'No description available';
                                    const imageSrc = product.images ? product.images : 'path/to/default/image.png'; // Replace with your default image path if necessary
                                    const name = product.name ? product.name : 'Unnamed Product';
                                    const ref = product.internal_reference ? product.internal_reference : 'No Ref';
                                    const quantity = product.stock_quantity ? product.stock_quantity : '0';
                                    const unit = product.product_unit ? product.product_unit : 'units';
            
                                    const productHTML = `
                                        <div class="lqd-pf-column col-12 col-md-3 col-lg-3 px-15 masonry-item digital-design ecommerce portfolio-single">
                                            <article class="lqd-pf-item lqd-pf-item-style-6 px-1em pb-1em pt-1/6em lqd-pf-dark post-3869 liquid-portfolio type-liquid-portfolio status-publish format-standard has-post-thumbnail hentry liquid-portfolio-category-digital-design liquid-portfolio-category-ecommerce liquid-portfolio-category-portfolio-single">
                                                <div class="lqd-pf-item-inner">
                                                    <a href="${imageSrc}" class="fresco" >
                                                    <div class="lqd-pf-img mb-1em relative rounded-10 overflow-hidden product_image">
                                                        
                                                                <img style="height:250px; width:none; max-width:none; " src="${imageSrc}" alt="case studies">
                                                            
                                                        <span class="lqd-pf-overlay-bg lqd-overlay flex items-center justify-center bg-transparent" style="background-image: linear-gradient(180deg, #675DE100 0%, #284541 100%);"></span>
                                                    </div>
                                                    </a>
                                                    <div class="lqd-pf-details">
                                                        <div class="flex justify-between">
                                                            <h3 class="lqd-pf-title mt-0 items-center">${name}</h3>
                                                        </div>
                                                        <ul class="reset-ul inline-nav" style="font-size:14px;">
                                                            <li><a href="#">Ref : ${ref}</a></li></br>
                                                            <li><a href="#">Quantity : ${quantity} ${unit}</a></li></br>
                                                            <li><a href="#">${description}</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    `;
                                    productsContainer.innerHTML += productHTML;
                                });
                            })
                            .catch(error => console.error('Error loading products:', error));
                    });
                });
            });

        </script>
		


	













</body>
</html>
