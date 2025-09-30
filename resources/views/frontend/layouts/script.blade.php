<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('js/common_scripts.min.js') }}"></script>
   <script src="{{ asset('js/main.js') }}"></script>
	<!-- SPECIFIC SCRIPTS -->
<script src="{{ asset('js/modernizr.js') }}"></script>
 <script src="{{ asset('js/carousel_with_thumbs.js') }}"></script>
	{{-- <script src="js/video_header.min.js"></script> --}}
<script src="{{ asset('js/isotope.min.js') }}"></script>
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
<script>
document.addEventListener('DOMContentLoaded', function() {

    if (!window.__addingToCart) window.__addingToCart = {};

    function updateCartBadge(count) {
        let cartCount = document.getElementById('cart-count');

        if (!cartCount) {

            const cartIcon = document.querySelector('.cart-icon') || document.body;
            cartCount = document.createElement('span');
            cartCount.id = 'cart-count';
            cartCount.className = 'badge';
            cartIcon.appendChild(cartCount);
        }


        cartCount.textContent = String(count);
        cartCount.dataset.count = String(count);
        cartCount.setAttribute('aria-hidden', count === 0 ? 'true' : 'false');

        if (Number(count) === 0) {
            cartCount.style.display = 'none';
        } else {
            cartCount.style.display = 'inline-block';
            cartCount.classList.add('cart-updated');
            setTimeout(() => cartCount.classList.remove('cart-updated'), 300);
        }
    }

    const initialEl = document.getElementById('cart-count');
    const initialCount = initialEl ? parseInt(initialEl.dataset.count || initialEl.textContent || '0', 10) : 0;
    if (!isNaN(initialCount)) updateCartBadge(initialCount);

    const forms = document.querySelectorAll('.add-to-cart-form');
    forms.forEach(form => {
        if (form.dataset.hasListener === '1') return;
        form.dataset.hasListener = '1';

        form._sending = false;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            if (form._sending) return;
            form._sending = true;

            const pidInput = form.querySelector('input[name="product_id"]');
            const productId = pidInput ? pidInput.value : '__no_id__';

            if (window.__addingToCart[productId]) {
                console.warn('Add-to-cart already in progress for product', productId);
                form._sending = false;
                return;
            }
            window.__addingToCart[productId] = true;

            const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            submitButtons.forEach(btn => btn.disabled = true);

            const formData = new FormData(form);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData,
                credentials: 'same-origin'
            })
            .then(async res => {
                if (!res.ok) {
                    const text = await res.text();
                    throw new Error('HTTP ' + res.status + ' - ' + text);
                }
                return res.json();
            })
            .then(data => {
                console.log('add-to-cart response', data);
                if (data && typeof data.cart_count !== 'undefined') {
                    updateCartBadge(Number(data.cart_count));
                } else if (data && typeof data.success !== 'undefined' && data.success && typeof data.cart_count === 'undefined') {
                    console.warn('Response missing cart_count. Consider returning cart_count from server.');
                } else {
                    console.warn('Unexpected add-to-cart response', data);
                }
            })
            .catch(err => {
                console.error('Add to cart failed:', err);
            })
            .finally(() => {
                form._sending = false;
                window.__addingToCart[productId] = false;
                submitButtons.forEach(btn => btn.disabled = false);
            });
        }, { passive: false });
    });
});
</script>
{{-- end cart --}}
