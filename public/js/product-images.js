/*============================================================================================*/
/* PROFESSIONAL PRODUCT IMAGES JAVASCRIPT */
/*============================================================================================*/

document.addEventListener('DOMContentLoaded', function() {
    // Professional Image Loading Enhancement
    const productImages = document.querySelectorAll('.grid_item figure img');
    
    productImages.forEach(function(img) {
        // Ensure images are immediately visible
        img.style.opacity = '1';
        img.style.visibility = 'visible';
        img.style.display = 'block';
        
        // Handle image load
        img.addEventListener('load', function() {
            this.classList.add('loaded');
            this.style.opacity = '1';
            this.style.visibility = 'visible';
        });
        
        // Handle image error
        img.addEventListener('error', function() {
            this.src = '/img/products/product_placeholder_square_medium.jpg';
            this.classList.add('loaded');
            this.style.opacity = '1';
            this.style.visibility = 'visible';
        });
    });
    
    // Professional Hover Effects
    const gridItems = document.querySelectorAll('.grid_item');
    
    gridItems.forEach(function(item) {
        const figure = item.querySelector('figure');
        const img = item.querySelector('img');
        
        if (figure && img) {
            // Add professional hover effect
            item.addEventListener('mouseenter', function() {
                figure.style.transform = 'scale(1.02)';
                img.style.transform = 'scale(1.05)';
            });
            
            item.addEventListener('mouseleave', function() {
                figure.style.transform = 'scale(1)';
                img.style.transform = 'scale(1)';
            });
        }
    });
    
    // Professional Lazy Loading
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        // Observe all lazy images
        document.querySelectorAll('img.lazy').forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    // Professional Image Aspect Ratio Maintenance
    function maintainAspectRatio() {
        const figures = document.querySelectorAll('.grid_item figure');
        
        figures.forEach(function(figure) {
            const img = figure.querySelector('img');
            if (img && img.complete) {
                const aspectRatio = img.naturalHeight / img.naturalWidth;
                const containerHeight = figure.offsetWidth * aspectRatio;
                
                if (containerHeight > 0) {
                    figure.style.height = Math.min(containerHeight, 280) + 'px';
                }
            }
        });
    }
    
    // Run on load and resize
    window.addEventListener('load', maintainAspectRatio);
    window.addEventListener('resize', maintainAspectRatio);
    
    // Professional Loading Animation
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'product-loading-overlay';
    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    `;
    
    const spinner = loadingOverlay.querySelector('.loading-spinner');
    spinner.style.cssText = `
        width: 40px;
        height: 40px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #004dda;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    `;
    
    // Add spinner animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    document.body.appendChild(loadingOverlay);
    
    // Show loading on page load
    window.addEventListener('load', function() {
        setTimeout(function() {
            loadingOverlay.style.opacity = '0';
            loadingOverlay.style.visibility = 'hidden';
        }, 500);
    });
    
    // Professional Image Preloading
    function preloadImages() {
        const imageUrls = [];
        document.querySelectorAll('.grid_item figure img').forEach(function(img) {
            if (img.src && !img.src.includes('placeholder')) {
                imageUrls.push(img.src);
            }
        });
        
        imageUrls.forEach(function(url) {
            const preloadImg = new Image();
            preloadImg.src = url;
        });
    }
    
    // Run preloading
    preloadImages();
    
    // Professional Error Handling
    document.addEventListener('error', function(e) {
        if (e.target.tagName === 'IMG' && e.target.closest('.grid_item')) {
            e.target.src = '/img/products/product_placeholder_square_medium.jpg';
            e.target.classList.add('loaded');
        }
    }, true);
    
    // Professional Performance Optimization
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            maintainAspectRatio();
        }, 250);
    });
    
    // Professional Accessibility Enhancement
    const gridItemsAccessibility = document.querySelectorAll('.grid_item');
    gridItemsAccessibility.forEach(function(item) {
        item.setAttribute('role', 'article');
        item.setAttribute('tabindex', '0');
        
        const link = item.querySelector('a[href]');
        if (link) {
            link.setAttribute('aria-label', 'View product details');
        }
    });
    
    // Professional Keyboard Navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            const focusedItem = document.activeElement;
            if (focusedItem && focusedItem.classList.contains('grid_item')) {
                const link = focusedItem.querySelector('a[href]');
                if (link) {
                    e.preventDefault();
                    link.click();
                }
            }
        }
    });
    
    console.log('Professional Product Images Enhancement Loaded Successfully');
});
