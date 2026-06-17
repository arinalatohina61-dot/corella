<section class="slider-section">
    <div class="slider-container">
        <!-- Весь HTML код слайдера из вашего файла -->
        <div class="slider-wrapper">
            <!-- Слайд 1 -->
            <div class="slider-slide active">
                <img src="https://avatars.mds.yandex.net/get-entity_search/2114485/1221823023/S600xU_2x"
                     alt="Природная эстетика в каждой детали" class="slide-image">
                <div class="slide-overlay"></div>
                <div class="slide-line left"></div>
                <div class="slide-line right"></div>
                <div class="slide-corner corner-tl"></div>
                <div class="slide-corner corner-tr"></div>
                <div class="slide-corner corner-bl"></div>
                <div class="slide-corner corner-br"></div>
                <div class="slide-content">
                    <h1 class="slide-title">Растения для дома и офиса</h1>
                    <p class="slide-subtitle">От маленьких кактусов до крупных фикусов.</p>
                    <a href="/list" class="slide-button">Смотреть каталог</a>
                </div>
                <div class="slide-number">01</div>
            </div>


            <div class="slider-slide active">
                <img src="https://avatars.mds.yandex.net/get-entity_search/2114485/1221823023/S600xU_2x"
                     alt="Природная эстетика в каждой детали" class="slide-image">
                <div class="slide-overlay"></div>
                <div class="slide-line left"></div>
                <div class="slide-line right"></div>
                <div class="slide-corner corner-tl"></div>
                <div class="slide-corner corner-tr"></div>
                <div class="slide-corner corner-bl"></div>
                <div class="slide-corner corner-br"></div>
                <div class="slide-content">
                    <h1 class="slide-title">Элегантность в деталях</h1>
                    <p class="slide-subtitle">Комнатные растения, которые сочетают в себе современные подходы к озеленению и природную эстетику. Каждая композиция — это живое произведение искусства.</p>
                    <a href="/list" class="slide-button">Смотреть каталог</a>
                </div>
                <div class="slide-number">02</div>
            </div>

            <!-- ... остальные слайды ... -->
        </div>

        <!-- Кнопки навигации -->
        <div class="slider-controls">
            <button class="slider-btn prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-btn next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Точки навигации -->
        <div class="slider-dots">
            <div class="slider-dot active" data-slide="0"></div>
            <div class="slider-dot" data-slide="1"></div>
            <div class="slider-dot" data-slide="2"></div>
            <div class="slider-dot" data-slide="3"></div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderWrapper = document.querySelector('.slider-wrapper');
        const slides = document.querySelectorAll('.slider-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        const slideNumbers = document.querySelectorAll('.slide-number');

        let currentSlide = 0;
        const totalSlides = slides.length;
        let autoSlideInterval;

        // Функция для обновления слайдера
        function updateSlider() {
            // Сдвигаем слайды
            sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Обновляем активный класс у слайдов
            slides.forEach((slide, index) => {
                slide.classList.toggle('active', index === currentSlide);
            });

            // Обновляем точки навигации
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });

            // Обновляем номера слайдов
            slideNumbers.forEach((number, index) => {
                number.textContent = String(index + 1).padStart(2, '0');
            });
        }

        // Следующий слайд
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        }

        // Предыдущий слайд
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider();
        }

        // Клик по кнопке "вперед"
        nextBtn.addEventListener('click', nextSlide);

        // Клик по кнопке "назад"
        prevBtn.addEventListener('click', prevSlide);

        // Клик по точкам навигации
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                currentSlide = parseInt(this.getAttribute('data-slide'));
                updateSlider();
                resetAutoSlide();
            });
        });

        // Автопрокрутка слайдов
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Пауза автопрокрутки при наведении
        sliderWrapper.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });

        sliderWrapper.addEventListener('mouseleave', () => {
            startAutoSlide();
        });

        // Свайп для мобильных устройств
        let startX = 0;
        let endX = 0;

        sliderWrapper.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        sliderWrapper.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            const diff = startX - endX;
            const threshold = 50;

            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    // Свайп влево - следующий слайд
                    nextSlide();
                } else {
                    // Свайп вправо - предыдущий слайд
                    prevSlide();
                }
            }
            resetAutoSlide();
        }

        // Запускаем автопрокрутку
        startAutoSlide();

        // Инициализация
        updateSlider();
    });
</script>
