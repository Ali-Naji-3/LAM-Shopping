<script src="js/common_scripts.min.js"></script>
    <script src="js/main.js"></script>

	<!-- SPECIFIC SCRIPTS -->
	<script src="js/modernizr.js"></script>
	<script src="js/video_header.min.js"></script>
    {{-- <script src="{{ asset('js/header-video.js') }}"></script>
	<script>
		// Video Header
		HeaderVideo.init({
			container: $('.header-video'),
			header: $('.header-video--media'),
			videoTrigger: $("#video-trigger"),
			autoPlayVideo: true
		}); --}}
	</script>
	<script src="js/isotope.min.js"></script>
	<script>
		// Isotope filter
		$(window).on('load',function(){
		  var $container = $('.isotope-wrapper');
		  $container.isotope({ itemSelector: '.isotope-item', layoutMode: 'masonry' });
		});
		$('.isotope_filter').on( 'click', 'a', 'change', function(){
		  var selector = $(this).attr('data-filter');
		  $('.isotope-wrapper').isotope({ filter: selector });
		});
	</script>
