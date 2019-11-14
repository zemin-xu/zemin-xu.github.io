(function($){

    "use strict"; 
	
	var themeData                    = [];
	var parallaxImages               = [];
	
	//window
	themeData.win                    = $(window);
	themeData.winHeight              = themeData.win.height();
	themeData.winScrollTop           = themeData.win.scrollTop();
	themeData.winHash                = window.location.hash.replace('#', '');
	themeData.stateObject            = {};
	
	//document
	themeData.doc                    = $(document);
	themeData.docHeight              = themeData.doc.height();

	//ID A~Z
	themeData.backTop                = $('#back-top');
	themeData.footer                 = $('#footer');
	themeData.headerWrap             = $('#header');
	themeData.header                 = $('#header-main');
	themeData.MenuOverPanel          = $('#mobile-panel');
	themeData.MenuOverTrigger        = $('#navi-trigger');
	themeData.jplayer                = $('#jquery_jplayer');
	themeData.logo                   = $('.navi-logo'); 
	themeData.navi                   = $('#navi'); 
	themeData.container              = $('#wrap');
	themeData.WrapOurter             = $('#wrap-outer');
	themeData.searchOpen             = $('.search-top-btn-class');
	themeData.socialHeader           = $('#social-header-out'); 
	themeData.contentWrap            = $('#content_wrap');
	themeData.TopsliderTrggleDown    = $('#ux-slider-down');

	//tag
	themeData.body                   = $('body');
	
	//tag class
	themeData.carousel               = $('.owl-carousel');
	themeData.uxResponsive           = $('body.responsive-ux');
	themeData.headerNaviMenu         = themeData.header.find('#navi ul.menu');
	themeData.galleryCollage         = $('section.Collage');
	themeData.pageCover	             = $('.post-cover');
	themeData.audioUnit              = $('.audio-unit');
	themeData.pageLoading            = $('.page-loading'); 
	themeData.lightboxPhotoSwipe     = $('.lightbox-photoswipe');
	themeData.Menu                   = $('.menu');
	themeData.pagenumsDefault        = $('.pagenums-default'); 
	themeData.tooltip                = $('.tool-tip');
	themeData.searchForm             = $('.search-overlay-form');
	themeData.titlecon               = $('.title-wrap-con');
	themeData.isotope                = $('.container-masonry');
	themeData.isotope_filter         = themeData.isotope.find('.filters');
	
	themeData.videoFace              = $('.blog-unit-img-wrap, .archive-item');
	themeData.videoOverlay           = $('.video-overlay');
	
	themeData.blogPagenumsTwitter    = $('.blog-list .pagenums.page_twitter a');
	themeData.blogPagenumsSelect     = $('.blog-list .pagenums .select_pagination, .magzine-list .pagenums .select_pagination');
	
	themeData.listLayout             = $('.list-layout');
	themeData.singleGalleryListWrap  = $('.ux-portfolio-ajaxed-list-wrap');
	themeData.singleGalleryList      = $('.ux-portfolio-ajaxed-list');
	themeData.singleGalleryGoBack    = $('.post-navi-go-back-a');
	
	themeData.sectionCusl            = $('.cusl-style-unit-inn');
	themeData.sectionCuslList        = $('.cusl-style-list'); 
	
	themeData.gridStack              = $('.grid-stack');
	
	//define
	themeData.globalFootHeight       = 0;
	themeData.itemParallax           = [];
	themeData.gridStackItems         = []; 

	var resizeTimer = null;
	
	//condition
	themeData.isResponsive = function(){
		if(themeData.uxResponsive.length){
			return true;
		}else{
			return false;
		} 
	}
	
	var switchWidth = 767;
	
	
	themeData.isMobile = function(){
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || themeData.win.width() < switchWidth){
			return true; 
		}else{
			return false;
		}
	}

	var ios = navigator.userAgent.match(/(iPod|iPhone|iPad)/);

	function get_browser(){
	    var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
	    if(/trident/i.test(M[1])){
	        tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
	        return {name:'IE',version:(tem[1]||'')};
	        }   
	    if(M[1]==='Chrome'){
	        tem=ua.match(/\bOPR\/(\d+)/)
	        if(tem!=null)   {return {name:'Opera', version:tem[1]};}
	        }   
	    M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
	    if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
	    return {
	      name: M[0],
	      version: M[1]
	    };
	}

	var ux_browser = get_browser();

	themeData.body.addClass(ux_browser.name + ux_browser.version);
	

	//Function 

	// Top slider Triggle Down Click
	themeData.TopsliderTrggleDownFn = function(){

		var _win_real_h = themeData.win.height();

		themeData.TopsliderTrggleDown.on({'touchstart click': function(){ 
			$('html, body').animate({scrollTop:_win_real_h}, 400);
		}});
	}

	//Calc Fullscreen wrap / slider Height  
	themeData.fnFullscreenWrapHeight = function(){ 
		if (!Modernizr.cssvhunit) {
			if($('.fullscreen-wrap').length) {
				$('.fullscreen-wrap').each(function(){
					$(this).css('height',themeData.win.height());
				});
			}
		}
	}

	// Page Cover Activated Scrolled
	themeData.CoverScroll = function(){
		if(themeData.pageCover.length || themeData.body.hasClass('single-portfolio-bigtitle')) {
			if(themeData.pageCover.hasClass('fullscreen-wrap') || $('.title-wrap').hasClass('fullscreen-wrap')) {
				themeData.doc.on('mousewheel DOMMouseScroll MozMousePixelScroll', function (e) {
					if(themeData.win.scrollTop() == 0){
						e.preventDefault();
						var _deltaY = e.originalEvent.detail < 0 || e.originalEvent.wheelDelta > 0 ? 1 : -1;
						console.log(_deltaY)
						if (_deltaY < 0) {
							 $('html, body').animate({scrollTop:themeData.winHeight}, 500);
						}  
						
					}
				}); 
			}
		}
	}


	// Top slider
	themeData.carouselFn = function(carouselWrap){

		carouselWrap.each(function(){

			var 
			_carousel 	= $(this),
			_margin   	= $(this).data('margin'),
			_center   	= $(this).data('center'),
			_item    	= $(this).data('item'),
			_autoW   	= $(this).data('autowidth'),
			_slideby  	= $(this).data('slideby'),
			_auto    	= $(this).data('auto'),
			_showdot  	= $(this).data('showdot'),
			_shownav  	= $(this).data('nav'),
			_animateIn 	= $(this).data('animatein'),
			_animateOut = $(this).data('animateout'),
			_loop		= $(this).data('loop'),
			_lazyLoad   = $(this).data('lazy');

			//$(this).find('img').imagesLoaded(function(){
				setTimeout(function(){
					if(_lazyLoad){
						if(themeData.body.hasClass('single-portfolio-fullwidth-slider')){
							_carousel.on('refreshed.owl.carousel', function (e) {
								_carousel.find('.owl-item').each(function(){ 
									if($(this).hasClass('cloned')){
										var data_src = $(this).find('img').data('src');
										$(this).find('img').attr('src', data_src);
									}
								});
							});
						}
					}
					
					_carousel.owlCarousel({
					    margin: _margin,
					    loop: _loop,
					    autoWidth:_autoW,
					    center: _center,
					    animateIn: _animateIn,
					    animateOut: _animateOut,
					    slideSpeed : 300,
			            paginationSpeed : 400,
					    items: _item,
					    autoplay: _auto,
					    responsiveClass:true,
					    navText:["",""],
					    slideBy:_slideby,
					    dots:_showdot, 
					    nav:_shownav,
					    responsive:{
					        0:{
					            items:_item,
					            nav:_shownav
					        },
					        480:{
					            items:_item,
					            nav:_shownav
					        },
					        769:{
					            items:_item,
					            nav:_shownav 
					        }
					    }
					});

					// BM Slider - Text color changed auto based on BGimage(Featured Image)
					if(themeData.body.hasClass('page-template-only-slider-body')) {

						var _default_logo = 'dark-logo',
						_first_logo =  _carousel.find('.item.active').data('color'); 

						if(themeData.body.hasClass('light-logo')) {
							_default_logo = 'light-logo';
						}

						if(_default_logo != _first_logo) {
							_default_logo = _first_logo;
							themeData.body.removeClass(_default_logo).addClass(_first_logo);
						}

						_carousel.on('changed.owl.carousel', function(event) {
							var _current_item = event.item.index + 1,
							    _section = _carousel.find('.owl-item:nth-child('+_current_item+')').find('section'),
							    _logo_color = _section.attr('data-color');
								 
							if(_default_logo != _logo_color) {
						  		themeData.body.removeClass(_default_logo).addClass(_logo_color);
						 		_default_logo = _logo_color;
						 	}
						});
					}
					

					if(themeData.body.hasClass('single-portfolio-fullscreen-slider') || themeData.body.hasClass('page-template-only-slider-body')){
						_carousel.on('mousewheel DOMMouseScroll', '.owl-stage', function (e) {
							if(themeData.win.scrollTop() == 0){
								e.preventDefault();
								var _deltaY = e.originalEvent.detail < 0 || e.originalEvent.wheelDelta > 0 ? 1 : -1;
								if (_deltaY > 0) {
									_carousel.trigger('prev.owl');
									
								} else {
									_carousel.trigger('next.owl'); 
								}
							}
						});
					}
					
					if(_lazyLoad){
						_carousel.on('translated.owl.carousel', function(event){
							if(Number(_item) > 1){
								var current_items = $(event.target).find('.owl-item.active, .owl-item.cloned');
								current_items.each(function(){
                                    var current_item = $(this);
									var current_item_img = current_item.find('img');
									var current_item_img_bg = current_item_img.attr('data-src');
									
									if(current_item_img_bg){
										current_item_img.addClass('lazy-loaded').attr('src', current_item_img_bg);
										current_item_img.removeAttr('data-src');
									}
                                });
							}else{
								var current_item = $(event.target).find('.owl-item.active');
								var current_item_img = current_item.find('.carousel-img-wrap');
								var current_item_img_bg = current_item_img.attr('data-bg');
								
								if(current_item_img_bg){
									current_item_img.addClass('lazy-loaded').css('background-image', 'url("' +current_item_img_bg+ '")');
									current_item_img.removeAttr('data-bg');
								}
							}
						})
					}

				},10)
				
			//});

		});
	}

	// BM Slider - Fullscreen Tab Slider
	themeData.fnBMTabSlider = function(){

		var _default_logo   =   'dark-logo',
		    _first_logo     =   $('.bm-tab-slider-trigger-item:first-child').find('.bm-tab-slider-trigger-tilte').data('color'); 

		if(themeData.body.hasClass('light-logo')) {
			_default_logo = 'light-logo';
		}

		if(_default_logo != _first_logo) {
			_default_logo = _first_logo;
			themeData.body.removeClass(_default_logo).addClass(_first_logo);
		}
		
		if(Modernizr.touchevents){

			$('.bm-tab-slider-trigger-tilte').on('touchstart', function(e) {
				var _item 		= 	jQuery(this),
				     _id 		= _item.data('id'),
			  		_logo_color = _item.data('color'); 

			  	if(_default_logo != _logo_color) {
			  		themeData.body.removeClass(_default_logo).addClass(_logo_color);
			  		_default_logo = _logo_color;
			  	}

			  	if( !_item.parents('.bm-tab-slider-trigger').siblings('.bm-tab-slider-img').find('#'+_id).hasClass('bm-active') ) {
					_item.parents('.bm-tab-slider-trigger').siblings('.bm-tab-slider-img').find('#'+_id).addClass('bm-active');
					_item.parents('.bm-tab-slider-trigger').siblings('.bm-tab-slider-img').find('#'+_id).siblings('.bm-tab-slider-img-item').removeClass('bm-active');
				}

				if(!_item.hasClass('bm-active')) {
					_item.addClass('bm-active');
					_item.parent('.bm-tab-slider-trigger-item').siblings().find('.bm-tab-slider-trigger-tilte').removeClass('bm-active');
					e.preventDefault();
					return false;
				}
				
			});

		} else {

			$('.bm-tab-slider-trigger-tilte').hover(function(){  
				var _item 		= 	jQuery(this),
				     _id 		= _item.data('id'),
			  		_logo_color = _item.data('color');

			  	if(_default_logo != _logo_color) {
			  		themeData.body.removeClass(_default_logo).addClass(_logo_color);
			  		_default_logo = _logo_color;
			  	}

				if(!_item.hasClass('bm-active')) {
					_item.addClass('bm-active');
					_item.parent('.bm-tab-slider-trigger-item').siblings().find('.bm-tab-slider-trigger-tilte').removeClass('bm-active');
				}

				if( !_item.parents('.bm-tab-slider-trigger').siblings('.bm-tab-slider-img').find('#'+_id).hasClass('bm-active') ) {
					_item.parents('.bm-tab-slider-trigger').siblings('.bm-tab-slider-img').find('#'+_id).addClass('bm-active');
					_item.parents('.bm-tab-slider-trigger').siblings('.bm-tab-slider-img').find('#'+_id).siblings('.bm-tab-slider-img-item').removeClass('bm-active');
				}

			},function(){
				return false;
			});

		}
		
	}

	// BM Slider - Idel
	var bmslider_timer;

	themeData.fnBMsliderIdel = function(){
		
		var bmslider_timer; 
	    // DOM Events
	    document.onmousemove = themeData.resetTimer;
	    document.onkeypress = themeData.resetTimer;
	    document.onmousedown = themeData.resetTimer; 
	    document.ontouchstart = themeData.resetTimer;
		document.onclick = themeData.resetTimer;
		document.onscroll = themeData.resetTimer; 
	}

	themeData.logout = function() {
		if($('.owl-carousel').length) {

			var _if_idel = $('.owl-carousel').data('idel');

			if(_if_idel == '1') {
				if(!themeData.body.hasClass('bmslider-hide-thing')){
					themeData.body.addClass('bmslider-hide-thing');
				}
			}

			var _if_idel_logo = $('.owl-carousel').data('idellogo');

			if(_if_idel_logo == '1') {
				if(!themeData.body.hasClass('bmslider-hide-logo')){
					themeData.body.addClass('bmslider-hide-logo');
				}
			}
		}
		
    } 

	themeData.resetTimer = function() {
		if(themeData.body.hasClass('bmslider-hide-thing')){
    		themeData.body.removeClass('bmslider-hide-thing');
    	}
    	if(themeData.body.hasClass('bmslider-hide-logo')){
    		themeData.body.removeClass('bmslider-hide-logo');
    	}
        clearTimeout(bmslider_timer);
        bmslider_timer = setTimeout(themeData.logout, 3000);
    }


	//Search show
	themeData.fnSerchShow = function(){

		var 
		_search_btn = themeData.searchOpen.find('.fa-search'),
		_search_form = _search_btn.siblings('form');

		_search_btn.click(function(){

			if(_search_form.hasClass('search_top_form_shown')){
				_search_form.removeClass('search_top_form_shown');
				_search_form.find('.search_top_form_text').blur();
				$('.menu-panel-bottom-right').css('opacity','1');
			} else {
				_search_form.addClass('search_top_form_shown');
				_search_form.find('.search_top_form_text').focus();
				$('.menu-panel-bottom-right').css('opacity','0');
			}
			return false;
			 
		});

	}

	//Responsive Mobile Menu function
	themeData.fnResponsiveMenu = function(){ 
						
		if(themeData.win.width() > switchWidth) {
			themeData.body.removeClass('ux-mobile');
		} else {
			themeData.body.addClass('ux-mobile');
		}
		
		themeData.win.resize(function(){
			
			if(themeData.win.width() > switchWidth) {
				themeData.body.removeClass('ux-mobile');
			} else {
				themeData.body.addClass('ux-mobile');
			}

		});

		if(themeData.MenuOverTrigger.length){
			themeData.MenuOverTrigger.velocity("transition.fadeIn");
		}

		var $post_logo_color = false;

		if(themeData.body.hasClass('light-logo')){
			$post_logo_color = 'light-logo';
		} else if(themeData.body.hasClass('dark-logo')){
			$post_logo_color = 'dark-logo';
		}  

		themeData.MenuOverTrigger.click(function(){

			if(themeData.body.is('.show_mobile_menu')){

				setTimeout(function() {
					if(themeData.body.hasClass('show_mobile_menu')) {
						themeData.body.removeClass('show_mobile_menu');
					}

					setTimeout(function() { 
						themeData.body.addClass($post_logo_color);
					},1000);
					
					if($('#navi-wrap .sub-menu').length) {
						$('#navi-wrap .sub-menu').velocity("transition.fadeOut");
						$('#navi-wrap .sub-menu').siblings('a').css('display','inline-block');
						$('#navi-wrap > ul > li').velocity("transition.fadeIn"); 
					}

					if(themeData.body.hasClass('navi-show-icon')){
						if($('.heade-meta').is(":visible")) {
							$('.heade-meta').velocity("transition.slideLeftOut"); 
						}
					}

				},10);

			}else{

				setTimeout(function() {
					if(!themeData.body.hasClass('show_mobile_menu')) {
						if(themeData.win.scrollTop() > 1){
							$('html, body').animate({scrollTop:0}, 200,function(){
								themeData.body.addClass('show_mobile_menu');
							});
						} else {
							themeData.body.addClass('show_mobile_menu');
						}
					}

					setTimeout(function() { 
						if(themeData.body.hasClass('light-logo')){
							themeData.body.removeClass('light-logo');
						}
						if(themeData.body.hasClass('dark-logo')){
							themeData.body.removeClass('dark-logo');
						}
					},1000);

					if(themeData.body.hasClass('navi-show-icon')){
						if(!$('.heade-meta').is(":visible")) {
							$('.heade-meta').velocity("transition.slideLeftIn"); 
						}
					}

				},10); 
			}
			return false;
        });
 		
		//var timer;

        window.addEventListener('scroll', function() {

			if(themeData.body.is('.show_mobile_menu')){
				if(themeData.win.scrollTop() > 500){
					setTimeout(function() { 
						themeData.body.addClass($post_logo_color);
					},1000);
					setTimeout(function() {
						themeData.body.removeClass('show_mobile_menu'); 

						if($('#navi-wrap .sub-menu').length) {
							$('#navi-wrap .sub-menu').velocity("transition.fadeOut");
							$('#navi-wrap .sub-menu').siblings('a').css('display','inline-block');
							$('#navi-wrap > ul > li').velocity("transition.fadeIn"); 
						}
					},10);
				}
			} 
        }, false);

		if(themeData.navi.length) {
			themeData.fnSubMenu($('#menu-panel .menu'));
		}

		if($('.navi-show-v #header .menu').length) {
			themeData.fnSubMenu($('.navi-show-v #header .menu > .menu-level1:not(.menu-filter) > ul'));
		}
	
    }

    //Back top
	themeData.fnBackTop = function(){
		
		themeData.win.find('img').imagesLoaded(function(){

			themeData.win.scroll(function(){

				if(themeData.win.scrollTop() > 200){
					if(!themeData.backTop.hasClass('backtop-shown')) {
					 	themeData.backTop.addClass('backtop-shown');
					}
				} else {
					if(themeData.backTop.hasClass('backtop-shown')) {
					 	themeData.backTop.removeClass('backtop-shown');
					}
				}

			});

			var BacktopBottom = themeData.footer.find('.footer-info').height() - 50;
			//themeData.backTop.css('bottom',BacktopBottom);

		});

	}

    //Video cover title show & hide
	themeData.fnVideocoverTitle = function(){
		
		themeData.win.scroll(function(){
			themeData.winScrollTop = themeData.win.scrollTop();
			if(themeData.winScrollTop > 100){
				if(!themeData.titlecon.hasClass('witle-wrap-con-shown')) {
				 	themeData.titlecon.addClass('witle-wrap-con-shown');
				}
				
			}else{
				if(themeData.titlecon.hasClass('witle-wrap-con-shown')) {
					themeData.titlecon.removeClass('witle-wrap-con-shown');
				}
				
			}
		});
	}
	
	
	//audio player function
	themeData.fnJplayerCall = function(){
		if(themeData.jplayer.length){
			themeData.jplayer.jPlayer({
				ready: function(){
					$(this).jPlayer("setMedia", {
						mp3:""
					});
				},
				swfPath: JS_PATH,
				supplied: "mp3",
				wmode: "window"
			});
			
			$('.audiobutton').each(function(){
                themeData.fnAudioPlay($(this));
            });
		}
	}
	
	//call player play
	themeData.fnAudioPlay = function(el){
		el.click(function(){
			var thisID = $(this).attr("id");
			if($(this).hasClass('pause')){
				$('.audiobutton').removeClass('play').addClass('pause');
				$(this).removeClass('pause').addClass('play');
				themeData.jplayer.jPlayer("setMedia", {
					mp3: $(this).attr("rel")
				});
				themeData.jplayer.jPlayer("play");
				themeData.jplayer.bind($.jPlayer.event.ended, function(event) {
					$('#'+thisID).removeClass('play').addClass('pause');
				});
			}else if($(this).hasClass('play')){
				$(this).removeClass('play').addClass('pause');
				themeData.jplayer.jPlayer("stop");
			}
		});
	}
	
	//video face
	themeData.fnVideoFace = function(arrayVideo){
		arrayVideo.each(function(){
			var videoFace = [];
			var videoOverlay = [];
			
			videoFace.item = $(this);
			videoFace.playBtn = videoFace.item.find('.blog-unit-video-play');
			videoFace.videoWrap = videoFace.item.find('.video-wrap');
			videoFace.videoIframe = videoFace.videoWrap.find('iframe');
			
			videoOverlay.item = themeData.videoOverlay;
			videoOverlay.videoWrap = videoOverlay.item.find('.video-wrap');
			videoOverlay.close = videoOverlay.item.find('.video-close');
			
			videoFace.playBtn.click(function(){
				var src = videoFace.videoIframe.attr('data-src').replace('autoplay=0', 'autoplay=1');
				videoFace.videoIframe.attr('src', src);
				videoOverlay.close.before(videoFace.videoWrap.removeClass('hidden').attr('style', 'height:100%;padding-bottom:0px;'));
				videoOverlay.item.addClass('video-slidedown'); 
				return false;
			});
			
			videoOverlay.close.click(function(){
				videoOverlay.item.removeClass('video-slidedown');
				videoOverlay.item.find('.video-wrap').remove(); 
				return false;
			});
		});
	}
	
	//Module Load Ajax
	themeData.fnModuleLoad = function(data, container){
		$.post(AJAX_M, {
			'mode': 'module',
			'data': data
		}).done(function(content){ 
			var newElems = $(content); 
			switch(data['mode']){
				case 'pagenums': 
					var this_pagenums = container.find('a[data-post=\"'+data["module_post"]+'\"][data-paged=\"'+data["paged"]+'\"]');
					
					this_pagenums.text(data["paged"]);
					$('html,body').animate({
						scrollTop: container.parent().offset().top - 80
					},
					1000); 
	
					container.parent().find('section').remove();
					container.before(newElems);
				break;
				case 'twitter': 
					var this_twitter = container.find('a[data-post=\"'+data["module_post"]+'\"]');
					var pagination_text = this_twitter.parent('.page_twitter').data('pagetext');
	
					this_twitter.attr('data-paged',Number(data['paged']) + 1).text(pagination_text).removeClass('tw-style-loading');
	
					if(data['paged'] == this_twitter.data('count')){
						this_twitter.fadeOut(300);
						this_twitter.parent('.page_twitter').css('margin-top','0');
					}
	
					container.before(newElems);
				break;
			}
			
			//Fadein theitems of next page 
			newElems.animate({opacity:1}, 1000); 
			
			//gallery
			themeData.gallerycarousel = $('.blog-gallery-carousel');
			if(themeData.gallerycarousel.length){
				themeData.fnGalleryCarousel();
			}
			
			if(newElems.find('.audio_player_list').length){	
	
				//Audio player
				//themeData.fnJplayerCall();
				newElems.find('.audiobutton').each(function(){
					themeData.fnAudioPlay($(this));
				});
				themeData.jplayer.jPlayer("stop");
			
			}
			
			//Video play
			if(newElems.find('.blog-unit-video-play').length){
				themeData.fnVideoFace(newElems.find('.blog-unit-img-wrap'));
				themeData.fnVideoFace(newElems.find('.archive-item'));
			}
	
			//gallery list
			if(newElems.find('.Collage').length){
				$('.Collage').imagesLoaded(function(){ 
					$('.Collage').collagePlus({
						'fadeSpeed'     : 2000,
						'targetHeight'  : 200
					});
				});
			}
			
			//call carousel
			if(newElems.find('.owl-carousel').length){
				themeData.carouselFn(newElems.find('.owl-carousel'));
			}
	
		});
	}
	
	//gallery collage
	themeData.fnGalleryCollage = function(collageWrap){
		collageWrap.collagePlus({
			'fadeSpeed'     : 2000,
			'targetHeight'  : 200
		});
	}
	 
	
	//List Layout Height
	themeData.fnListLayoutHeight = function(){
		themeData.listLayout.find('.list-layout-col2, .list-layout-col3, .list-layout-col4').each(function(){
			var layoutGetmin = new Array();
			var changeColWidthSum = 0;
			var base = 1;
			var lastWidthSum = 0;
			var colItems = $(this).find('.list-layout-item');
			var colWidth = $(this).width();
			var colCount = colItems.length;
			var colGap = Number(themeData.listLayout.data('gap'));

			colItems.each(function(){
				
				var thisWidth = $(this).width();
				
                layoutGetmin.push(Number($(this).find('img').attr('height')));
				if(colWidth != thisWidth){
					colWidth = colWidth - colGap;
				}
            }); 
			
			var itemHeight = eval("Math.min("+layoutGetmin.toString()+")");
			colItems.each(function(index){
				var imgWidth = parseFloat(Number($(this).find('img').attr('width')));
				var imgHeight = parseFloat(Number($(this).find('img').attr('height')));
				var imgBase = itemHeight / imgHeight;
				
				imgWidth = imgWidth * imgBase;
				imgHeight = itemHeight;
				
				changeColWidthSum = changeColWidthSum + imgWidth;
			});
			
			base = colWidth / changeColWidthSum;
			
			colItems.each(function(){
				var imgWidth = parseFloat(Number($(this).find('img').attr('width')));
				var imgHeight = parseFloat(Number($(this).find('img').attr('height')));
				var imgBase = itemHeight / imgHeight;
				var thisWidth = $(this).width();
				
				imgWidth = (imgWidth * imgBase) * base; 
				imgHeight = itemHeight * base;
				
				if(colWidth != thisWidth){
					$(this).css('width', 'auto');
					
					$(this).find('.ux-lazyload-wrap').css({
						'width': imgWidth,
						'height': imgHeight,
						'overflow': 'hidden'
					});
					
					$(this).find('img').css({
						'width': '100%',
						'height': 'auto'
					});
					
					lastWidthSum = lastWidthSum + imgWidth;
					if(Math.round(lastWidthSum) > colWidth){
						$(this).find('.ux-lazyload-wrap').width(imgWidth - (lastWidthSum - colWidth));
					}else if(Math.round(lastWidthSum) == colWidth){
						$(this).find('.ux-lazyload-wrap').css({
							'width': imgWidth - 1
						});
					}
				}else{
					$(this).find('.ux-lazyload-wrap').css({
						'width': 'auto',
						'height': 'auto',
						'overflow': 'hidden'
					});
				}
			});
		});
	}

	//Isotope
	themeData.isotopelist = function(){

		themeData.isotope.each(function(){

			var _this_wrap 	  = $(this),
				_this 		  = $(this).find('.masonry-list'),
				_this_wrap_st = $(this).scrollTop(),
				_this_wrap_pt = $(this).attr('data-template');

			if(_this.hasClass('grid-list')) {

				var $iso_list =  _this.isotope({
					itemSelector: '.grid-item',
					layoutMode: 'fitRows',
					stagger: 40,
					hiddenStyle: {
					  opacity: 0
					},
					visibleStyle: {
					  opacity: 1
					}
				});

			} else { 
				var $iso_list =  _this.isotope({ 
					itemSelector: '.grid-item',
					layoutMode: 'packery',
					stagger: 40,
					hiddenStyle: {
					  opacity: 0
					},
					visibleStyle: {
					  opacity: 1
					}
				}); 
			}
			
			//call page load more
			if(_this_wrap.find('.ux-page-load-more').length){
				var loadBtn = _this_wrap.find('.ux-page-load-more');
				var postID = loadBtn.attr('data-pageid');
				var postMAX = loadBtn.attr('data-max');
				var pageText = loadBtn.parent().attr('data-pagetext');
				var loadingText = loadBtn.parent().attr('data-loadingtext');

				loadBtn.click(function(){
					var paged = loadBtn.attr('data-paged');
					var filters = _this_wrap.find('.filters');
					var filterActive = filters.find('li.active');
					var filterValue = filterActive.find('> a').attr('data-filter');
					var catID = filterActive.find('> a').attr('data-catid');
					var postCount = Number(filterActive.find('.filter-num').text());
					
					if(filterValue == '*'){
						catID = 0;
					}
					
					var post__not_in = [];
					$iso_list.find('section').each(function(){
						var section_postid = $(this).attr('data-postid');
						if(filterValue != '*'){
							if($(this).is(filterValue)){
								post__not_in.push(section_postid);
							}
						}else{
							post__not_in.push(section_postid);
						}
					});
					
					loadBtn.text(loadingText);

					if(!_this.hasClass('loading-more')){
						_this.addClass('loading-more');
						$.post(ajaxurl, {
							'action': 'arnold_interface_page_ajax_filter',
							'cat_id': catID,
							'post_id': postID,
							'post__not_in': post__not_in,
							'paged': paged
						}).done(function(content){
							var content = $(content);
							$iso_list.isotope('insert', content);
							if(_this.hasClass('masonry-grid')) {
								themeData.isotopelistResize(_this, _this_wrap);
								$iso_list.isotope('layout');
							}
							
							loadBtn.text(pageText);
							_this.removeClass('loading-more');
							
							var thisPostCount = $iso_list.find('section').length;
							if(filterValue != '*'){
								thisPostCount = $iso_list.find('section' +filterValue).length;
							}
							
							if(_this_wrap_pt == 'blog-masonry'){
								var paged_num = Number(paged) + 1;
								loadBtn.attr('data-paged', paged_num);
								
								if(paged_num > Number(postMAX)){
									loadBtn.parent().hide();
								}
							}else{

								if(thisPostCount >= postCount){
									loadBtn.parent().hide();
								}else{
									loadBtn.parent().show();	
								}
							}
							
							setTimeout(function() {
								$(window).lazyLoadXT(); 
								content.find('.grid-item-inside').each(function(){
									itemQueue.push($(this));
									fnListItemQueue();
								});
								//themeData.fnJplayerCall();
								content.find('.audiobutton').each(function(){
									themeData.fnAudioPlay($(this));
								});
							}, 10); 
						});
					}
					
					return false;
				});
			}
			
			//call infiniti scroll
			if(_this.hasClass('infiniti-scroll')){
				var postID = _this.attr('data-pageid');
				var postMAX = _this.attr('data-max');
				
				var waypoints = _this.waypoint({
					handler: function(direction){
						var paged = _this.attr('data-paged');
						var filters = _this_wrap.find('.filters');
						var filterActive = filters.find('li.active');
						var filterValue = filterActive.find('> a').attr('data-filter');
						var catID = filterActive.find('> a').attr('data-catid');
						var postCount = Number(filterActive.find('.filter-num').text());
						
						var post__not_in = [];
						$iso_list.find('section').each(function(){
							var section_postid = $(this).attr('data-postid');
							if(filterValue != '*'){
								if($(this).is(filterValue)){
									post__not_in.push(section_postid);
								}
							}else{
								post__not_in.push(section_postid);
							}
						});
						
						if(!_this.hasClass('infiniti-scrolling')){
							_this.addClass('infiniti-scrolling');
							$.post(ajaxurl, {
								'action': 'arnold_interface_page_ajax_filter',
								'cat_id': catID,
								'post_id': postID,
								'post__not_in': post__not_in,
								'paged': paged
							}).done(function(content){
								var content = $(content);
								$iso_list.isotope('insert', content);
								if(_this.hasClass('masonry-grid')) {
									themeData.isotopelistResize(_this, _this_wrap);
									
									$iso_list.isotope('layout');
								}
								
								_this.removeClass('infiniti-scrolling');
								
								setTimeout(function() {
									$(window).lazyLoadXT();
									content.find('.grid-item-inside').each(function(){
										itemQueue.push($(this));
										fnListItemQueue();
									});
									//themeData.fnJplayerCall();
									content.find('.audiobutton').each(function(){
										themeData.fnAudioPlay($(this));
									});
								}, 10);
							});
						}
					},
					offset: 'bottom-in-view'
				})
			}
			
			if($('[data-filter]').length) {
				var _filters = $('[data-filter]');
				var loadBtn = _this_wrap.find('.ux-page-load-more');
				
				_filters.on( 'click', function() {
					var filterValue = $( this ).attr('data-filter');
					var filterClick = $( this );
					
					$iso_list.isotope({ filter: filterValue }); 
					jQuery(this).parent().parent().find('li').removeClass('active');
					jQuery(this).parent().addClass('active');
					
					var postID = $(this).attr('data-pageid');
					var postCount = Number($(this).find('.filter-num').text());
					var catID = $(this).attr('data-catid');
					
					var post__not_in = [];
					if(filterValue != '*'){
						$iso_list.find('section').each(function(){
							var section_postid = $(this).attr('data-postid');
							if($(this).is(filterValue)){
								post__not_in.push(section_postid);
							}
						});
					}
					
					if(post__not_in.length){
						$.post(ajaxurl, {
							'action': 'arnold_interface_page_ajax_filter',
							'cat_id': catID,
							'post_id': postID,
							'post__not_in': post__not_in
						}).done(function(content){
							$iso_list.isotope('insert', $(content));
							if(_this.hasClass('masonry-grid')) {
								themeData.isotopelistResize(_this, _this_wrap);
								$iso_list.isotope('layout');
							}
							
							var thisPostCount = $iso_list.find('section').length;
							if(filterValue != '*'){
								thisPostCount = $iso_list.find('section' +filterValue).length;
							}
							
							if(thisPostCount >= postCount){
								loadBtn.parent().hide();
							}else{
								loadBtn.parent().show();	
							}
							
							setTimeout(function() {
								$(window).lazyLoadXT();
								$iso_list.find('.grid-item-inside').addClass('grid-show');
							}, 50);
						});
					}
					
					return false;
				});

				if(_this_wrap.find('.grid-item-cate-a').length) {
					$('.grid-item-cate-a').each(function(){
						$(this).on( 'click', function() {
							var filterValue = $( this ).attr('data-filter');
							$iso_list.isotope({ filter: filterValue });
							_filters.find('li').removeClass('active');
							_filters.find('[data-filter="'+filterValue+'"]').parent().addClass('active');
							return false;
						});
					});
				} 
			}

			if(_this.hasClass('masonry-grid')) {
				themeData.win.on( 'resize', function () {
					themeData.isotopelistResize(_this, _this_wrap);
				}).resize();
				$("#all").trigger('click'); 
			}

		});
	} 
	
	themeData.isotopelistResize = function(_this, _this_wrap){
		var winWidth   = window.innerWidth,
			ListWidth  = _this.width(),
			GridSpacer = _this_wrap.data('spacer'),
			columnNumb = _this_wrap.data('col'),
			GridWith   = Math.floor(ListWidth / columnNumb),
			GridRatio  = _this_wrap.data('ratio'),
			GridText   = _this_wrap.data('text');  

		if (winWidth >= 768) { 

			_this.find('.grid-item').each(function () { 
				$('.grid-item').css({ 
					width : GridWith * 1 - GridSpacer + 'px',
					height : GridWith * GridRatio - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio - GridSpacer)/(GridWith * 1 - GridSpacer)) * 100 + '%'
				); 
				$('.grid-item.grid-item-big').css({ 
					width : GridWith * 2 - GridSpacer + 'px',
					height : GridWith * GridRatio * 2 - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item.grid-item-big .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio * 2 - GridSpacer)/(GridWith * 2 - GridSpacer)) * 100 + '%'
				); 
				$('.grid-item.grid-item-long').css({ 
					width : GridWith * 2 - GridSpacer + 'px',
					height : GridWith * GridRatio - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item.grid-item-long .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio - GridSpacer)/(GridWith * 2 - GridSpacer)) * 100 + '%'
				); 
				$('.grid-item.grid-item-tall').css({ 
					width : GridWith * 1 - GridSpacer + 'px',
					height : GridWith * GridRatio * 2 - GridSpacer + GridText * 2  + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item.grid-item-tall .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio * 2 - GridSpacer + GridText)/(GridWith * 1 - GridSpacer)) * 100 + '%'
				); 
			});

		} else {
			
			GridWith = Math.floor(ListWidth / 1);

			_this.find('.grid-item.grid-item-small').each(function () { 
				$('.grid-item').css({ 
					width : GridWith * 1 - GridSpacer + 'px',
					height : GridWith * GridRatio - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio - GridSpacer)/(GridWith * 1 - GridSpacer)) * 100 + '%'
				); 
				$('.grid-item.grid-item-big').css({ 
					width : GridWith * 1 - GridSpacer + 'px',
					height : GridWith * GridRatio - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item.grid-item-big .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio - GridSpacer)/(GridWith * 1 - GridSpacer)) * 100 + '%'
				); 
				$('.grid-item.grid-item-long').css({ 
					width : GridWith * 1 - GridSpacer + 'px',
					height : GridWith * GridRatio * 0.5 - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item.grid-item-long .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio - GridSpacer)/(GridWith * 2 - GridSpacer)) * 100 + '%'
				); 
				$('.grid-item.gird-item-tall').css({ 
					width : GridWith * 1 - GridSpacer + 'px',
					height : GridWith * GridRatio * 2 - GridSpacer + GridText + 'px',
					margin : GridSpacer * 0.5 + 'px' 
				});
				$('.grid-item.gird-item-tall .ux-lazyload-wrap').css(
					"padding-top", ((GridWith * GridRatio * 2 - GridSpacer)/(GridWith * 1 - GridSpacer)) * 100 + '%'
				); 

			});	
		}
	}

	// Header & Filter sticky

	themeData.header_sticky = function(){ 

		var lastScrollTop = 0, delta = 5;

		themeData.win.bind('scroll', function() {

			var st = $(this).scrollTop();
			
			if(Math.abs(lastScrollTop - st) <= delta) return; 

			if (st > lastScrollTop){
				//scroll down
				if(themeData.body.hasClass('header-scrolled')){
					themeData.body.removeClass('header-scrolled');
				}
				if(!themeData.body.hasClass('header-scrolling') && st > 100 ){
					themeData.body.addClass('header-scrolling');
				}

			} else {
				//scroll up
				if( st > 10 ){
					if(!themeData.body.hasClass('header-scrolled')){
						themeData.body.addClass('header-scrolled');
					}
				} else {
					if(themeData.body.hasClass('header-scrolled')){
						themeData.body.removeClass('header-scrolled');
					}
				}
				if(themeData.body.hasClass('header-scrolling')){
					themeData.body.removeClass('header-scrolling');
				}

			}

			lastScrollTop = st;
		});

	}
	
	//fix Lazy with filter
	if(themeData.isotope_filter.length) {
		$.lazyLoadXT.updateEvent+=' layoutComplete';
	}

	//Sub Menu
	themeData.fnSetMenuLevel = function(index, el){
		if(el){
			el.each(function(i){
				$(this).addClass('level-' +index);
				if($(this).hasClass('menu-item-has-children')){
					themeData.fnSetMenuLevel(index + 1, $(this).find('> .sub-menu > li'));
				}
			});
		}
	}

	themeData.fnSubMenu = function(menu) {
		//themeData.NaviWrapMobile = $('#menu-panel .menu');
		themeData.NaviWrapMobile = menu;
		themeData.fnSetMenuLevel(1, themeData.NaviWrapMobile.find('> li'));
		
		themeData.NaviWrapMobile.find('li').each(function(index){
			var _this = $(this),
			    _this_link = _this.find('> a');
			
			if(_this.hasClass('menu-item-has-children')){

				_this.find('> .sub-menu').prepend('<li class="menu-item-back"><a href="#" class="menu-item-back-a archive-arrow"><span class="archive-arrow-inn"></span></a></li>');
				_this_link.append('<span class="submenu-icon"></span>');
				
				_this_link.click(function(){
					themeData.NaviWrapMobile.find('li').velocity("transition.slideLeftOut",200, function() {
					    _this_link.hide();
				        _this_link.next().velocity("transition.slideLeftIn", 100);
				        _this_link.next().children().velocity("transition.slideLeftIn", 100);
				        _this_link.parents('.menu-item').velocity("transition.slideLeftIn", 100);
					    
					}); 
						return false;
				});
				
				_this.find('> .sub-menu > .menu-item-back > a').click(function(){
					var sub_menu = $(this).parent().parent();
					var parent_item = sub_menu.parent();
					var parent_item_link = parent_item.find('> a');
					
					if(parent_item.not('.level-1')){ 
						sub_menu.velocity("transition.fadeOut",1, function(){
							parent_item.parent().children().velocity("transition.slideLeftIn", 300);
							parent_item_link.velocity("transition.fadeIn", 300);
						});
					} 
						
					return false;
				});
			}else{
				_this_link.click(function(){

					if(!Modernizr.touchevents){
						if(!$(this).parent().hasClass('current-menu-anchor')){
							themeData.fnPageLoadingEvent($(this));
							return false;
						}
					} else {
						if(!$(this).parent().hasClass('current-menu-anchor')&& !$(this).parent().hasClass('menu-item-has-children')){
							themeData.fnPageLoadingEvent($(this));
							return false;
						}
					}
					
				});
			}
			
		});
    	
    };

    var itemQueue = []
	var itemDelay = 150
	var queueTimer

    function fnListItemQueue () {
		if (queueTimer) return  
		queueTimer = window.setInterval(function () {
			if (itemQueue.length) {
				$(itemQueue.shift()).addClass('grid-show');
				fnListItemQueue();
			}
			else {
				window.clearInterval(queueTimer);
				queueTimer = null;
			}
		}, itemDelay);
	}

    // Single Post Scrolled Animation
    themeData.fnSingleAnima = function(){
    	if($('.social-bar').length) {
    		var _social_bar = $('.social-bar');
    		_social_bar.waypoint(function(direction) { 
				if (direction === 'down') { 
					_social_bar.find('.fa').velocity("transition.expandIn", { stagger: 160 }); 
				}
				this.destroy();
			},{
				offset: '95%'
			});
    	}
    }

    // Main Scrolled Animation
	themeData.fnMainAnima = function(){

		if($(".grid-item-inside").length) {
			$(".grid-item-inside").waypoint(function (direction) {
				itemQueue.push(this.element);
				fnListItemQueue();
			}, {
				offset: '100%'
			});
			$('.grid-item-inside').each(function(index, element) {
                if($(this).parent().offset().top < themeData.winScrollTop + themeData.winHeight){
					var lazyload = $(this).find('.ux-lazyload-bgimg');
					var lazyload_bgimg = lazyload.data('bg');
					if(lazyload_bgimg) {
						lazyload.addClass('lazy-loaded').css('background-image', 'url("' +lazyload_bgimg+ '")');
					}
					itemQueue.push($(this));
					fnListItemQueue();
				}
            });
		}

    	if($('.pagenums .tw-style-a').length) {
    		var _tw_loadmore_btn = $('.pagenums .tw-style-a');
    		_tw_loadmore_btn.waypoint(function(direction) { 
				if (direction === 'down') { 
					_tw_loadmore_btn.velocity("transition.fadeIn"); 
				}
				this.destroy();
			},{
				offset: '95%'
			});
    	}

    	if(themeData.sectionCuslList.length) {
    		themeData.sectionCuslList.imagesLoaded(function(){
    			themeData.sectionCuslList.find('.cusl-style-unit').each(function(){
	    			var _this = $(this);
	    			_this.waypoint(function(direction) { 
						if (direction === 'down') { 
							_this.addClass('cusl-show');
						}
						this.destroy();
					},{
						offset: '100%'
					});
	    		});
    		});
    		
    	}

    	if($('.pagetemplate-social').length) {
    		var _social_bar = $('.pagetemplate-social .socialmeida');
    		_social_bar.waypoint(function(direction) { 
				if (direction === 'down') { 
					_social_bar.find('.socialmeida-a').velocity("transition.expandIn", { stagger: 260 }); 
				}
				this.destroy();
			},{
				offset: '95%'
			});
    	}

    }
	
	//Portfolio list
	themeData.fnSingleGalleryList = function(){
		themeData.singleGalleryGoBack.click(function(){
			var singleGalleryListWrap = $('.ux-portfolio-ajaxed-list-wrap');
			var singlePostID = $(this).attr('data-postid');
			
			if($(this).hasClass('back-close')){
				$(this).removeClass('back-close');
				singleGalleryListWrap.fadeOut();
			}else{
				$(this).addClass('back-close');
				if(singleGalleryListWrap.length){
					singleGalleryListWrap.fadeIn();
				}else{
					$.post(ajaxurl, {
						'action': 'arnold_interface_ajax_portfolio_list',
						'post_id': singlePostID,
						'paged': 1
					}).done(function(content){
						var singleGalleryBottom = themeData.singleGalleryGoBack.parents('.blog-unit-meta-bottom');
						var singleGalleryListWrap = $('.ux-portfolio-ajaxed-list-wrap');
						
						setTimeout(function() {
							$(window).lazyLoadXT(); 
						}, 50);
						
						singleGalleryBottom.after(content);
						singleGalleryListWrap.fadeIn();
						
						//call page load more
						if($('.ux-portfolio-ajaxed-list-wrap').find('.ux-page-load-more').length){
							var singleGalleryListWrap = $('.ux-portfolio-ajaxed-list-wrap');
							var singleGalleryList = $('.ux-portfolio-ajaxed-list');
							var loadBtn = singleGalleryListWrap.find('.ux-page-load-more');
							var postID = loadBtn.attr('data-pageid');
							var postMAX = loadBtn.attr('data-max');
							var pageText = loadBtn.parent().attr('data-pagetext');
							var loadingText = loadBtn.parent().attr('data-loadingtext');
							
							loadBtn.click(function(){
								var paged = loadBtn.attr('data-paged');
								
								loadBtn.text(loadingText);
								
								if(!singleGalleryList.hasClass('loading-more')){
									singleGalleryList.addClass('loading-more');
									$.post(ajaxurl, {
										'action': 'arnold_interface_ajax_portfolio_list',
										'post_id': postID,
										'paged': paged
									}).done(function(c){
										singleGalleryList.append(c);
										
										loadBtn.attr('data-paged', Number(paged) + 1).text(pageText);
										
										if(Number(paged) == Number(postMAX)){
											loadBtn.parent().hide();
										}else{
											loadBtn.parent().show();
										}
										
										singleGalleryList.removeClass('loading-more');
										
										setTimeout(function() {
											$(window).lazyLoadXT();
											$iso_list.find('.grid-item-inside').addClass('grid-show'); 
										}, 50);
										
									});
								}
								
								return false;
							});
						}
						$('html, body').animate({scrollTop:themeData.singleGalleryGoBack.offset().top - 50}, 400);
					});
				}
			}
			return false;
		});
	};

	//page loading event
	themeData.fnPageLoadingEvent = function(el){
		var _url = el.attr('href');
		if(_url){
			if(themeData.pageLoading.length){ 
				themeData.pageLoading.addClass('visible');
			}
			themeData.body.addClass('ux-start-hide');
			themeData.body.find('#wrap').animate({opacity: 0}, 300);
			setTimeout(function(){
				window.location.href = _url;
			}, 400);
			
		}
	}

	//Irregular  Hover
	themeData.fnIrregularHover = function(el){

		//var el = themeData.sectionCusl;
		el.on('mousemove', function(e){
			var elPos = $(this).offset(),
				cursPosX = e.pageX - elPos.left,
				cursPosY = e.pageY - elPos.top,
				elWidth = $(this).width(),
				elHeight = $(this).height(),
				elHalfWidth = elWidth / 2,
				elHalfHeight = elHeight / 2,
				cursFromCenterX = elHalfWidth - cursPosX,
				cursFromCenterY = elHalfHeight - cursPosY;
			var reflectPercent = (cursPosX + cursPosY) / (elWidth + elHeight) * 100;
			$(this).css('transform','perspective(1700px) rotateX('+ (cursFromCenterY / 20) +'deg) rotateY('+ -(cursFromCenterX / 20) +'deg)');
			//$('.reflect').css('transform', 'scale('+ reflectPercent / 40 +')')
			$(this).removeClass('leave');
		});

		el.on('mouseleave', function(){
			//$('.reflect').css('transform', 'scale(1)')
			$(this).addClass('leave');
		});
	}
	
	
	//Irregular List Infiniti Scroll
	themeData.fnInfinitiScroll = function(el){
		var postID = themeData.sectionCuslList.attr('data-pageid');
		var waypoints = el.waypoint({
			handler: function(direction){
				var post__not_in = [];
				themeData.sectionCuslList.find('section').each(function(){
					var section_postid = $(this).attr('data-postid');
					post__not_in.push(section_postid);
				});
				
				if(!themeData.sectionCuslList.hasClass('infiniti-scrolling')){
					themeData.sectionCuslList.addClass('infiniti-scrolling');
					$.post(ajaxurl, {
						'action': 'arnold_interface_page_ajax_filter',
						'cat_id': 0,
						'post_id': postID,
						'post__not_in': post__not_in
					}).done(function(content){
						var content = $(content);
						themeData.sectionCuslList.find('section:last').after(content);
						
						themeData.sectionCuslList.removeClass('infiniti-scrolling');
						
						themeData.fnInfinitiScroll(themeData.sectionCuslList.find('section:last'));
						
						setTimeout(function() {
							$(window).lazyLoadXT();
							themeData.sectionCuslList.find('section').each(function(){
								if(!$(this).hasClass('cusl-show')){
									$(this).addClass('cusl-show')
								}
							});
							
							themeData.fnIrregularHover(content.find('.cusl-style-unit-inn')); 
						}, 50);
					});
				}
			},
			offset: 'bottom-in-view'
		});
	}
	
	//Grid Stack Init Size
	themeData.fnGridStackInitSize = function(items){
		items.each(function(){
			var gs_x = Number($(this).attr('data-gs-x'));
			var gs_y = Number($(this).attr('data-gs-y'));
			var gs_width = Number($(this).attr('data-gs-width'));
			var gs_height = Number($(this).attr('data-gs-height'));
			
			$(this).attr({
				'data-o-x': gs_x,
				'data-o-y': gs_y,
				'data-o-width': gs_width,
				'data-o-height': gs_height
			});
		});
	}
	
	//Grid Stack Init Resize
	themeData.fnGridStackInitResize = function(){
		themeData.gridStack.find('.grid-stack-item').each(function(){
			var gs_x = Number($(this).attr('data-o-x'));
			var gs_y = Number($(this).attr('data-o-y'));
			var gs_width = Number($(this).attr('data-o-width'));
			var gs_height = Number($(this).attr('data-o-height'));
			
			$(this).attr({
				'data-gs-x': gs_x,
				'data-gs-y': gs_y,
				'data-gs-width': gs_width,
				'data-gs-height': gs_height
			});
		});
	}
	
	//Grid Stack Resize
    themeData.fnGridStackResize = function(){
		if(themeData.gridStack.length){
			var gridStackWidth = themeData.gridStack.width(); 
			var gridStackSpacing = themeData.gridStack.data('spacing');
			var gridStackColWidth = (gridStackWidth + gridStackSpacing) / 12;
			var gridStackOffsetTop = themeData.gridStack.offset().top;
			var gridOffsetTop = [];
			
			themeData.gridStack.find('.grid-stack-item').each(function(){
				var gs_x = Number($(this).attr('data-gs-x'));
				var gs_y = Number($(this).attr('data-gs-y'));
				var gs_width = Number($(this).attr('data-gs-width'));
				var gs_height = Number($(this).attr('data-gs-height'));
				
				var set_height = gridStackColWidth * gs_height;
				var set_top = gridStackColWidth * gs_y;
				
				var gs_content = $(this).find('.grid-stack-item-content');
				var gs_brick_content = $(this).find('.brick-content');
				
				$(this).css({
					width: gridStackColWidth * gs_width + 'px',
					height: set_height + 'px',
					left: gridStackColWidth * gs_x + 'px',
					top: set_top + 'px'
				});
				
				gs_content.css({
					left: gridStackSpacing * 0.5 + 'px',
					right: gridStackSpacing * 0.5 + 'px',
					top: gridStackSpacing * 0.5 + 'px',
					bottom: gridStackSpacing * 0.5 + 'px'
				});
				
				if(gs_content.height() > 0 && gs_content.width() > 0){
					gs_brick_content.css('padding-top', (gs_content.height() / gs_content.width()) * 100 + '%');
				}
				
				gridOffsetTop.push(set_top + $(this).height());
			});
			
			var gridStackHeight = Math.max.apply(Math,gridOffsetTop);
			themeData.gridStack.height(gridStackHeight);
		}
	}
	
	//grid stack items
	themeData.fnGridStackItems = function(el){
		if($('.filters').length || $('.menu-filter-wrap').length || $('.menu-filter').length){
			var _filters = $('.filters [data-filter], .menu-filter-wrap [data-filter]');
			
			_filters.each(function(){
				var filterValue = $(this).attr('data-filter');
				var filterCatID = $(this).attr('data-catid');
				var filterItems = [];
				var filterNotItems = [];
				
				if(filterValue == '*'){
					filterCatID = 'all';
				}
				
				el.find('.grid-stack-item').each(function(){
					var node = [];
					
					node.gs = {};
					node.gs.x = Number($(this).data('gs-x'));
					node.gs.y = Number($(this).data('gs-y'));
					node.gs.width = Number($(this).data('gs-width'));
					node.gs.height = Number($(this).data('gs-height'));
					node.post_id = Number($(this).data('postid'));
					node.el = $(this);
					
					if($(this).is(filterValue)){
						filterItems.push(node);
						if(filterCatID){
							if(themeData.gridStackItems[filterCatID]){
								themeData.gridStackItems[filterCatID].push(node);
							}
						}
					}
					
					if(!$(this).is(filterValue)){
						filterNotItems.push(node);
						if(filterCatID){
							if(themeData.gridStackItems['not_' +filterCatID]){
								themeData.gridStackItems['not_' +filterCatID].push(node);
							}
						}
					}
				});
				
				if(filterCatID){
					if(!themeData.gridStackItems[filterCatID]){
						themeData.gridStackItems[filterCatID] = filterItems;
					}
					
					if(!themeData.gridStackItems['not_' +filterCatID]){
						themeData.gridStackItems['not_' +filterCatID] = filterNotItems;
					}
				}
			});
		}
	}
	
	//document ready
	themeData.doc.ready(function(){

		//call menu
		if(themeData.isResponsive()){
			themeData.win.find('img').imagesLoaded(function(){ 
				themeData.fnResponsiveMenu();
			}); 
		} 
		//Call Isotope
		if(themeData.isotope.length){
			themeData.isotopelist();
			$('.masonry-list').isotope('on', 'layoutComplete', function() {
	            $(window).trigger('layoutComplete');
	        });
		}

		// Run Single Scroll Animation
		themeData.fnSingleAnima();

		if($('.pagenums').length) {
			$('.pagenums').each(function(){
				if ($(this).is(':empty')){
					$(this).hide();
				}
			});
		}
		
		themeData.fnFullscreenWrapHeight();
		$(window).bind('resize', themeData.fnFullscreenWrapHeight);

		//Pageone navi
		if($('.anchor-in-current-page').length){
			if(themeData.WrapOurter.hasClass('enbale-onepage')) {
				themeData.Menu.onePageNav({
					currentClass: 'current',
					filter: ':not(.external)'
				});
			}
		}
		
		//Pagenumber re-layout
		if(themeData.pagenumsDefault.length) {
			themeData.pagenumsDefault.each(function(){
				if($(this).find('.prev').length && $(this).find('.next').length){
					$(this).find('.next').after($(this).find('.prev'));
				}
			});
		}
		
		//Call audio player
		themeData.fnJplayerCall();
		
		//Pagination - twitter style
		if(themeData.blogPagenumsTwitter.length){
			themeData.blogPagenumsTwitter.each(function(){
				var twitterLink = [];
				
				twitterLink.item = $(this);
				twitterLink.moduleID = twitterLink.item.data('module');
				twitterLink.modulePost = twitterLink.item.data('post');
				twitterLink.postID = twitterLink.item.data('postid');
				twitterLink.paged = twitterLink.item.data('paged');
				
				twitterLink.item.click(function(){
					twitterLink.item.html('<span>Loading...</span>');
					
					twitterLink.item.addClass('tw-style-loading');
					twitterLink.paged = twitterLink.item.attr('data-paged');

					var ajax_data = {
						'module_id'   : twitterLink.moduleID,
						'module_post' : twitterLink.modulePost,
						'post_id'     : twitterLink.postID,
						'paged'       : twitterLink.paged,
						'mode'        : 'twitter'
					}
					
					themeData.fnModuleLoad(ajax_data, twitterLink.item.parents('.pagenums'));
					return false;
				});
			})
			
		}

		//call video popup
		if(themeData.videoFace.length){
			themeData.fnVideoFace(themeData.videoFace);
		}
		
		//call portfolio list
		if(themeData.singleGalleryGoBack.length){
			themeData.fnSingleGalleryList();
		}

		//Call Irregular Hover
		if(themeData.sectionCuslList.length){
			themeData.fnIrregularHover(themeData.sectionCusl);
		}


		//Page Loading
		//Logo
		$('#logo a,.carousel-des-wrap-tit-a').click(function(){
			themeData.fnPageLoadingEvent($(this));
			return false;
		});

		//Navi, WPML 
		$('#navi li:not(.menu-item-has-children) a').click(function(){
			if(themeData.body.hasClass('show_mobile_menu')) {
				themeData.body.removeClass('show_mobile_menu')
			}
			themeData.fnPageLoadingEvent($(this));
			return false;
		});
		

		//blog, post 
		$('.wpml-language-flags a,.grid-item-mask-link:not(.lightbox-item),.grid-item-tit-a, .title-wrap a, .page-numbers,.archive-grid-item a,.arrow-item').click(function(){
			themeData.fnPageLoadingEvent($(this));
			return false;
		});
		
		//gallery navi
		$('.single .gallery-navi-post a').click(function(){
			themeData.fnPageLoadingEvent($(this));
			return false;
		});
	
		//slide template / archive unit
		$('.disable-scroll-a,.search-result-unit-tit a,.subscribe-link-a,.article-meta-unit a,.blog-unit-more-a').click(function(){
			themeData.fnPageLoadingEvent($(this));
			return false;
		});
	
		//sidebar widget
		$('.widget_archive a, .widget_recent_entries a, .widget_search a, .widget_pages a, .widget_nav_menu a, .widget_tag_cloud a, .widget_calendar a, .widget_text a, .widget_meta a, .widget_categories a, .widget_recent_comments a, .widget_tag_cloud a').click(function(){
			themeData.fnPageLoadingEvent($(this));
			return false;
		});
	
		/** Module*/
		$('.moudle .blog-bigimage a,.moudle .iterlock-caption a, .moudle .tab-content a, .moudle .accordion-inner a, .moudle .blog-item a, .moudle .isotope a, .moudle .ux-btn, .moudle .post-carousel-item a, .moudle .caroufredsel_wrapper:not(.portfolio-caroufredsel) a').click(function(){
			if($(this).is('.lightbox')||$(this).is('.tw-style-a')||$(this).is('.lightbox-item')){}else if($(this).is('.liquid_list_image')){}else if($(this).is('.ajax-permalink')){}else{
				themeData.fnPageLoadingEvent($(this));
				return false;
			}
		});

		//Porfolio template
		$('.related-post-unit a,.tags-wrap a').click(function(){	
			themeData.fnPageLoadingEvent($(this));
			return false;
		});
		
		 

	});
	
	//win load
	themeData.win.load(function(){

		if(themeData.listLayout.length){
			themeData.fnListLayoutHeight();
			themeData.win.bind('resize', themeData.fnListLayoutHeight);
		}
		
		setTimeout(function(){
			themeData.pageLoading.removeClass('visible'); 
		},10);	

		themeData.body.removeClass('preload');
		
		themeData.body.removeClass('ux-start-hide');

		// Run Main  Scroll Animation
		themeData.fnMainAnima();

		if($('#header').length) {
		//	themeData.header_sticky();
		}

		//Call down button in gallery post
		if(themeData.TopsliderTrggleDown.length){
			themeData.TopsliderTrggleDownFn();
		}

		//Footer Anima
		if(themeData.footer.length) { 
			//themeData.fnFooterAnima(); 
		}

		//Call Lightbox 
		if(themeData.lightboxPhotoSwipe.length){
			fnInitPhotoSwipeFromDOM('.lightbox-photoswipe');
		}

		//Call top silder
		if(themeData.carousel.length) {
			themeData.carouselFn(themeData.carousel);
		}

		//Call BM Slider - Tab Slider
		if($('.bm-tab-slider').length) {
			themeData.fnBMTabSlider(); 
		}

		//Call BM Slider - Idel
		if(themeData.body.hasClass('page-template-only-slider-body') && $('.owl-carousel').length) {
			themeData.resetTimer();
			themeData.fnBMsliderIdel();
		}
		
		//Call Tip
		if(themeData.tooltip.length){
			themeData.tooltip.tooltip();
		}

		// Back top 
		if(themeData.backTop.length){
			themeData.backTop.on({'touchstart click': function(){ 
				$('html, body').animate({scrollTop:0}, 1200);
			}});
		}

		//Call Search
		if(themeData.searchOpen.length){
			themeData.fnSerchShow();
		} 
		
		if(themeData.galleryCollage.length) {
			themeData.win.find('img').imagesLoaded(function(){ 
				themeData.fnGalleryCollage(themeData.galleryCollage); 
			});
		}

		if(themeData.body.hasClass('with-video-cover')) {
			themeData.fnVideocoverTitle();
		}

		if(themeData.backTop.length) {
			themeData.fnBackTop();
		}

		themeData.CoverScroll();
		
		if(themeData.sectionCuslList.length){
			if(themeData.sectionCuslList.next().find('.ux-page-load-more').length){
				var loadBtn = themeData.sectionCuslList.next().find('.ux-page-load-more');
				
				var postID = loadBtn.attr('data-pageid');
				var postMAX = loadBtn.attr('data-max');
				var postCount = loadBtn.attr('data-postcount');
				var pageText = loadBtn.parent().attr('data-pagetext');
				var loadingText = loadBtn.parent().attr('data-loadingtext');

				loadBtn.click(function(){
					var post__not_in = [];
					themeData.sectionCuslList.find('section').each(function(){
						var section_postid = $(this).attr('data-postid');
						post__not_in.push(section_postid);
					});
					
					loadBtn.text(loadingText);

					if(!themeData.sectionCuslList.hasClass('loading-more')){
						themeData.sectionCuslList.addClass('loading-more');
						$.post(ajaxurl, {
							'action': 'arnold_interface_page_ajax_filter',
							'cat_id': 0,
							'post_id': postID,
							'post__not_in': post__not_in
						}).done(function(content){
							var content = $(content);
							themeData.sectionCuslList.find('section:last').after(content);
							
							loadBtn.text(pageText);
							themeData.sectionCuslList.removeClass('loading-more');
							
							var thisPostCount = themeData.sectionCuslList.find('section').length;
							
							if(thisPostCount >= Number(postCount)){
								loadBtn.parent().hide();
							}else{
								loadBtn.parent().show();	
							}
							
							setTimeout(function() {
								$(window).lazyLoadXT();
								themeData.sectionCuslList.find('section').each(function(){
									if(!$(this).hasClass('cusl-show')){
										$(this).addClass('cusl-show')
									}
								});

								themeData.fnIrregularHover(content.find('.cusl-style-unit-inn'));

							}, 50);
						});
					}
					
					return false;
				});
			}
			
			//call infiniti scroll
			if(themeData.sectionCuslList.hasClass('infiniti-scroll')){
				themeData.fnInfinitiScroll(themeData.sectionCuslList.find('section:last'));
			}
		}
		
		if(themeData.gridStack.length){
			var gridStackSpacing = themeData.gridStack.data('spacing');
			var gridStackPageID = themeData.gridStack.data('pageid');
			var gridStackPerpage = themeData.gridStack.data('perpage');
			
			themeData.gridStack.css('margin', - gridStackSpacing * 0.5 + 'px');
			
			themeData.fnGridStackInitSize(themeData.gridStack.find('.grid-stack-item'));
			
			var gridStack = themeData.gridStack.gridstack({
				verticalMargin: gridStackSpacing,
				disableDrag: true,
				draggable: {disabled: true},
				disableResize: true
			});
			
			var isoGridStack = themeData.gridStack.isotope({ 
				itemSelector: '.grid-stack-item',
				layoutMode: 'packery',
				stagger: 40,
				resize: false
			});
			
			themeData.fnGridStackResize();
			
			themeData.win.resize(function(){
				var filters = $('.filters');
					
				if($('.menu-filter-wrap').length) { filters = $('.menu-filter-wrap'); }
				if($('.menu-filter').length) { filters = $('.menu-filter'); }
				
				var filterActive = filters.find('li.active');
				var filterValue = filterActive.find('> a').attr('data-filter');
				
				if(filterValue){
					if(filterValue != '*'){
						isoGridStack.isotope('layout');
					}else{
						themeData.fnGridStackResize();
					}
				}else{
					if(themeData.gridStack.length){
						themeData.fnGridStackResize();
					}
				}
			});
			
			var grid = themeData.gridStack.data('gridstack');
			//themeData.fnGridStackItems(themeData.gridStack);
			
			var filterHidden = false;
			if($('.filters').length || $('.menu-filter-wrap').length || $('.menu-filter').length){
				var _filters = $('.filters [data-filter]');
				
				if($('.menu-filter-wrap').length){
					_filters = $('.menu-filter-wrap [data-filter]');
				}
				
				if($('.menu-filter').length){
					_filters = $('.menu-filter [data-filter]');
				}
				
				_filters.click(function(){
					var filterValue = $(this).attr('data-filter');
					var filterCatID = $(this).attr('data-catid');
					var filterItems = [];
					var filterCount = Number($(this).find('.filter-num').text());
					var post__not_in = [];
					var postCount = 0;
					var loadBtn = themeData.gridStack.next('.page_twitter').find('.ux-page-load-more');
					
					$(this).parent().parent().find('li').removeClass('active');
					$(this).parent().addClass('active');
					
					if(loadBtn.length){
						var thisPostCount = themeData.gridStack.find('.grid-stack-item').length;
						if(filterValue != '*'){
							thisPostCount = themeData.gridStack.find('.grid-stack-item' +filterValue).length;
						}
						
						if(thisPostCount >= filterCount){
							loadBtn.parent().hide();
						}else{
							loadBtn.parent().show();	
						}
					}
					
					if(filterValue == '*'){
						filterCatID = 0;
						filterHidden = themeData.gridStack.find('.grid-stack-item:hidden');
						//themeData.fnGridStackInitResize();
						themeData.fnGridStackResize();
						filterHidden.show();
					}else{
						if(filterHidden){
							filterHidden.hide();
						}
						
						isoGridStack.isotope({ filter: filterValue });
						
						themeData.gridStack.find('.grid-stack-item').each(function(){
							var section_postid = $(this).attr('data-postid');
							if($(this).is(filterValue)){
								post__not_in.push(section_postid);
							}
						});
						
						if(post__not_in.length < filterCount && post__not_in.length < Number(gridStackPerpage)){
							var per_page = Number(gridStackPerpage) - (filterCount - post__not_in.length);
							
							if(!themeData.gridStack.hasClass('filtering')){
								themeData.gridStack.addClass('filtering');
								$.post(ajaxurl, {
									'action': 'arnold_interface_page_ajax_filter',
									'cat_id': filterCatID,
									'post_id': gridStackPageID,
									'post__not_in': post__not_in,
									'per_page': per_page
								}).done(function(content){
									var content = $('<div>' +content+ '</div>');
									
									if(filterValue != '*'){
										isoGridStack.isotope('insert', content.find('.grid-stack-item'));
										themeData.fnGridStackResize();
										isoGridStack.isotope('layout');
									}else{
										themeData.fnGridStackInitSize(content.find('.grid-stack-item'));
										//themeData.gridStack.append(content.find('.grid-stack-item'));
										content.find('.grid-stack-item').each(function(){
											var gs_x = Number($(this).attr('data-gs-x'));
											var gs_y = Number($(this).attr('data-gs-y'));
											var gs_width = Number($(this).attr('data-gs-width'));
											var gs_height = Number($(this).attr('data-gs-height'));
											
											$(this).attr('data-gs-new', 'true');
											isoGridStack.isotope('addItems', $(this));
											grid.addWidget($(this), gs_x, gs_y, gs_width, gs_height);
										});
										
										//themeData.fnGridStackInitResize();
										themeData.fnGridStackResize();
									}
									
									var thisPostCount = themeData.gridStack.find('.grid-stack-item' +filterValue).length;
									if(thisPostCount >= filterCount){
										loadBtn.parent().hide();
									}else{
										loadBtn.parent().show();	
									}
									
									setTimeout(function() {
										$(window).lazyLoadXT();
										themeData.gridStack.find('.grid-item-inside').each(function(){
											if(!$(this).hasClass('grid-show')){
												$(this).addClass('grid-show');
											}
										});
									}, 10);
									
									themeData.gridStack.removeClass('filtering');
									
								});
							}
						}
					}
					return false;
				});
			}
			
			//call page load more
			if(themeData.gridStack.next('.page_twitter').find('.ux-page-load-more').length){
				var loadBtn = themeData.gridStack.next('.page_twitter').find('.ux-page-load-more');
				var postID = loadBtn.attr('data-pageid');
				var postMAX = loadBtn.attr('data-max');
				var pageText = loadBtn.parent().attr('data-pagetext');
				var loadingText = loadBtn.parent().attr('data-loadingtext');

				loadBtn.click(function(){
					var paged = loadBtn.attr('data-paged');
					var filters = $('.filters');
					
					if($('.menu-filter-wrap').length){
						filters = $('.menu-filter-wrap');
					}
					
					if($('.menu-filter').length){
						filters = $('.menu-filter');
					}
					
					var filterActive = filters.find('li.active');
					var filterValue = filterActive.find('> a').attr('data-filter');
					var catID = filterActive.find('> a').attr('data-catid');
					var postCount = Number(filterActive.find('.filter-num').text());
					var post__not_in = [];
					
					if(filterValue == '*'){
						catID = 0;
					}
					
					themeData.gridStack.find('.grid-stack-item').each(function(){
						var section_postid = $(this).attr('data-postid');
						if(filterValue != '*'){
							if($(this).is(filterValue)){
								post__not_in.push(section_postid);
							}
						}else{
							post__not_in.push(section_postid);
						}
					});
					
					loadBtn.text(loadingText);

					if(!themeData.gridStack.hasClass('loading-more')){
						themeData.gridStack.addClass('loading-more');
						$.post(ajaxurl, {
							'action': 'arnold_interface_page_ajax_filter',
							'cat_id': catID,
							'post_id': postID,
							'post__not_in': post__not_in
						}).done(function(content){
							var content = $('<div>' +content+ '</div>');
							
							if(filterValue != '*'){
								isoGridStack.isotope('insert', content.find('.grid-stack-item'));
								themeData.fnGridStackResize();
								isoGridStack.isotope('layout');
							}else{
								themeData.fnGridStackInitSize(content.find('.grid-stack-item'));
								//themeData.gridStack.append(content.find('.grid-stack-item'));
								content.find('.grid-stack-item').each(function(){
									var gs_x = Number($(this).attr('data-gs-x'));
									var gs_y = Number($(this).attr('data-gs-y'));
									var gs_width = Number($(this).attr('data-gs-width'));
									var gs_height = Number($(this).attr('data-gs-height'));
									
									$(this).attr('data-gs-new', 'true');
									isoGridStack.isotope('addItems', $(this));
                                    grid.addWidget($(this), gs_x, gs_y, gs_width, gs_height);
                                });
								
								//themeData.fnGridStackInitResize();
								themeData.fnGridStackResize();
							}
							
							loadBtn.text(pageText);
							themeData.gridStack.removeClass('loading-more');
							
							var thisPostCount = themeData.gridStack.find('.grid-stack-item').length;
							if(filterValue != '*'){
								thisPostCount = themeData.gridStack.find('.grid-stack-item' +filterValue).length;
							}
							
							if(thisPostCount >= postCount){
								loadBtn.parent().hide();
							}else{
								loadBtn.parent().show();	
							}
							
							setTimeout(function() {
								$(window).lazyLoadXT();
								themeData.gridStack.find('.grid-item-inside').each(function(){
									if(!$(this).hasClass('grid-show')){
										$(this).addClass('grid-show');
									}
								});
							}, 10);
						});
					}
					return false;
				});
			}
			
			//call infiniti scroll
			if(themeData.gridStack.hasClass('infiniti-scroll')){
				var postID = themeData.gridStack.attr('data-pageid');
				var postMAX = themeData.gridStack.attr('data-max');
				
				var waypoints = themeData.gridStack.waypoint({
					handler: function(direction){
						var paged = themeData.gridStack.attr('data-paged');
						var filters = themeData.gridStack.parents('#content_wrap').find('.filters');
						
						if($('.menu-filter-wrap').length){
							filters = $('.menu-filter-wrap');
						}
						
						if($('.menu-filter').length){
							filters = $('.menu-filter');
						}
						
						var filterActive = filters.find('li.active');
						var filterValue = filterActive.find('> a').attr('data-filter');
						var catID = filterActive.find('> a').attr('data-catid');
						var postCount = Number(filterActive.find('.filter-num').text());
						
						var post__not_in = [];
						themeData.gridStack.find('.grid-stack-item').each(function(){
							var section_postid = $(this).attr('data-postid');
							if(filterValue != '*'){
								if($(this).is(filterValue)){
									post__not_in.push(section_postid);
								}
							}else{
								post__not_in.push(section_postid);
							}
						});
						
						if(!themeData.gridStack.hasClass('infiniti-scrolling')){
							themeData.gridStack.addClass('infiniti-scrolling');
							$.post(ajaxurl, {
								'action': 'arnold_interface_page_ajax_filter',
								'cat_id': catID,
								'post_id': postID,
								'post__not_in': post__not_in
							}).done(function(content){
								var content = $('<div>' +content+ '</div>');
								
								if(content.find('.grid-stack-item').length){
									if(filterValue != '*'){
										isoGridStack.isotope('insert', content.find('.grid-stack-item'));
										themeData.fnGridStackResize();
										isoGridStack.isotope('layout');
									}else{
										themeData.fnGridStackInitSize(content.find('.grid-stack-item'));
										//themeData.gridStack.append(content.find('.grid-stack-item'));
										content.find('.grid-stack-item').each(function(){
											var gs_x = Number($(this).attr('data-gs-x'));
											var gs_y = Number($(this).attr('data-gs-y'));
											var gs_width = Number($(this).attr('data-gs-width'));
											var gs_height = Number($(this).attr('data-gs-height'));
											
											$(this).attr('data-gs-new', 'true');
											isoGridStack.isotope('addItems', $(this));
											grid.addWidget($(this), gs_x, gs_y, gs_width, gs_height);
										});
										
										//themeData.fnGridStackInitResize();
										themeData.fnGridStackResize();
									}
									
									themeData.gridStack.removeClass('infiniti-scrolling');
									
									setTimeout(function() {
										$(window).lazyLoadXT();
										themeData.gridStack.find('.grid-item-inside').each(function(){
											if(!$(this).hasClass('grid-show')){
												$(this).addClass('grid-show');
											}
										});
									}, 10);
								}
							});
						}
					},
					offset: 'bottom-in-view'
				})
			}
		}

	});
	
	
	//win resize
	themeData.win.resize(function(){
		if(themeData.galleryCollage.length){
			$('.Collage .Image_Wrapper').css("opacity", 0);
			if (resizeTimer) clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function(){
				themeData.fnGalleryCollage(themeData.galleryCollage)
			}, 200);
		}
		
		if(themeData.gridStack.length){
			//themeData.fnGridStack();
			
		}
		
	});

	window.onpageshow = function(event) {
	    if (event.persisted) {
	        window.location.reload() 
	    }
	};
	
})(jQuery); 

if(jQuery('body').hasClass('page-template-irregular')) {
	jQuery.extend(jQuery.lazyLoadXT, {
		edgeY:  700 
	}); 
} else {
	jQuery.extend(jQuery.lazyLoadXT, {
		edgeY:  200 
	}); 
}


function fnInitPhotoSwipeFromDOM(gallerySelector){
    var parseThumbnailElements = function(el){
		var thumbElements = jQuery(el).find('[data-lightbox=\"true\"]'),
			numNodes = thumbElements.length,
			items = [],
			figureEl,
			linkEl,
			size,
			type,
			item;

		for(var i = 0; i < numNodes; i++){

			figureEl = thumbElements[i]; // <figure> element

			// include only element nodes 
			if(figureEl.nodeType !== 1){
				continue;
			}

			//linkEl = figureEl.children[0]; // <a> element
			linkEl = jQuery(figureEl).find('.lightbox-item');

			size = linkEl.attr('data-size').split('x');
			type = linkEl.attr('data-type');

			// create slide object
			if(type == 'video'){
				item = {
					html: linkEl.find('> div').html()
				}
			}else{
				item = {
					src: linkEl.attr('href'),
					w: parseInt(size[0], 10),
					h: parseInt(size[1], 10)
				};
			}

			if(figureEl.children.length > 0){
				// <figcaption> content
				item.title = linkEl.attr('title'); 
			}

			if(linkEl.find('img').length > 0){
				// <img> thumbnail element, retrieving thumbnail url
				item.msrc = linkEl.find('img').attr('src');
			} 

			item.el = figureEl; // save link to element for getThumbBoundsFn
			items.push(item);
		}

		return items;
	};

	// find nearest parent element
	var closest = function closest(el, fn){
		return el && (fn(el) ? el : closest(el.parentNode, fn));
	};

	// triggers when user clicks on thumbnail
	var onThumbnailsClick = function(e){
		e = e || window.event;
		e.preventDefault ? e.preventDefault() : e.returnValue = false;

		var eTarget = e.target || e.srcElement;

		// find root element of slide
		var clickedListItem = closest(eTarget, function(el){
			if(el.tagName){
				return (el.hasAttribute('data-lightbox') && el.getAttribute('data-lightbox') === 'true'); 
			}
		});

		if(!clickedListItem){
			return;
		}

		// find index of clicked item by looping through all child nodes
		// alternatively, you may define index via data- attribute
		var clickedGallery = jQuery(clickedListItem).parents('.lightbox-photoswipe'),
			childNodes = clickedGallery.find('[data-lightbox=\"true\"]'),
			numChildNodes = childNodes.length,
			nodeIndex = 0,
			index;

		for (var i = 0; i < numChildNodes; i++){
			if(childNodes[i].nodeType !== 1){ 
				continue; 
			}

			if(childNodes[i] === clickedListItem){
				index = nodeIndex;
				break;
			}
			nodeIndex++;
		}
		
		if(index >= 0){
			// open PhotoSwipe if valid index found
			openPhotoSwipe(index, clickedGallery[0]);
		}
		return false;
	};

	// parse picture index and gallery index from URL (#&pid=1&gid=2)
	var photoswipeParseHash = function(){
		var hash = window.location.hash.substring(1),
		params = {};

		if(hash.length < 5) {
			return params;
		}

		var vars = hash.split('&');
		for (var i = 0; i < vars.length; i++) {
			if(!vars[i]) {
				continue;
			}
			var pair = vars[i].split('=');  
			if(pair.length < 2) {
				continue;
			}           
			params[pair[0]] = pair[1];
		}

		if(params.gid) {
			params.gid = parseInt(params.gid, 10);
		}

		if(!params.hasOwnProperty('pid')) {
			return params;
		}
		params.pid = parseInt(params.pid, 10);
		return params;
	};

	var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL){
		var pswpElement = document.querySelectorAll('.pswp')[0],
			gallery,
			options,
			items;

		items = parseThumbnailElements(galleryElement);

		// define options (if needed)
		options = {
			index: index,

			// define gallery index (for URL)
			galleryUID: galleryElement.getAttribute('data-pswp-uid'),

			showHideOpacity:true,

			getThumbBoundsFn: function(index) {
				// See Options -> getThumbBoundsFn section of documentation for more info
				var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
					pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
					rect = thumbnail.getBoundingClientRect(); 

				return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
			},
			
			addCaptionHTMLFn: function(item, captionEl, isFake) {
				if(!item.title) {
					captionEl.children[0].innerText = '';
					return false;
				}
				captionEl.children[0].innerHTML = item.title;
				return true;
			},
			
			getImageURLForShare: function( shareButtonData ) { 
				return items[index].src || '';
			},
			
			getPageURLForShare: function( shareButtonData ) {
				return items[index].src || '';
			},
			
			getTextForShare: function( shareButtonData ) {
				return items[index].title || '';
			},
			
			// Parse output of share links
			parseShareButtonOut: function(shareButtonData, shareButtonOut) { 
				return shareButtonOut;
			}
		};
        
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        var radios = document.getElementsByName('gallery-style');
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                if(radios[i].id == 'radio-all-controls') {

                } else if(radios[i].id == 'radio-minimal-black') {
                    options.mainClass = 'pswp--minimal--dark';
                    options.barsSize = {top:0,bottom:0};
                    options.captionEl = false;
                    options.fullscreenEl = false;
                    options.shareEl = false;
                    options.bgOpacity = 0.85;
                    options.tapToClose = true;
                    options.tapToToggleControls = false;
                }
                break;
            }
        }

		if(disableAnimation) {
			options.showAnimationDuration = 0;
		}

		// Pass data to PhotoSwipe and initialize it
		gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
		gallery.init();
	};

	// loop through all gallery elements and bind events
	var galleryElements = document.querySelectorAll(gallerySelector);
	
	for(var i = 0, l = galleryElements.length; i < l; i++){
		galleryElements[i].setAttribute('data-pswp-uid', i+1);
		galleryElements[i].onclick = onThumbnailsClick;
	}

	// Parse URL and open gallery if it contains #&pid=3&gid=1
	var hashData = photoswipeParseHash();
	if(hashData.pid > 0 && hashData.gid > 0) {
		openPhotoSwipe( hashData.pid - 1 ,  galleryElements[ hashData.gid - 1 ], true, true );
	}
}