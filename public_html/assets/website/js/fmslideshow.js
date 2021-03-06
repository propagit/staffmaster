/*
	jQuery Homepage Banner Slideshow / Product viewer
 	Copyright (c) 2011 Subramanian 
	codecanyon.net/user/FMedia/
	
	Download Link: http://codecanyon.net/item/jquery-homepage-banner-slideshow-product-viewer/624759
	
	Version: 1.4 
	Release Date: 09 Dec 2011
	
	Built using: jQuery 		version:1.6.2	http://jquery.com/
	
	
*/

(function( $ ){

	function fmslideshow(selector, params){
		
		var defaults = $.extend({}, {
				
				// default variables
				
				banner_width : "",									// Banner width ( default value is 100% )
				banner_height : "",									// Banner height (default value is 100%)

				image_sprite : base_url + "assets/website/img/sprite.png",		// Navigation image path
				image_background : "",								// Background pattern image path
				image_topShadow : "",								// Top shadow pattern image path
				image_bottomShadow : "",							// Bottom shadow pattern image path
				image_loader : base_url + "assets/website/img/loader_img.png",	// Loader image path
				
				background_fullScreen : false,						// choose whether the background width is taken to browser width or not
				background_move : true,							// Enable/Disable background moving animation
				background_moveDistance : 1250,						// Background image moving distance
				
				dotButtons : true,									// Show or hide dotted buttons
				
				button_next_previous  : true,						// Show or hide Next previous buttons
				
				thumbnails_align : "BC",							// Thumbnail Align
				thumbnails_spacing : "0,0",							// Thumbnail Spacing
				
				buttons_type : 0,									// Choose the dot buttons type, choose the value 0, 1 or 2
				buttons_autoHide : true,							// Enable/Disable dot buttons auto hide
				buttons_align : "BC",								// Dot buttons alignment Options(TL, TC, TR, BL, BC, BR, LC, RC, C)
				buttons_spacing :"15,0",							// Dot buttons spacing, this value is corresponding to buttons_align
				
				button_nextPrevious_type : 0,						// Choose the Next Previous button type, choose the value 0, 1 or 2
				button_nextPrevious_autoHide : true,				// Enable/Disable Next Previous button auto hide

				button_next_align : "RC",							// Next button alignment Options(TL, TC, TR, BL, BC, BR, LC, RC, C)
				button_next_spacing : "20,0",						// Next button spacing, this value is corresponding to button_next_align
				button_previous_align : "LC",						// Previous button alignment Options(TL, TC, TR, BL, BC, BR, LC, RC, C)
				button_previous_spacing : "20,0",					// Previous button spacing, this value is corresponding to button_previous_align
				
				slideShow : true,									// Enable or disable the slideshow
				slideShow_delayTime : 3,							// Slideshow Delay time. setting 1 value is equal to one second
				slideShow_loop : true,	
				slideShowAutoStop : true,							// Slideshow play loop or not

				thumb_next_preious_width : 38,						// Thumbnail next previous
				
				default_data_align : "LC",							// Default Slideshow image/text alignment Options(TL, TC, TR, BL, BC, BR, LC, RC, C)
				default_data_spacing : "70,0",						// Default Slideshow image/text spacing, this value is corresponding to default_data_align
				default_data_inOutDirection : "LR",					// Default Slideshow image/text In/Out direction (any combination of direction will work)
				default_data_inOutDistance : "60",					// Default Slideshow image/text In/Out distance
				
				desktop_drag : false,								// Disable/Enable Desktop drag
				
				changeBackgroundColor : true						// Change background color for each Slide
				
				
			} , params);
		

		// IE Browser detection
		var IE8 = $.support.msie && parseInt($.support.version, 10) ==8 ? true : false;
		var IE7 = $.support.msie && parseInt($.support.version, 10) ==7 ? true : false;
		var IE6 = $.support.msie && parseInt($.support.version, 10) ==6 ? true : false;
		
		var curBanner = $(selector);
		var mainContainer;
		
		$(curBanner.children()).each(function() {
			if($(this).attr("id") == "fmslideshow"){
				mainContainer = $(this);
				mainContainer.removeAttr("id")
			}
		});
		
		mainContainer.removeClass();
		mainContainer.css({"width":"100%", "top":"0px" ,"position":"relative","overflow":"hidden","background-color":"#f0f"})
		$(mainContainer.children()).wrapAll('<div/>');
		var banSliders = $(mainContainer.children());
		banSliders.attr("id","fmslideshow");
	
		// Define Required variables 
		var spriteImg = defaults.image_sprite;
		var spriteImgWid = 0;
		var spriteImgHig = 0;
		
		var bannerWidth = defaults.banner_width;
		var curNo = 0;
		var curNoEle = 0;
		var cNo = 0;
		var preNoEle = 0;
		var fullScreen = false;
		var fullScreenChk = false;
		var navAlignCenter = false;
		var slideArr = [];
		var slideConArr = [];
		
		var aniSpd = 400;
		var fadeInTime = 500;
		var fadeOutTime = 200;
		var inTimer = 200;
		var outTimer = 100;
		var bgMoveDis = defaults.background_moveDistance;
		var bgMove = defaults.background_move;
		
		var easyType = "easeOutSine";
		var easyTypeOut = "easeInQuad";
		//var easyTypeBackground = "easeInOutQuad";
		var easyTypeBackground = "easeInBack";
		
		var desDrag = defaults.desktop_drag;
		
		var lodReqImg = [];
		var lodReqImgNum = 0;
		
		var ln = 0;
		var lns = -1;

		var tpShd;
		var btShd;
		
		var navHolder;
		var navArr = [];
		var navBtns;
		
		var slideShow = defaults.slideShow;
		var slideShowZ = slideShow;
		var delayTime = Number(defaults.slideShow_delayTime)*2500;
		var slideShowAutStop = defaults.slideShowAutoStop;
		var slideDelTim = [];
		var ssInt;
		
		var iconsType = Number(defaults.buttons_type) ? Number(defaults.buttons_type)>0 && Number(defaults.buttons_type)<3? Number(defaults.buttons_type) : 0:0;
		var btnWid = iconsType == 0 ? 24 : (iconsType == 1 ? 22 : 25);
		var btnHig = iconsType == 0 ? 24 : (iconsType == 1 ? 30 : 44);
		var btnYpos = iconsType == 0 ? 0 : (iconsType == 1 ? 39 : 80);
		var btnBgSpacing = iconsType == 1 ? 15 : iconsType == 2 ? 7 : 0;
		
		var rightBtn;
		var leftBtn;
		var autoplayLoop = defaults.slideShow_loop;
		var npBtnType = Number(defaults.button_nextPrevious_type)? Number(defaults.button_nextPrevious_type) : 0;
		
		/* Thumbnail Settings*/
		var showThumb = false;
		var thumbArr = [];
		
		//npBtnType = npBtnType == 1 ? 0 : (npBtnType == 2 ? 2 :1);
		
		var npBtnSiz = npBtnType == 2 ? 36 : (npBtnType == 0 ? 42 : 40);
		var npBtnYpos = npBtnType == 2 ? 0 : (npBtnType == 0 ? 35 : 80);
		

		var buttonsAlign = defaults.buttons_align.toUpperCase();
		var buttonsSpacing = defaults.buttons_spacing .split(",");
		
		var nBtnAlign = defaults.button_next_align.toUpperCase();
		var nBtnSpacing = defaults.button_next_spacing.split(",");

		var pBtnAlign = defaults.button_previous_align.toUpperCase();
		var pBtnSpacing = defaults.button_previous_spacing.split(",");
		
		var autoHide = defaults.button_nextPrevious_autoHide || defaults.buttons_autoHide;
		var autoHideNP = defaults.button_next_previous ? defaults.button_nextPrevious_autoHide : defaults.button_next_previous;
		var autoHideNavs = [];
		var autoHideBtns = defaults.dotButtons? defaults.buttons_autoHide : false;
		var loadingHolder;
		var loaderCirImg = defaults.image_loader ;
		
		var chgBgCol = defaults.changeBackgroundColor;
		var bgColr;
		var bgCo = [];

		if ('ontouchstart' in document.documentElement) {
			autoHideBtns = autoHideNP = false;
		}
		
		// Change the sprite image for IE6
		if(IE6){
			var spI2 = spriteImg.split(".");
			spriteImg = spI2[0]+"_ie6.gif";
		}

        var slideLoaded = [];
		var ii = -1;
		var hThumImg = [];

		$("<style type='text/css'> .cufon_fm{} </style>").appendTo(curBanner);
		curBanner.css({"background-position" : "0px 0px" , "visibility":"hidden"});
		
		if(defaults.banner_height != ""){
			banSliders.css({"height":defaults.banner_height});
		}
		
		banSliders.css({"position":"relative", "margin" : "0 auto", "visibility" : "hidden"});

		
		// Store each images and content on array variable slideConArr and slideArr

		$(banSliders.children()).each(function() {
			ii = ii+1;
			slideConArr[ii]=[];
            slideLoaded[ii] = false;
			slideArr[ii] = $(this);

			if(chgBgCol){
				bgCo[ii] = String(slideArr[ii].attr("data-backgroundColor")) != "undefined" ? slideArr[ii].attr("data-backgroundColor") : curBanner.css("background-color");
				//bgCo[0] ="url(./img/BG01.jpg)" ;
				//bgCo[1] ="url(./img/BG02.jpg)" ;
				//bgCo[2] ="url(./img/BG03.jpg)" ;
			}
			
			thumbArr[ii] = "";
			if(slideArr[ii].attr("data-thumb")){
				thumbArr[ii] = slideArr[ii].attr("data-thumb");
				slideArr[ii].removeAttr("data-thumb");
				showThumb = true;
			}
			
			slideDelTim[ii] = isNaN(slideArr[ii].attr("data-slideDelayTime")) ? delayTime : Number(slideArr[ii].attr("data-slideDelayTime"))*2500;

			var jj=-1;
			
			$(this).children().each(function() {
				var sel = $(this);

				jj = jj+1;

				if(sel.get(0).nodeName.toUpperCase() == "A"){
					sel = sel.children();
				}
				sel.wrap('<div />');
				
				sel.css({"position": "absolute"});


				if(sel.attr("data-align")){
					sel.parent().data('data-align', sel.attr("data-align").toUpperCase());
				}else{
					sel.parent().data('data-align', defaults.default_data_align.toUpperCase());
					sel.removeAttr("data-align")
				}
				
				if(sel.attr("data-spacing")){
					sel.parent().data('spacingObj',  sel.attr("data-spacing"));
				}else{
					sel.parent().data('spacingObj',  defaults.default_data_spacing);
					sel.removeAttr("data-spacing")
				}
				
				if(sel.attr("data-inOutDirection")){
					sel.parent().data('inOutDirection', sel.attr("data-inOutDirection").toUpperCase());
				}else{
					sel.parent().data('inOutDirection', defaults.default_data_inOutDirection.toUpperCase());
					sel.removeAttr("data-inOutDirection")
				}
				
				if(sel.attr("data-inOutDirection")){
					sel.parent().data('inOutDistance',  sel.attr("data-inOutDistance"));
				}else{
					sel.parent().data('inOutDistance',   defaults.default_data_inOutDistance);
					sel.removeAttr("data-inOutDistance")
				}
				
				if(sel.attr("data-startTime")){
					sel.parent().data('startTime',  Number(inTimer)*Number(sel.attr("data-startTime")));
					
				}else{
					sel.parent().data('startTime',   (inTimer*jj));
					sel.removeAttr("data-startTime")
				}
				
				if(sel.attr("data-stayTime")){
					sel.parent().data('endTime',  Number(inTimer)*Number(sel.attr("data-stayTime")));
					
				}else{
					sel.parent().data('endTime',   "undefined");
					sel.removeAttr("data-stayTime")
				}
				
				if(sel.attr("data-easeIn")){
					sel.parent().data('easeIn',  sel.attr("data-easeIn"));
				}else{
					sel.parent().data('easeIn',   easyType);
					sel.removeAttr("data-easeIn")
				}
	
				if(sel.attr("data-easeOut")){
					sel.parent().data('easeOut',  sel.attr("data-easeOut"));
				}else{
					sel.parent().data('easeOut',   easyTypeOut);
					sel.removeAttr("data-easeOut")
				}
				
				if(sel.attr("data-animationSpeed")){
					sel.parent().data('speed',  sel.attr("data-animationSpeed"));
				}else{
					sel.parent().data('speed',   aniSpd);
					sel.removeAttr("data-animationSpeed")
				}
				
				sel.find('.video').each(function() {
					sel.parent().data('video',   this);
					$(this).remove();
				});	
				
				// set background transparency for text area
				
				if(sel.children().length>1){
					var bgSel;
					var isBg = false;
					var dd;
					sel.children().each(function() {
						dd = $(this);
						if(dd.attr("id") == "bg"){
							bgSel = dd;
							isBg = true;
						}else{
							if(isBg){
								dd.css({"position":"relative"});
							}
						}
					});
					
					if(isBg){
						if(!IE6){
							bgSel.css({"width":"100%", "height":"100%", "position":"absolute"});
						}else{
							bgSel.css({"width":"100%", "height":dd.height()+12+"px", "position":"absolute"});
						}
					}
				}
				
				// ----
				
				if(sel.html() == "" ){
					sel.parent().data('img-src', sel.attr("src"));
					sel.attr("src","");
					sel.parent().css({
									"overflow":"hidden",
									"background-repeat":"repeat-x",
									"background-position":"center center",
									"position":"absolute",
									"visibility":"hidden"									
									});
					sel.parent().append('<div />');
					slideConArr[ii][jj]=(sel.parent());
				}else{
					sel.parent().css({
									"width":sel.width(),
									//"width":"100%",
									"height":sel.height(),
									//"height":"100%",
									"position": "absolute"
									});
				}
				
				slideConArr[ii][jj]= (sel.parent());
				if(sel.html() == "" ){sel.remove();}
				slideConArr[ii][jj].css({"visibility":"hidden"});
					
			});
				
		});
				
		banSliders.find('.nonDraggable').bind("mousedown", function(e) {				
			strDrg = false;
			e.stopImmediatePropagation();
		});
				
		if(!this.hasTouch) {
			
			if(desDrag){
				curBanner.addClass("fm_drag-cursor");
				banSliders.children().find('a').bind('click', function(e) {		
					if(!strDrg) {			
						e.preventDefault();						
						return false;
					}						
				});
			}

		} else {

			banSliders.children().find('a').each(function() {
				
				var ths = $(this);
				ths.attr('href', '#');

				
				ths.bind('click',{aLink:ths.attr('href'), aTarget:ths.attr('target')}, function(e) {						
					e.preventDefault();	
					if(!strDrg) {							
						return false;
					} else {							
						if(!e.data.aTarget || e.data.aTarget.toLowerCase() == '_self') {
							window.location.href = e.data.aLink;
						} else {
							window.open(e.data.aLink);
						}							
					}					
				});
			});	
			
		}

		
		$(banSliders.children()).wrapAll('<div />');
		var allSli = $(banSliders.children());
		allSli.css({"position":"absolute","left":"0px", "visibility":"visible", "width":"100%","height":banSliders.height()+"px"});

		if(IE7 || IE6){
			curBanner.prepend('<div />');
			allSli = curBanner.children(':first-child');
			allSli.css({"position":"absolute", "left":"0px", "visibility":"visible"});
		}
		
		
		if(chgBgCol){
			curBanner.prepend('<div />');
			bgColr = curBanner.children(':first-child');
			//bgColr.css({"position":"absolute","visibility":"visible","width":"100%","height":"100%","background-color":bgCo[0]});
			//bgColr.css({"position":"absolute","visibility":"visible","width":"100%","height":"100%","background-image":"url(./img/new_bg1.jpg)"});
			bgColr.css({"position":"absolute","visibility":"visible","width":"100%","height":"100%","background":bgCo[0],"background-position":"center"});
			bgColr.css({"opacity":0});
		}
			
		// store required image on array for preload
		
		if(!defaults.background_fullScreen){ 
			//curBanner.css({"width":bannerWidth+"px"}); 
			curBanner.css({"width":"100%"}); 
		}

		if(defaults.image_background != ""){ 
			lodReqImg.push(defaults.image_background); 
		}
		
		if(defaults.image_topShadow !=""){ 
				lodReqImg.push(defaults.image_topShadow );
		}
		
		if(defaults.image_bottomShadow!=""){ 
				lodReqImg.push(defaults.image_bottomShadow); 
		}
			
		if(loaderCirImg!=""){ 
			lodReqImg.push(loaderCirImg); 
		}
		
		lodReqImg.push(spriteImg);


		var sHigT = 0;
		var sHigB = 0;
	
		// Load the required images
		
		var startReqImgLoad = function (){
            
			if(lodReqImgNum<lodReqImg.length){

                var _im =$("<img />");
                _im.hide();
                _im.bind("load",function(){
					if(lodReqImg[lodReqImgNum] == defaults.image_topShadow ){ sHigT = _im.height();}
					if(lodReqImg[lodReqImgNum] == defaults.image_bottomShadow){ sHigB = _im.height();}
					if(lodReqImg[lodReqImgNum] == spriteImg){ spriteImgWid = _im.width(); spriteImgHig = _im.height();}
					$(this).remove();
					lodReqImgNum++;
					startReqImgLoad();
                }).error(function () { 
					$(this).remove();
					lodReqImgNum++;
					startReqImgLoad();
				});
				
                banSliders.append(_im);
                _im.attr('src',lodReqImg[lodReqImgNum]);

			} else {
								
				// create background, top shadow and bottom shadow
				
                curBanner.css({"visibility":"hidden"});
				curBanner.css({"display": "none"});
				curBanner.prepend('<div ></div>');
				
				tpShd = curBanner.children(':first-child');
				tpShd.css({"width":"100%","height":sHigT+"px","z-index":1,
							"position":"absolute","top":"0px","left":"0px",
							"background-repeat":"repeat-x"});
			
	
				curBanner.prepend('<div ></div>');
				btShd = curBanner.children(':first-child');
				btShd.css({"width":"100%","height":sHigB+"px","z-index":2,
							"position":"absolute","bottom":"0px","left":"0px",
							 "background-repeat":"repeat-x"});
							 
				if(IE6){ btShd.css({"bottom":-sHigB+"px"}); }
				if(defaults.image_background!=""){curBanner.css({"background-image":"url("+defaults.image_background+")", "background-position":"0px" });	}
				if(defaults.image_topShadow !=""){	tpShd.css({"background-image":"url("+defaults.image_topShadow +")"});	}
				if(defaults.image_bottomShadow!=""){	btShd.css({"background-image":"url("+defaults.image_bottomShadow+")"});	}
				
				curBanner.css({"visibility":"visible"});	
				curBanner.fadeIn(aniSpd);
				processBanner();
                createButton(btnWid, btnHig, slideArr.length);
				loadSlider();
				if(showThumb){
					thumbCreate();
				}
				
				var intr;
				$(window).resize(function() {
					clearInterval(intr);
					intr = setInterval(function(){clearInterval(intr);windowRez();},200);
				});
			
			}

		};
		
		
		// Start processing the slideshow

		var processBanner = function ()	{
			
			if((curBanner.css("width")=="0px" || curBanner.css("width")=="auto") && bannerWidth == 0){
				//bannerWidth = parseInt(curBanner.css("width"));
				bannerWidth = "100%";
			}


			if(bannerWidth > $(window).width()){
				banSliders.css("width","100%");
			}else{
				//banSliders.css("width",bannerWidth+"px");
				banSliders.css("width","100%");
			}
		
			if(!fullScreenChk){
				fullScreenChk = true;
				if(parseInt(banSliders.css("height")) == 0){
					fullScreen = true;
					banSliders.css("height",$(window).height()+"px");
				}
			}
		
			
			var eleNos=slideConArr.length;
			
			for(var cn=0; cn<slideConArr.length; cn++){
				$(slideConArr[cn]).css("z-index",eleNos);
                for (var idNo=0; idNo < slideConArr[cn].length; idNo++){
					(slideConArr[cn][idNo]).css({"width":"auto","height":"auto"});
				     setImagePos(cn, idNo);
                 }
            }

			curBanner.prepend('<div />');
			navHolder = curBanner.children(':first-child');
			navHolder.css({"position":"absolute","z-index":2});
			
			navHolder.append('<div />');
			navBtns = $(navHolder.children(":first-child"));
			
			navHolder.css({"display":"none"});
			
			
			// Create a loading objects
			
            banSliders.prepend('<div />');
			loadingHolder = banSliders.children(":first-child");
            loadingHolder.css({"position":"absolute", "height":"18px",  "z-index":eleNos+6, "visibility":"visible", "display":"none"});
            loadingHolder.prepend('<div />');
	
			var loadingbar = loadingHolder.children(":first-child");
			loadingbar.css({"position":"absolute", "width":"22px", "height":"18px", "overflow":"hidden"});
			loadingbar.prepend('<div />');
			var loaderIm  = loadingbar.children(":first-child");
			loaderIm.css({"position":"absolute", "width":"22px", "height":"200px", "top":"0px", "left":"0px"});
			if ($.support.msie){
				loaderIm.css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+loaderCirImg+", sizingMethod='noscale')"});
			}else{
				 loaderIm.css({"background-image" : "url("+loaderCirImg+")"});
			}

			alignObject(loadingHolder,"C",[0,-11],
				(parseInt(banSliders.width())-parseInt(loadingHolder.width())),(parseInt(mainContainer.height())-parseInt(loadingHolder.height())));
			loadingHolder.fadeIn(500);
			loadAniStart(loaderIm);
			
				
		};
		
		// Window resize function
		
		var windowRez = function (){
			
			if(fullScreen){ 
				if(bannerWidth > $(window).width()){ 
					banSliders.css("width","100%");
					allSli.css("width","100%");
				}else{ 
					banSliders.css("width",bannerWidth+"px"); 
					allSli.css("width",bannerWidth+"px"); 
					//banSliders.css("width","100%");
					//allSli.css("width","100%");
				}
			}
			

			if(navAlignCenter){ 
				navHolder.css({"left":Math.round((parseInt(banSliders.width())-parseInt(navHolder.width()))/2)+"px"}); 
			}
 
            for (var idNo=0; idNo < slideConArr[selId].length; idNo++){  
				setImagePos(selId, idNo); 
			}
				 
			if(rightBtn && leftBtn){
				alignObject(rightBtn,nBtnAlign,nBtnSpacing,
				(parseInt(mainContainer.width())-parseInt(rightBtn.width())),(parseInt(banSliders.height())-parseInt(rightBtn.height())));
	
				alignObject(leftBtn,pBtnAlign,pBtnSpacing,
				(parseInt(mainContainer.width())-parseInt(leftBtn.width())),(parseInt(banSliders.height())-parseInt(leftBtn.height())));
			}
			
			if(navHolder){
				alignObject(navHolder,buttonsAlign,buttonsSpacing,
				(parseInt(mainContainer.width())-parseInt(navHolder.width())),(parseInt(banSliders.height())-parseInt(navHolder.height())));
			}
			
			if(loadingHolder){
				alignObject(loadingHolder,"C",[0,-11],
				(parseInt(mainContainer.width())-parseInt(loadingHolder.width())),(parseInt(banSliders.height())-parseInt(loadingHolder.height())));
			}

		};


		// Loading animation functions
		
		var loadAniStart = function (sel){
			loaderIntr = setInterval(function(){loadingAni(sel);},30);
		};

		var loaderIntr;
		var val = 0;	
		var loadingAni = function(sel){
			val = val < 162 ? val+18 : 0;
			sel.css({"top":-val+"px"});
		};
		
		
		// Load the slideshow images
		
		var loadSlider = function (){

			lns++;
			if(lns >= slideConArr[ln].length){
				lns=0;
                slideLoaded[ln] = true;
				ln++;
			}
			
			
			// If first slide images load finished, than start the slideshow to display

			if(ln == 1 && lns == 0){
				loadingHolder.fadeOut(300);
				banSliders.css({"display":"show"});

				
				for(var na=0; na<autoHideNavs.length; na++){
					autoHideNavs[na].show();
					autoHideNavs[na].fadeTo("fast", 1); 
				}	

				if(autoplayLoop){ 
					leftBtn.show();
					leftBt.fadeTo("fast",1);
				}else{
					leftBtn.fadeTo("fast",.2); 
					
				}
				
				curBanner.bind('mousedown', function() {
					
					tmRevMov = false;
					if(desDrag){
						curBanner.removeClass("fm_drag-cursor");
						curBanner.addClass("fm_draging-cursor");
						mouseDragInit();
					}
			
				});
				
				navHolder.css({"visibility":"visible"});

				for(na=0; na<autoHideNavs.length; na++){
					autoHideNavs[na].fadeTo("slow", 0);
				}
				banSliders.hide();
				banSliders.fadeIn(500,function(){		
					startAni(0,true);
				});
						
				slideShowFn();
				
				if(chgBgCol){
					bgColr.animate({"opacity":1});
				}

			}
            
			if(ln < slideConArr.length ){ 
				loadImg(); 
			}else{ 
				// Remove the loading object after all images are loaded
				loadingHolder.fadeOut(300,function(){loadingHolder.remove();}); 
				
			}
			
		};
		
		var itsLod = false;
		var itsIntr;
		
		var itsLodChk = function(){
			clearInterval(itsIntr); 
			if(itsLod){
				itsLod = false;
				loadSlider();
			}else{
				itsIntr = setInterval(function(){itsLodChk();},20);
			}
		};
		
		// Load image function
		var loadImg = function (){

			var sel1 = (slideConArr[ln][lns]);
			var sel2 = ((sel1.children()));
				
			if(sel1.text() == ""){

                var _im =$("<img>");
				_im.hide();
                _im.bind("load",function(){

                    sel1.css({
							//"width":_im.width()+"px",
							"width":"100%",
							"height":_im.height()+"px"
							});

					sel2.css({
							//"width":_im.width()+"px",
							"width":"100%",
							"height":_im.height()+"px"
							});
							
                   // If IE than load the image using filter 
					if ($.support.msie) {
						sel2.css({"background-image":"url("+sel1.data("img-src")+")", "background-position":"center"});
						//sel2.css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+sel1.data("img-src")+", sizingMethod='noscale')"});
					}else{
						sel2.css({"background-image":"url("+sel1.data("img-src")+")", "background-position":"center"});
					}

                    $(this).remove();
					itsLod = true;

                }).error(function () {

                    sel1.css({
							"width":_im.width()+"px",
							//"width":"100%",
							"height":_im.height()+"px"
							});
					sel2.css({
							"width":_im.width()+"px",
							//"width":"100%",
							"height":_im.height()+"px"
							});
                    $(this).remove();
					itsLod = true;
                 
                 });
                banSliders.append(_im);
                _im.attr('src',sel1.data("img-src"));
				
			}else{
				itsLod = true;
			}
			
			itsIntr = setInterval(function(){itsLodChk();},20);

		};
	
		// Start slide animation function

		var startAni = function (sId,sho){
			
			for(var s=0; s<sliderInTimer.length; s++){
				clearInterval(sliderInTimer[s]);
			}
			for(var p=0; p<sliderOutTimer.length; p++){
				clearInterval(sliderOutTimer[p]);
			}

			preNoEle = curNoEle = 0;
			
			if(sho){
				
				if(chgBgCol){
					if(bgColr.css("opacity") == 0){
						//bgColr.css({"background-color":bgCo[cNo]});
						bgColr.css({"background-image":bgCo[cNo],"background-position":"center"});
						bgColr.animate({"opacity":1});
						//bgColr.animate({"opacity":1,"left": "-=50px"},slow);
					}else{
						//curBanner.css({"background-color":bgCo[cNo]});
						curBanner.css({"background-image":bgCo[cNo],"background-position":"center"});
						bgColr.animate({"opacity":0});
					}
				}
				allSli.stop();
				allSli.css({"left":"0px","opacity":1});		
				for (var i=0; i < slideConArr[curNo].length; i++){
					inTimerStart(i);
				}
				
			}else{
				
				// Background image Horizontal moving animation
				
				if(bgMove ){
					if(drgPosDir == 0){
						if ($.support.msie) {
							if( cNo>sId){
								curBanner.animate({"background-position-x": "+=1000"+"px"},{queue:false, duration:bgMoveDis, easing: easyTypeBackground});
							}else{
								curBanner.animate({"background-position-x": "-=1000"+"px"},{queue:false, duration:bgMoveDis, easing: easyTypeBackground});
							}
						}else{
							if( cNo>sId){
								curBanner.animate({"background-position": "+=1000"+"px"},{queue:false, duration:bgMoveDis, easing: easyTypeBackground});
							}else{
								curBanner.animate({"background-position": "-=1000"+"px"},{queue:false, duration:bgMoveDis, easing: easyTypeBackground});
							}					
						}
					}else{
						curBanner.animate({"background-position": "-="+ (drgPosDir*1000)+""+"px"},{queue:false, duration:bgMoveDis, easing: easyTypeBackground});
					}
					
					drgPosDir = 0;
				}
				
				cNo = sId;

				if(allSli.css("opacity") == 1){
					for (var j=0; j < slideConArr[curNo].length; j++){
						if($(slideConArr[curNo][j]).data("endTime") == "undefined" || clsAllSli){
							if(slideConArr[curNo][j].css("visibility") == "visible"){
								outTimerStart(j, (outTimer));
							}else{
								curNoEle++;
								if(curNoEle >= slideConArr[curNo].length){
									endFadeAllNextToFade();
								}
							}
						}
					}
				}else{
					curNoEle = slideConArr[curNo].length;
					outTimerStart(slideConArr[curNo].length-1, 0);
				}
				

			}
		
		};
	
		// Align and position the image and text function 
		
        var setImagePos = function (cn,sn){
				var sel1 = $(slideConArr[cn][sn]);
				var sel2 = $(slideConArr[cn][sn-1]);

				sel1.css({"left":"auto", "right":"auto", "top":"auto", "bottom":"auto"});
				
				var imgAli = String(sel1.data("data-align"));
				var spacing=[];
					spacing[0] = spacing[1] = 0;

				if(String(sel1.data("spacingObj")) != "undefined"){
					spacing = sel1.data("spacingObj").split(",");
					spacing[0] = isNaN(spacing[0]) ? 0 : spacing[0];
					spacing[1] = isNaN(spacing[1]) ? 0 : spacing[1];
				}

                 sel1.show();

				alignObject(sel1,imgAli,spacing,parseInt(banSliders.width())-parseInt(sel1.width()),parseInt(banSliders.height())-parseInt(sel1.height()));

              if(sel1.children(":first-child").text() != ""){
				    sel1.children(":first-child").css({"position":""});
			    }
				if((sel1.data("data-align") == sel2.data("data-align"))){
					
					if((sel1.children(":first-child").html() != "")){
						if(imgAli.substring(0,1)=="B"){
							sel1.css({"bottom" : Number(sel2.data("pB"))- Number(sel1.height())-Number(spacing[0])+"px"});	
						}else{
							if(!isNaN(sel2.height())){
							if(imgAli =="LC" || imgAli =="RC" ){
								sel1.css({"top" : Number(sel2.data("pT"))+ Number(sel2.height())+Number(spacing[1])+"px"});
							}else{
								sel1.css({"top" : Number(sel2.data("pT"))+ Number(sel2.height())+Number(spacing[0])+"px"});
							}
							}
						}
						
					}else{
						if((sel1.children(":first-child").html() == "") ){
							if(imgAli.substring(0,1)=="L"){
								sel1.css({"left" : Number(sel2.data("pL"))+ Number(sel2.width())+Number(spacing[0])+"px"});
							}else{
								sel1.css({"right" : Number(sel2.data("pR"))- Number(sel1.width())-Number(spacing[0])+"px"});
							}
						}
					}
				}

			 	if((sel1.children(":first-child").html() != "") ){
					sel1.data({"pT":parseInt(sel1.css("top"))});
					sel1.data({"pB":parseInt(sel1.css("bottom"))});
				}
				if((sel1.children(":first-child").html() == "") ){
					sel1.data({"pL":parseInt(sel1.css("left"))});
					sel1.data({"pR":parseInt(sel1.css("right"))});
				}
				
		};
		
		// Each slide start animate using the below function
		
		var displaySlide = function (idNo, sho){
			
			var sel1 = $(slideConArr[curNo][idNo]);
            var aniComeSpc = isNaN(sel1.data("inOutDistance")) ? 50 : Number(sel1.data("inOutDistance"));
			var aniDir = String(sel1.data("inOutDirection"));
            var temZ = 0;
			
			if(sho && sel1.text() != "" && !sel1.data("cufon") && typeof Cufon != 'undefined'){
					sel1.data("cufon",true);
					sel1.css({"visibility":"visible"});
					sel1.show();
					Cufon.replace(sel1.find(".cufon_fm"));
					sel1.hide();
			}
			
            setImagePos(curNo,idNo);

			if(sho){
				
				if(sel1.data("video")){
					sel1.prepend(sel1.data("video"))
				}
				
				slideArr[curNo].css({"visibility":"visible" , "display":"show"});
				if(aniDir.substring(0,1)=="T" || aniDir.substring(0,1)=="B"){

					if(sel1.css("top") != "auto"){
						temZ = parseInt(sel1.css("top"));
						if(aniDir.substring(0,1)=="T"){
							sel1.css({"top" : temZ-Number(aniComeSpc)+"px"});
						}else{
							sel1.css({"top" : temZ+Number(aniComeSpc)+"px"});
						}
						sel1.animate({"top"     : temZ+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeIn")});
					}else{
						temZ = parseInt(sel1.css("bottom"));
						if(aniDir.substring(0,1)=="T"){
							sel1.css({"bottom" : temZ+Number(aniComeSpc)+"px"});
						}else{
							sel1.css({"bottom" : temZ-Number(aniComeSpc)+"px"});
						}
						sel1.animate({"bottom"     : temZ+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeIn")});
					}
				}

				temZ = 0;

				if(aniDir.substring(0,1)=="L" || aniDir.substring(0,1)=="R"){
					if(sel1.css("left") != "auto"){
						temZ = parseInt(sel1.css("left"));
						if(aniDir.substring(0,1)=="L"){
							sel1.css({"left" : temZ-Number(aniComeSpc)+"px"});
						}else{
							sel1.css({"left" : temZ+Number(aniComeSpc)+"px"});
						}
						sel1.animate({"left"     : temZ+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeIn")});

					}else{
						temZ = parseInt(sel1.css("right"));
						if(aniDir.substring(0,1)=="R"){
							sel1.css({"right" : temZ-Number(aniComeSpc)+"px"});
						}else{
							sel1.css({"right" : temZ+Number(aniComeSpc)+"px"});
						}
						sel1.animate({"right"     : temZ+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeIn")});
					}
				}

				if(!IE8 || sel1.text() == ""){
					sel1.css({"display":"none"});
					sel1.css({"visibility":"visible"});
					//aniSpd_ = (IE7) ? 200 : fadeInTime;
					sel1.fadeIn(aniSpd_);
				}else{
					sel1.css({"display":"show"});
					sel1.css({"visibility":"hidden"});
					fadeInIe8(sel1.get(0));
				}
				
				if(curNo != cNo){
					if(preNoEle >= slideConArr[curNo].length){
						preNoEle = 0;
						curNo = cNo;
						startAni(curNo,false);
					}
				}else{
					
					if(sel1.data("endTime") != "undefined" && !clsAllSli){
						outTimerStart(idNo,sel1.data("endTime"));
					}else{
						preNoEle++;
					}	
					fadeoutAllSlideCon();
				}
					
			}else{
					
				if(aniDir.substring(1,2)=="T" || aniDir.substring(1,2)=="B"){
					if(sel1.css("top") != "auto"){
						temZ = parseInt(sel1.css("top"));
						if(aniDir.substring(1,2)=="T"){							
							sel1.animate({"top"     : temZ-Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}else{
							sel1.animate({"top"     : temZ+Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}
								
					}else{
						temZ = parseInt(sel1.css("bottom"));
						if(aniDir.substring(1,2)=="T"){
							sel1.animate({"bottom"     : temZ+Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}else{
							sel1.animate({"bottom"     : temZ-Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}
					}
				}
		
				if(aniDir.substring(1,2)=="L" || aniDir.substring(1,2)=="R"){
					if(sel1.css("left") != "auto"){
						temZ = parseInt(sel1.css("left"));
						if(aniDir.substring(1,2)=="L"){	
							sel1.animate({"left"     : temZ-Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}else{
							sel1.animate({"left"     : temZ+Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}	
					}else{
						temZ = parseInt(sel1.css("right"));
						if(aniDir.substring(1,2)=="R"){
							sel1.animate({"right"     : temZ-Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}else{
							sel1.animate({"right"     : temZ+Number(aniComeSpc)+"px"},{queue:false, duration:Number(sel1.data('speed')), easing: sel1.data("easeOut")});
						}
					}
				}

				var aniSpd_ = (!IE8 || sel1.text() == "") ? fadeOutTime : 300;
				sel1.fadeOut(aniSpd_,function(){
										sel1.css({"display":"show"});
										sel1.css({"visibility":"hidden"});
										curNoEle++;
										if(curNoEle >= slideConArr[curNo].length && (curNo != cNo || clsAllSli)){
											endFadeAllNextToFade();
										}			
								
					}
									
				);
				
				if(sel1.data("endTime") != "undefined" && !clsAllSli){
					preNoEle++;
					fadeoutAllSlideCon();
				}	
				

			}
		};
	
		var endFadeAllNextToFade = function(){
			curNoEle = 0;
			curNo = cNo;
			for(var jj=0; jj<slideArr.length; jj++){
				for (var ii=0; ii < slideConArr[jj].length; ii++){
					slideConArr[jj][ii].css({"visibility":"hidden","display":"none"});
				}
			}
			slideArr[curNo].css({"visibility" : "visible"});
			clsAllSli = false;
			startAni(curNo,true);
		};
	
		var fadeoutAllSlideCon = function(){
			clearInterval(ssInt);
			if(preNoEle >= slideConArr[curNo].length){
				
				if(slideShowZ){
					ssInt = setInterval(function(){nexSlide()},slideDelTim[curNo]); 
				}
			}
		};
		
		// set timer to start/end each slide to animate 
		
		var sliderInTimer = [] ;
		var sliderOutTimer = [] ;
		var chkInt ;
		var selId=0;
		var clsAllSli = false;
		
		var inTimerStart = function (i){
			var sel = $(slideConArr[curNo][i]);
			clearInterval(sliderInTimer[i]);
			sliderInTimer[i] = setInterval(function(){inTimerFn(i)},sel.data("startTime"));	
		};
		
		var outTimerStart = function (j, tim){
			clearInterval(sliderOutTimer[j]);
			sliderOutTimer[j] = setInterval(function(){outTimerFn(j)},tim);
		};
		
		var inTimerFn = function (i){
			clearInterval(sliderInTimer[i]);
			displaySlide(i, true);
		};
		
		var outTimerFn = function (j){
			clearInterval(sliderOutTimer[j]);
			displaySlide(j, false);
			
		};
		
		// Timer to check the each slide whether it load it or not
		
		var chkSliFin = function (){
			clearInterval(ssInt);
			if(slideLoaded[selId] ){
				if(curNo!=selId|| slideConArr.length == 1){	
					preNoEle = 0;
					clearInterval(chkInt);
					banSliders.find('.video').each(function() {
						$(this).remove();
					});
					startAni(selId,false);
					if(loadingHolder){ loadingHolder.fadeOut(300); }
				}
			}
			if(!slideLoaded[selId]){
				if(loadingHolder){ loadingHolder.fadeIn(300); }
			}
        };
		
		// Function to call next and previous slide
		
		var nexSlide = function(){
			if(selId < slideConArr.length-1){
				showSlide(Number(selId)+1);
			}else{
				if(autoplayLoop){
					showSlide(0);
				}else{
					allSli.stop();
					allSli.animate({"left":"0px"});
				}
			}
		};
		
		var preSlide = function(){
			if( selId > 0){
				showSlide(Number(selId)-1);
			}else{
				if(autoplayLoop){
					showSlide(slideConArr.length-1);
				}else{
					allSli.stop();
					allSli.animate({"left":"0px"});
				}
			}
		};
		
		var showSlide = function(ii){

			clsAllSli = true;
			navArr[selId].css({"background-position":0+"px "+ -btnYpos+"px"});
			selId = ii;
			navArr[selId].css({"background-position":-(btnWid*2)+"px "+ -btnYpos+"px"});
			
			rightBtn.data("hid",false);
			leftBtn.data("hid",false);
			rightBtn.css({"cursor":"pointer"});
			leftBtn.css({"cursor":"pointer"});

			
			if((!(Number(selId) > slideConArr.length-2 && Number(selId) < 1)) &&  !slideShowZ || !autoHideNP){
				rightBtn.fadeTo("fast", 1); 
				leftBtn.fadeTo("fast", 1); 
			}

			if(!autoplayLoop){
				if(selId > slideConArr.length-2){
					rightBtn.children(":first-child").css({"right":0+"px ","bottom":-npBtnYpos+"px"});
					rightBtn.data("hid",true);
					rightBtn.css({"cursor":"auto"});
					if(!slideShowZ || !autoHideNP){ rightBtn.fadeTo("fast", 0.2); leftBtn.fadeTo("fast", 1);}
				}
				
				if(selId < 1){
					leftBtn.data("hid",true);
					leftBtn.children(":first-child").css({"left":0+"px ","bottom":-npBtnYpos+"px"});
					leftBtn.css({"cursor":"auto"});
					if(!slideShowZ || !autoHideNP){ leftBtn.fadeTo("fast", 0.2); rightBtn.fadeTo("fast", 1); }
				}
			}
			
			if(showThumb){
				
				thumbSel[cNo].children(':first-child').children(':last-child').removeClass("tint-over");
				thumbSel[cNo].children(':first-child').children(':last-child').addClass("tint-normal");
				
				thumbSel[selId].children(':first-child').children(':last-child').removeClass("tint-normal");
				thumbSel[selId].children(':first-child').children(':last-child').addClass("tint-over");
				
				thumbSel[cNo].removeClass("thumb-over");
				thumbSel[cNo].addClass("thumb-normal");
				
				thumbSel[selId].removeClass("thumb-normal");
				thumbSel[selId].addClass("thumb-over");

				if(!thClick){
					
					thumbMain.data("pos",-parseInt(thumbSel[selId].css("left"))+(Math.floor(noThuShow/2)*(thWid+thSpa)));
					
					enableDisableBtn(thumbContainer.data("rBtnTh"),true) ;
					enableDisableBtn(thumbContainer.data("lBtnTh"),true) ;
					
					if(thumbMain.data("pos") > -1){
						enableDisableBtn(thumbContainer.data("lBtnTh"),false) ;
						thumbMain.data("pos",0);
					}
						
					if(thumbMain.data("pos") < -((thumbMain.width()-thumbContainer.width()))+(thWid+thSpa)){
						enableDisableBtn(thumbContainer.data("rBtnTh"),false) ;
					}
					
					if(thumbMain.data("pos") < -(thumbMain.width()-thumbContainer.width())){ 
						thumbMain.data("pos",-(thumbMain.width()-thumbContainer.width()))
					}
					
					thMovSpd = 500;
					thumbMain.stop();
					thumbMain.animate({"left":thumbMain.data("pos")+"px"},{queue:false, duration:thMovSpd, easing: "easeInOutQuad"});
				
				}
			}
				
			clearInterval(ssInt);
			chkInt = setInterval(function(){chkSliFin()},27);
			
		};
		
		
		// Slideshow function
		
		var slideShowFn = function(){
			
				clearInterval(ssInt);
				
				if(!defaults.dotButtons){
					navHolder.css({"visibility":"hidden"});
					navBtns.css({"visibility":"hidden"});
				}else{
					if(!autoHideBtns){ 
					if ($.support.msie){ 
						navHolder.show();
					}else{
						navHolder.fadeIn();
					} 
				}
				}
				
				if(!defaults.button_next_previous){
					rightBt.css({"visibility":"hidden"});
					leftBt.css({"visibility":"hidden"});
				}else{
					if(!autoHideNP){  
						if ($.support.msie){ 
							rightBtn.show(); 
						}else{ 
							rightBtn.fadeIn();
						} 
					}
				}
				
				if(slideShow ||autoHide ){
					curBanner.bind('mouseover mouseleave', function(ev) {	
						slideAutoHide(String(ev.type));
					});
				}
				
				if(!defaults.dotButtons){
					navHolder.css({"visibility":"hidden"})
				}
				
		};
		
		var slideAutoHide = function(typ){
		
		
			if(typ == "mouseover"){
				if(slideShow && slideShowAutStop){
					slideShowZ = false;
					clearInterval(ssInt);
				}
				if(autoHide){ 
					if ($.support.msie){
						navHolder.fadeIn(100);
					}
					for(var na=0; na<autoHideNavs.length; na++){
						autoHideNavs[na].stop();
						if (!autoHideNavs[na].data("hid")) {
							autoHideNavs[na].fadeTo("fast", 1); 
							autoHideNavs[na].show();
						}else{
							if(autoplayLoop){
								autoHideNavs[na].fadeTo("fast", 1); 
								autoHideNavs[na].show();
							}else{
								autoHideNavs[na].fadeTo("fast", .2);
							}
						}
					}
				}
				
			}else{
				
				if ($.support.msie && autoHideBtns){
					navHolder.fadeOut(100);
				}
				
				if(slideShow && slideShowAutStop){
					slideShowZ = true;
					thClick = false;
					fadeoutAllSlideCon();
				}
				if(autoHide){ 
					for(na=0; na<autoHideNavs.length; na++){
						autoHideNavs[na].stop();
						autoHideNavs[na].fadeTo("fast", 0);			
					}
				}
				
			}
	
		};
		
		// Align the image and text using the below function
		
		var alignObject = function (sel,ali,spc,cWid,cHig){
			
			if(ali == "TL"){
				sel.css({"top" : spc[0]+"px"});
				sel.css({"left" : spc[1]+"px"});
			}
			
			if(ali == "TC"){
				sel.css({"top" : spc[0]+"px"});
				sel.css({"left" : Number(cWid/2)+Number(spc[1])+"px"});
			}
		
			if(ali == "TR"){
				sel.css({"top" : spc[0]+"px"});
				sel.css({"right" : spc[1]+"px"});
			}
			
			if(ali == "LC"){
				sel.css({"left" : spc[0]+"px"});
				sel.css({"top" : Number(cHig/2)+Number(spc[1])+"px"});
			}
			
			if(ali == "C"){
				sel.css({"top" : Number(cHig/2)+Number(spc[0])+"px"});
				sel.css({"left" : Number(cWid/2)+Number(spc[1])+"px"});
			}
			
			if(ali == "RC"){
				sel.css({"right" : spc[0]+"px"});
				sel.css({"top" : Number(cHig/2)+Number(spc[1])+"px"});
			}
			
			if(ali == "BL"){
				sel.css({"bottom" : spc[0]+"px"});
				sel.css({"left" : spc[1]+"px"});
			}
			
			if(ali == "BC"){
				sel.css({"bottom" : spc[0]+"px"});
				sel.css({"left" : Number(cWid/2)+Number(spc[1])+"px"});
			}
		
			if(ali == "BR"){
				sel.css({"bottom" : spc[0]+"px"});
				sel.css({"right" : spc[1]+"px"});
			}
			
		};
		
		// Resize objects Function
		
		var resiz = function (obj, wi, hi, ResizeType, fixedSiz) {
			
			W = obj.width();
			H = obj.height();
			
			var rw = W/wi;
			var rh = H/hi;
			
			var objW;
			var objH;
			
			if(String(ResizeType) == "1")	{
				if (rw>rh) {
					objW = W/rh;
					objH = H/rh;
				} else {
					objW = W/rw;
					objH = H/rw;
				}
			}
			
			if(String(ResizeType) == "0")	{
				if (rw>rh) {
					objW = W/rw;
					objH = H/rw;
				} else {
					objW = W/rh;
					objH = H/rh;
				}	
				
			}
			
			
			obj.attr({"width":Math.round(objW)});
			obj.attr({"height":Math.round(objH)});

			if(fixedSiz){
				
				obj.css({"margin-left": Math.round((wi-objW)/2)+"px"});
				obj.css({"margin-top": Math.round((hi-objH)/2)+"px"});
				
			}
			
		};
		
		// Create Thumbnails
		
		var thumbSel = [];
		var thumbMain;
		var thumbContainer;
		var thWid;
		var thSpa;
		var thNexPreWid = Number(defaults.thumb_next_preious_width);
		var noThuShow = 0;
		var thumbnailsHolder;
		var thClick = false;
		var thMovSpd = 820;
		
		var thumbCreate = function(){
			
			curBanner.prepend('<div class="thumb-Holder" style="visibility:visible; overflow:hidden; position:absolute; left:0px; z-index:2"></div>');
			thumbnailsHolder = curBanner.children(':first-child');
			
			thumbnailsHolder.prepend('<div style="visibility:visible;  position:absolute; overflow:hidden; width:100%; left:0px"></div>');
			thumbContainer = thumbnailsHolder.children(':first-child');
			
			thumbContainer.prepend('<div style="position:absolute; overflow:hidden; cursor: auto; visibility:visible"></div>');
			thumbMain = thumbContainer.children(':first-child');

			thumbnailsHolder.bind("mousedown", function(e) {
				
				strDrg = false;
				e.stopImmediatePropagation();
				thClick = true;
				return false;
			});
			
			thumbnailsHolder.bind("mouseover", function(e) {
				$(this).css({"cursor":"auto"})
			});
			
			
			var _im = [];
			
			for(var tt=0; tt<thumbArr.length;tt++){
				
				if(tt!=0){
					var prTh = thumbMain.children(':first-child');	
				}
				
				
				thumbMain.prepend('<div class="thumb thumb-normal" style="position:absolute; left:0px; visibility:visible"> <div align="center" class="bg" style=" left:0px; position:relative; width:100%; height:100%; visibility:visible;"><div style="position:absolute; left:0px; overflow:hidden; visibility:visible" ></div></div></div>');
				
				thumbSel[tt] = thumbMain.children(':first-child');
						
				var cc = thumbMain.children(':first-child').children(':first-child');
				cc.children(':first-child').css({"width":cc.width()+"px"});
				cc.children(':first-child').css({"height":cc.height()+"px"});
				cc.css({"cursor" : "pointer"});
				
				thuBtnEnb(cc,tt);

				if(tt!=0){
					var thmb = thumbMain.children(':first-child');
					thmb.css({"left":parseInt(prTh.css("margin-right"))+parseInt(prTh.css("left"))+(parseInt(prTh.css("padding-right"))*2)+prTh.width()+"px"});
				}
				
				
				_im[tt] =$("<img>");
				_im[tt].hide();
				_im[tt].bind("load",function(){
					resiz($(this), $(this).parent().width(), $(this).parent().height(), 1, true);
					$(this).fadeIn();
					
				}).error(function () {			 
				});
				
				cc.append('<div class="tint-normal" style="position:absolute; left:0px; width:100%; height:100%; visibility:visible; "></div>')
				
				cc.children(':first-child').append(_im[tt]);
				_im[tt].attr('src',thumbArr[tt]);

			}
			
			thWid = thumbSel[0].width()+parseInt(thumbSel[0].css("padding-right"))*2;
			thSpa = thumbArr.length>1 ? parseInt(thumbSel[0].css("margin-right")) : 0;
			thumbMain.data("pos",0);
			
			thumbSel[0].children(':first-child').children(':last-child').addClass("tint-over");
			thumbSel[0].addClass("thumb-over");
			thumbMain.css({"height":thmb.height()+parseInt(thmb.css("padding-top"))+parseInt(thmb.css("padding-bottom"))+"px"});
			thumbContainer.css({"height":thmb.height()+parseInt(thmb.css("padding-top"))+parseInt(thmb.css("padding-bottom"))+"px"});
			thumbnailsHolder.css({"height":thmb.height()+parseInt(thmb.css("padding-top"))+parseInt(thmb.css("padding-bottom"))+"px"});

			var ww = ((thWid+thSpa)*thumbArr.length)-thSpa;

			if(parseInt(thumbnailsHolder.css("width")) == 0 || parseInt(thumbnailsHolder.css("width")) == curBanner.width()){
				if(ww>thumbnailsHolder.width()){
					thumbMain.css({"width": ww+"px"});
					thumbContainer.css({"width": Math.round(parseInt(thumbnailsHolder.css("width"))-thNexPreWid*2)+"px"});
				}
			}else{
				thumbContainer.css({"width": Math.round(parseInt(thumbnailsHolder.css("width"))-thNexPreWid*2)+"px"});
				thumbMain.css({"width": ww+"px"});
			}
			
			thumbMain.css({"left":"0px"});
			thumbContainer.css({"left":thNexPreWid+"px"});
			var spacing=[];
				spacing[0] = spacing[1] = 0;
			if(String(defaults.thumbnails_spacing) != "undefined"){
				spacing = String(defaults.thumbnails_spacing).split(",");
				spacing[0] = isNaN(spacing[0]) ? 0 : spacing[0];
				spacing[1] = isNaN(spacing[1]) ? 0 : spacing[1];
			}
			
			alignObject(thumbnailsHolder,defaults.thumbnails_align.toUpperCase() ,spacing,curBanner.width()-thumbnailsHolder.width(),curBanner.height()-thumbnailsHolder.height());

			// Thumbnail Next button
			
			thumbnailsHolder.prepend('<div  />');			
			var rBtnTh = thumbnailsHolder.children(":first-child");
			rBtnTh.css({"width":thNexPreWid+"px", "height":thumbContainer.height()+"px", "position":"absolute", "z-index":"2",
						 "visibility":"visible","overflow":"hidden","cursor":"pointer"});
			
			rBtnTh.prepend('<div />');
			var rightBtTh = rBtnTh.children(":first-child");
			rightBtTh.css({"position":"absolute","visibility":"visible","width":spriteImgWid+"px", "height":spriteImgHig+"px",
				"right":"0px","top":Math.round((thumbContainer.height()-50)/2)+"px"
			});
			
			if ($.support.msie){
				rightBtTh.css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+spriteImg+", sizingMethod='noscale')"});
			}else{
				rightBtTh.css({"background-image" : "url("+spriteImg+")"});
			}
			
			rBtnTh.css({"left":parseInt(thumbContainer.css("left"))+thumbContainer.width()+"px"});
		
			// Thumbnail Previous Button
			
			thumbnailsHolder.prepend('<div  />');			
			var lBtnTh = thumbnailsHolder.children(":first-child");
			lBtnTh.css({"width":thNexPreWid+"px", "height":thumbContainer.height()+"px", "position":"absolute", "z-index":"3",
						 "visibility":"visible","overflow":"hidden","cursor":"auto"});

			lBtnTh.prepend('<div />');
			var leftBtTh = lBtnTh.children(":first-child");
			leftBtTh.css({"position":"absolute","visibility":"visible","width":spriteImgWid+"px", "height":spriteImgHig+"px",
				"right":"-36px","top":Math.round((thumbContainer.height()-50)/2)+"px"	
			});
			
			if ($.support.msie){
				leftBtTh.css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+spriteImg+", sizingMethod='noscale')"});
			}else{
				leftBtTh.css({"background-image" : "url("+spriteImg+")"});
			}
			
			lBtnTh.css({"left":"0px"});		
			
			rBtnTh.addClass("thumb-next-previous-normal");
			rBtnTh.data({"nam":"rBtnTh","act":true});
			
			if(!autoplayLoop){
				lBtnTh.addClass("thumb-next-previous-over");
				lBtnTh.data({"nam":"lBtnTh","act":false});
			}else{
				lBtnTh.data({"nam":"lBtnTh","act":true});
				lBtnTh.addClass("thumb-next-previous-normal");
			}
			
			thuBtnEnb(rBtnTh,0);
			thuBtnEnb(lBtnTh,0);
			
			thumbContainer.data({"rBtnTh":rBtnTh,"lBtnTh":lBtnTh});
			
			noThuShow = Math.floor(thumbContainer.width()/(thWid+thSpa)+.1);

		};

		// Thumbnail button events create
		
		var thuBtnEnb = function(cc,tt){
			
			cc.bind('mouseover mouseup mouseleave', {no:tt}, function(e) {
					
				if(slideShow && slideShowAutStop){clearInterval(ssInt);}
				
				e.preventDefault();
				var sel = $(this);
				
				if(cc.data("nam") == "rBtnTh" || cc.data("nam") == "lBtnTh")	{
					
					if(cc.data("act")){
						cc.css({"cursor":"pointer"});
						sel.removeClass();
						sel.addClass("thumb-next-previous-over");
					}
					
				}else{
					
					if(selId != e.data.no){		
						sel.children(':last-child').removeClass("tint-normal");
						sel.children(':last-child').addClass("tint-over");					
						sel.parent().removeClass("thumb-normal");
						sel.parent().addClass("thumb-over");
					}
				}
					
			});				
				
			cc.bind('mouseout', {no:tt}, function(e) {
					
				e.preventDefault();
				var sel = $(this);	
				if(cc.data("nam") == "rBtnTh" || cc.data("nam") == "lBtnTh")	{	
					if(cc.data("act")){
						cc.css({"cursor":"pointer"});
						sel.removeClass();
						sel.addClass("thumb-next-previous-normal");	
					}
					
				}else{
					
					
					if(selId != e.data.no){		
						sel.children(':last-child').removeClass("tint-over");
						sel.children(':last-child').addClass("tint-normal");			
						sel.parent().removeClass("thumb-over");
						sel.parent().addClass("thumb-normal");
					}
					
				}
			});
				
			cc.bind('click',{no:tt}, function(e) {
				
				thClick = true;
				
				if(slideShow && slideShowAutStop){clearInterval(ssInt);}
				
				if(!thumbContainer.data("lBtnTh").data("act")){ enableDisableBtn(thumbContainer.data("lBtnTh"), true); }
				if(!thumbContainer.data("rBtnTh").data("act")){ enableDisableBtn(thumbContainer.data("rBtnTh"), true); }
				
				e.preventDefault();
				
				if(cc.data("nam") == "rBtnTh" || cc.data("nam") == "lBtnTh")	{
					
					if(cc.data("nam") == "rBtnTh"){
	
						if(cc.data("act")){
							if(!autoplayLoop){
								thumbMain.data("pos",(thumbMain.data("pos")-((noThuShow)*(thWid+thSpa)))) ;
							}else{
								if(thumbMain.data("pos") <= -(thumbMain.width()-thumbContainer.width())){
									thumbMain.data("pos",0) ;
								}else{
									thumbMain.data("pos",(thumbMain.data("pos")-((noThuShow)*(thWid+thSpa)))) ;
								}
							}
						}
					
					}else{
	
						if(cc.data("act")){
							if(!autoplayLoop){
								thumbMain.data("pos",(thumbMain.data("pos")+((noThuShow)*(thWid+thSpa)))) ;
							}else{
								if(thumbMain.data("pos") > -1){
									thumbMain.data("pos",-(thumbMain.width()-thumbContainer.width())) ;
								}else{
									thumbMain.data("pos",(thumbMain.data("pos")+((noThuShow)*(thWid+thSpa)))) ;
								}
							}
						}		
						
					}
	
					thMovSpd = 820;
					
				}else{			
						
					if(selId != e.data.no){

						if(thumbMain.data("pos")+parseInt(thumbSel[e.data.no].css("left"))<=thSpa){
							thMovSpd = 500;
							thumbMain.data("pos",thumbMain.data("pos")+(thWid+thSpa));
						}
						
						if(thumbContainer.width()-(thumbMain.data("pos")+parseInt(thumbSel[e.data.no].css("left"))+(thWid))<=thSpa){
							thMovSpd = 500;
							thumbMain.data("pos",thumbMain.data("pos")-(thWid+thSpa));
						}
						
						showSlide(Number(e.data.no));
					}
				}
				
				if(thumbMain.data("pos") > -1){
					enableDisableBtn(thumbContainer.data("lBtnTh"),false) ;
					thumbMain.data("pos",0);
				}
					
				if(thumbMain.data("pos") < -((thumbMain.width()-thumbContainer.width()))+(thWid+thSpa)){
					enableDisableBtn(thumbContainer.data("rBtnTh"),false) ;
				}
					
				if(thumbMain.data("pos") < -(thumbMain.width()-thumbContainer.width())){ 
					thumbMain.data("pos",-(thumbMain.width()-thumbContainer.width()));
				}
				
				thumbMain.stop();
				thumbMain.animate({"left":thumbMain.data("pos")+"px"},{queue:false, duration : thMovSpd, easing: "easeInOutQuad"});	
					
			});
			
			cc.bind('mousedown',{no:tt}, function(e) {
				strDrg = false;
				e.stopImmediatePropagation();
				var sel = $(this);
					
				if(cc.data("nam") == "rBtnTh" && cc.data("act")){
					sel.removeClass();
					sel.addClass("thumb-next-previous-normal");
				}
					
				if(cc.data("nam") == "lBtnTh" && cc.data("act")){
					sel.removeClass();
					sel.addClass("thumb-next-previous-normal");
				}
				
				return false;
			});
			
			cc.bind('mouseup',{no:tt}, function(e) {
				strDrg = false;
				e.stopImmediatePropagation();
				var sel = $(this);
				
				if(cc.data("nam") == "rBtnTh" && cc.data("act")){
					sel.removeClass();
					sel.addClass("thumb-next-previous-over");
				}
					
				if(cc.data("nam") == "lBtnTh" && cc.data("act")){
					sel.removeClass();
					sel.addClass("thumb-next-previous-over");
				}
				return false;
			});
			
		};
		
		// Enable/Disable the next and previous thumbnail naviagation
		
		var enableDisableBtn = function(sel, sho){
			if(!autoplayLoop || sho){
				sel.data("act",sho);
				sel.removeClass();
				if(sho){
					sel.addClass("thumb-next-previous-normal");
					sel.data("act",true);
					sel.css({"cursor":"pointer"});
				}else{
					sel.css({"cursor":"auto"});
					sel.data("act",false);
					sel.addClass("thumb-next-previous-over");
				}
			}
		};
		
		// create the dotted thumbnails, next and previous buttons

		var createButton = function (wid, hig, nos){
			
			// Create dotted buttons
			
			navBtns.css({"top":"0px","left":"0"});
			navBtns.prepend('<div />');
			navBtns.children(":first-child").css({"width":btnBgSpacing+"px","height":btnHig+1+"px", "background-image":"url("+spriteImg+")","position":"absolute","top":"0px","left":"0","background-repeat":"no-repeat"});
			
			if(iconsType == 1){
				navBtns.children(":first-child").css({"background-position" : (-65)+"px "+ -btnYpos+"px", "left":"0px"});
			}
			if(iconsType == 2){
				navBtns.children(":first-child").css({"background-position" : (-77)+"px "+ -btnYpos+"px", "left":"0px"});
			}
		
			for(var ii=0; ii<nos; ii++){
				navBtns.append('<div ></div>');
				navBtns.children(":last-child").css({
					"left" : ((wid-1)*ii)+btnBgSpacing+"px",
					"position": "absolute",
					"width":wid-1,
					"height":hig,"top":"0px",
					"cursor":"pointer",
                  	"background-image" : "url("+spriteImg+")",
					"background-position" : "0px "+ -btnYpos+"px"
				});
				
				navArr[ii] = navBtns.children(":last-child");
				navArr[ii].data("nam",ii);
				if(iconsType == 2){ 
				navArr[ii].append('<div />');
					navArr[ii].children(":last-child").text(ii+1);
					navArr[ii].css({"padding-top":(navArr[ii].height()/2 - 2 )  +"px"});
				}
				navArr[ii].addClass("buttonText");
				btn_Enable(navArr[ii]);
				navBtns.css({"height":hig+"px"});
	
			}
			
			navBtns.prepend('<div />');
			navBtns.children(":first-child").css({"width":btnBgSpacing+"px","height":btnHig+1+"px","left":((wid-1)*ii)+(btnBgSpacing)+"px",
							"background-image":"url("+spriteImg+")","position":"absolute","background-repeat":"no-repeat"});
			
			if(iconsType == 1){
				navBtns.children(":first-child").css({"background-position" : -87+"px "+ -btnYpos+"px"});
			}
			if(iconsType == 2){
				navBtns.children(":first-child").css({"background-position" : -103+"px "+ -btnYpos+"px"});
			}
	
			navBtns.css({"visibility":"visible"});
			navHolder.css({"width":parseInt((wid*ii))+(btnBgSpacing*2)+"px"});

			alignObject(navHolder,buttonsAlign,buttonsSpacing,
			(parseInt(mainContainer.width())-parseInt(navHolder.width())),(parseInt(mainContainer.height())-parseInt(navHolder.height())));

			navBtns.fadeTo("fast",1); 
			navArr[0].css({"background-position":-(btnWid*2)+"px "+ -btnYpos+"px" });
			navBtns.css({"display":"none"});
			
			// Create Right Button
			var npBtnSiz_w=npBtnSiz-14.5;
			curBanner.prepend('<div  />');			
			rightBtn = curBanner.children(":first-child");
			rightBtn.css({"width":npBtnSiz_w+"px", "height":npBtnSiz+"px", "position":"absolute", "z-index":slideConArr.length+2,
						 "visibility":"visible","overflow":"hidden","cursor":"pointer"});
			
			rightBtn.prepend('<div />');
			rightBt = rightBtn.children(":first-child");
			rightBt.css({"position":"absolute","visibility":"visible","width":spriteImgWid+"px", "height":spriteImgHig+"px",
				"right":"0px","bottom":-npBtnYpos+"px"
			});
			if ($.support.msie){
				rightBt.css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+spriteImg+", sizingMethod='noscale')"});
			}else{
				rightBt.css({"background-image" : "url("+spriteImg+")"});
			}
			
			rightBtn.data({"nam":"rBtn","hid":false});
			btn_Enable(rightBtn);
			rightBtn.show();
			
			alignObject(rightBtn,nBtnAlign,nBtnSpacing,
			(parseInt(mainContainer.width())-parseInt(rightBtn.width())),(parseInt(banSliders.height())-parseInt(rightBtn.height())));

		
			// Create Left Button 
			
			curBanner.prepend('<div  />');			
			leftBtn = curBanner.children(":first-child");
			leftBtn.css({"position":"absolute", "width":npBtnSiz-14+"px", "height":npBtnSiz+"px", "z-index":slideConArr.length+3,
						"visibility":"visible","overflow":"hidden", "cursor":"pointer"});

			leftBtn.prepend('<div />');
			leftBt = leftBtn.children(":first-child");
			leftBt.css({"position":"absolute","width":spriteImgWid+"px", "height":spriteImgHig+"px", "visibility":"visible",
				"left":"0px","bottom":-npBtnYpos+"px"
			});
			if ($.support.msie){
				leftBt.css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src="+spriteImg+", sizingMethod='noscale')"});
			}else{
				 leftBt.css({"background-image" : "url("+spriteImg+")"});
			}
			
			leftBtn.data({"nam":"lBtn","hid":false});
			btn_Enable(leftBtn);
			rightBtn.hide();
			leftBtn.hide();
			leftBt.fadeTo("fast",1); 
			rightBt.fadeTo("fast",1); 
			if(!autoplayLoop){
				leftBtn.css({"cursor":"auto"});
				leftBtn.data("hid",true);
			}
			
			alignObject(leftBtn,pBtnAlign,pBtnSpacing,
			(parseInt(mainContainer.width())-parseInt(leftBtn.width())),(parseInt(banSliders.height())-parseInt(leftBtn.height())));
			
			if(autoHideNP){ autoHideNavs = [leftBtn,rightBtn]; }
			if (!$.support.msie){
				if(autoHideBtns){autoHideNavs.push(navHolder);}
			}

		};
		
		// IE 8 Fade in function
		var fadeInIe8 = function (oDiv) {
			oDiv.style.filter="blendTrans(duration=.2)";
			// Make sure the filter is not playing.
			if (oDiv.filters.blendTrans.status != 2) {
				oDiv.filters.blendTrans.apply();
				oDiv.style.visibility="visible";
				oDiv.filters.blendTrans.play();
			}
		};

	
		// Buttons events
		
		var btn_Enable = function (sel){
			
			// Bind the mouseover mouseup and  mouseleave for all navigation
			
			sel.bind('mouseover mouseup mouseleave', function() {

				
				if(slideShow && slideShowAutStop){clearInterval(ssInt);}
				
				if(sel.data("nam") != "rBtn" && sel.data("nam") != "lBtn"){
				
					if(selId != sel.data("nam")){
						//sel.css({"background-position":-(btnWid)+"px "+ -btnYpos+"px" });
					}
					
				}else{
					if(!sel.data("hid")){
						if(sel.data("nam") == "rBtn"){
							//sel.children(":first-child").css({"right":(-npBtnSiz)+"px ","bottom":-npBtnYpos+"px"});
						}else{
							//sel.children(":first-child").css({"left":(-npBtnSiz)+"px ","bottom":-npBtnYpos+"px"});
						}
					}
				}
				
				return false;
				
			});
			
			// Bind the mouseout for all navigation
			
			sel.bind('mouseout', function() {

				
				if(sel.data("nam") != "rBtn" && sel.data("nam") != "lBtn"){
					
					if(selId != sel.data("nam")){
						sel.css({"background-position": "0px "+ -btnYpos+"px" });
					}

				}else{
					if(!sel.data("hid")){
						if(sel.data("nam") == "rBtn"){
							//sel.children(":first-child").css({"right":0+"px ","bottom":-npBtnYpos+"px"});
						}else{
							//sel.children(":first-child").css({"left":0+"px ","bottom":-npBtnYpos+"px"});
						}
					}
				}

			});
			
			// Bind the mousedown for all navigation
			
			sel.bind('mousedown', function() {
				
				if(slideShow && slideShowAutStop){clearInterval(ssInt);}
				
				if(sel.data("nam") != "rBtn" && sel.data("nam") != "lBtn"){
					if(selId != sel.data("nam")){
						sel.css({"background-position":-(btnWid*2)+"px "+ -btnYpos+"px" });
					}
				}else{
					if(!sel.data("hid")){
						if(sel.data("nam") == "rBtn"){
							//sel.children(":first-child").css({"right":(-npBtnSiz*2)+"px ","bottom":-npBtnYpos+"px"});
						}else{
							//ssel.children(":first-child").css({"left":(-npBtnSiz*2)+"px ","bottom":-npBtnYpos+"px"});
						}
					}
				}
				return false;
			});
			
			// Bind the click for all navigation
			
			sel.bind('click', function() {
				
				thClick = false;
				
				if(slideShow && slideShowAutStop){clearInterval(ssInt);}
				
				if(sel.data("nam") != "rBtn" && sel.data("nam") != "lBtn"){
					if(selId != sel.data("nam")){
						showSlide(Number(sel.data("nam")));
					}
				}else{
						if(sel.data("nam") == "rBtn"){
							if(selId < slideConArr.length-1){
								//sel.children(":first-child").css({"right":-(npBtnSiz)+"px ","bottom":-npBtnYpos+"px"});
							}
							nexSlide();
							
						}else{
							if( selId > 0){
								//sel.children(":first-child").css({"left":(-npBtnSiz)+"px ","bottom":-npBtnYpos+"px"});
							}
							preSlide();
						}
				}
				
				return false;
				
			});
			
		};

		
	// Drag Movement
	
		var tm ;
		var tmArr=[];
		var tmMovChk;
		var tmRevMov = false;
		var bgDrgPos = 0;
		var drgPosDir = 0; 
		// Start to drag using below function
		var dragStart = function(){
			if(tch != tch_){
				strDrg = true;
				thClick = false;
			}
			
			allSli.stop();
			tm = Math.round(Math.abs(Number(tch_)-Number(tch)))< 101? Math.round(Math.abs(Number(tch_)-Number(tch))) : Math.round(100 + Math.abs(100-(Math.abs(Number(tch_)-Number(tch))))*.2);
			
			if((Number(tch_) > Number(tch))){
				allSli.css({"left":Number(tm)+"px"});
				if ($.support.msie) {
					curBanner.css({"background-position-x": bgDrgPos+tm+"px"});
				}else{
					curBanner.css({"background-position": bgDrgPos+tm+"px"});
				}
			}else{
				allSli.css({"left":-Number(tm)+"px"});
				if ($.support.msie) {
					curBanner.css({"background-position-x": bgDrgPos-tm+"px"});
				}else{
					curBanner.css({"background-position": bgDrgPos-tm+"px"});
				}
			}
		};
		
		// Stop drag using below function, The next and previous slide will start here
		var dragStop = function(){
			 
			if(Number(tch) != Number(tch_)){
				if(Number(tch) > Number(tch_) ){

					if(((Number(tch) - Number(tch_)) > 50 || tmMovChk>5) && !tmRevMov){
						allSli.stop();
						if (!$.support.msie){
							allSli.animate({"left":Number(-tm-(banSliders.width()*.36))+"px", "opacity":0},300);
						}else{
							allSli.animate({"left":Number(-tm-(banSliders.width()*.36))+"px"},300);
						}
						drgPosDir = 1;
						nexSlide();
						
					}else{
						allSli.stop();
						allSli.animate({"left":"0px"});
					}
				}else{
					
					if(((Number(tch_)-Number(tch)) > 50 || tmMovChk>5) && !tmRevMov){
						allSli.stop();
						if (!$.support.msie){
							allSli.animate({"left":Number(tm+(banSliders.width()*.36))+"px", "opacity":0},300);
						}else{	
							allSli.animate({"left":Number(tm+(banSliders.width()*.36))+"px"},300);
						}
						drgPosDir = -1;
						preSlide();
					}else{
						allSli.stop();
						allSli.animate({"left":"0px"});
					}
				}
			}
			

			tm = 0;
		};
		
	
		// Mousedown event for drag
		var strDrg = false;

		var mouseDragInit = function(){	

			$(document).bind('mousedown.fmDragEvent', function(e) {
				tch = tch_ = Math.abs(e.clientX);
				tmArr = [];
				tmArr.push(tch);
				curBanner.stop();
				if ($.support.msie) {
					bgDrgPos = parseInt(curBanner.css("background-position-x"));
				}else{
					bgDrgPos = parseInt(curBanner.css("background-position"));
				}
				
				$(document).bind('mousemove.fmDragEvent', function(e) {
					tmRevMov = tch_ > Math.abs(e.clientX) ? (Number(tch) > Number(tch_)) ? false:true : (Number(tch) < Number(tch_)) ? false : true;
					tch_ = Math.abs(e.clientX);
					tmArr.push(tch_);
					tmMovChk = Math.abs((tmArr[tmArr.length-1]-tmArr[tmArr.length-2]));
					dragStart();
					return false;
				});
				
				return false;
			});
			
			$(document).bind('mouseup.fmDragEvent', function() {
				
				if(tch != tch_){
					strDrg = false;
				}else{
					strDrg = true;
				}
				
				$(document).unbind('mousedown.fmDragEvent');
				$(document).unbind('mouseleave.fmDragEvent');
				$(document).unbind('mousemove.fmDragEvent');
				$(document).unbind('mouseup.fmDragEvent');	
				
				curBanner.removeClass("fm_draging-cursor");
				curBanner.addClass("fm_drag-cursor");

				dragStop();
				return false;
			});
			
			
			$(document).bind('mouseleave.fmDragEvent', function() {
				strDrg = false;
				$(document).unbind('mousedown.fmDragEvent');
				$(document).unbind('mouseleave.fmDragEvent');
				$(document).unbind('mousemove.fmDragEvent');
				$(document).unbind('mouseup.fmDragEvent');	
				
				curBanner.removeClass("fm_draging-cursor");
				curBanner.addClass("fm_drag-cursor");

				return false;
			});
		};

		
		
			 
		// Touch screen Enable
		
		var touEle = banSliders.children();
		var tch = 0;
		var tch_ = 0;
		
        try {
        	document.createEvent('TouchEvent');
		
			$(touEle).each(function() {
				this.ontouchstart = function(e) {
						touchStart(e);
						return true;
					};
				
				this.ontouchend = function(e) {
					e.preventDefault();
					e.stopPropagation();
					touchEnd();
				};
						
				this.ontouchmove = function(e) {
					touchMove(e);
					e.preventDefault();
					e.stopPropagation();
					return false;
				};	
			});
			
		} catch (e) {
			// Nothing to do
        }
				
					
		var touchStart = function(e) {
			tch = tch_ = Math.abs(e.clientX);
			tmArr = [];
			tmArr.push(tch);
			curBanner.stop();
			if ($.support.msie) {
				bgDrgPos = parseInt(curBanner.css("background-position-x"));
			}else{
				bgDrgPos = parseInt(curBanner.css("background-position"));
			}
			
			if(slideShow && slideShowAutStop){
				slideShowZ = false;
				clearInterval(ssInt);
			}
			
			tch = tch_ =  e.targetTouches[0].clientX;
		};
			 
		var touchEnd = function() {
			if(slideShow && slideShowAutStop){
				slideShowZ = true;
				clearInterval(ssInt);
			}
			dragStop();
		};

		var touchMove = function(e) {
			tmRevMov = tch_ > Math.abs(e.targetTouches[0].clientX) ? (Number(tch) > Number(tch_)) ? false:true : (Number(tch) < Number(tch_)) ? false : true;
			tch_ = Math.abs(e.targetTouches[0].clientX);
			tmArr.push(tch_);
			tmMovChk = Math.abs((tmArr[tmArr.length-1]-tmArr[tmArr.length-2]));
			dragStart();
			
		};
					 
		
		// Start the require image to load - this function invoke the slideshow to start loading

		startReqImgLoad();

		
		
	}



	 $.fn.fmslideshow = function(params) {
	   return this.each(function () {    
	   var fmBanner = $(this);
	   var ins = fmBanner.data('GBInstance');
	   		// Initiate the slideshow
		   if (!ins){ 
				fmBanner.data('GBInstance', new fmslideshow(this, params));
		   } 
	  });
   }; 
 

	 
  
})( jQuery );




/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 *
 * Open source under the BSD License.
 *
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * Neither the name of the author nor the names of contributors may be used to endorse
 * or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration

jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

