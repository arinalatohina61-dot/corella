// Анимация при добавлении в корзину
document.addEventListener('DOMContentLoaded', function() {
    // Добавление товара в корзину
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const productCard = this.closest('.product-card');
            const cartIcon = document.querySelector('.cart-count');

            // Анимация
            productCard.style.transform = 'scale(0.95)';
            setTimeout(() => {
                productCard.style.transform = '';
            }, 300);

            // Обновление счетчика
            if (cartIcon) {
                let count = parseInt(cartIcon.textContent) || 0;
                cartIcon.textContent = count + 1;
            }
        });
    });

    // Плавный скролл к фильтрам
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Подсветка активной категории
    const currentCategory = window.location.pathname.split('/').pop();
    document.querySelectorAll('.navigation a').forEach(link => {
        if (link.getAttribute('href').includes(currentCategory)) {
            link.classList.add('active');
        }
    });
});
