document.addEventListener('DOMContentLoaded', function() {
    const productItems = document.querySelectorAll('.product-item');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = 1;
          observer.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px 100px 0px' });
  
    productItems.forEach(item => {
      item.style.opacity = 0;
      item.style.transition = 'opacity 0.5s';
      observer.observe(item);
    });
  });