import './sound-effects';
import './form-handler';
import './frame-animator';

document.addEventListener('DOMContentLoaded', () => {
  // 1. Header scroll state & back to top
  const siteHeader = document.querySelector('.site-header, .inner-header');
  const backToTop = document.getElementById('backToTop');
  const progressBar = document.getElementById('scrollProgress');

  function onScroll() {
    const scrollY = window.scrollY;
    siteHeader?.classList.toggle('scrolled', scrollY > 20);
    backToTop?.classList.toggle('show', scrollY > 450);

    if (progressBar) {
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const progress = Math.max(0, Math.min(1, scrollY / Math.max(1, docHeight)));
      progressBar.style.width = (progress * 100) + '%';
    }
  }

  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
  backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  // 2. Smooth Scroll Anchors
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href');
      if (!href || href === '#') return;
      const target = document.querySelector(href);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });

      // Dismiss offcanvas if open
      const offcanvasEl = link.closest('.offcanvas.show');
      if (offcanvasEl && window.bootstrap?.Offcanvas) {
        window.bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl).hide();
      }
    });
  });

  // 3. Scroll Reveal System (Fade in + slide up)
  const revealElements = document.querySelectorAll('.reveal');
  if (revealElements.length > 0) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    revealElements.forEach(el => io.observe(el));
  }

  // 4. Animated Number Counters
  const counterElements = document.querySelectorAll('[data-count]');
  if (counterElements.length > 0) {
    const counterIO = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const targetValue = parseFloat(el.dataset.count);
        const isFloat = !Number.isInteger(targetValue);
        const startTime = performance.now();
        const duration = 1400;

        const updateTick = (now) => {
          const elapsed = Math.min(1, (now - startTime) / duration);
          // Ease-out cubic
          const eased = 1 - Math.pow(1 - elapsed, 3);
          const currentVal = targetValue * eased;
          el.textContent = isFloat ? currentVal.toFixed(1) : Math.floor(currentVal).toString();

          if (elapsed < 1) {
            requestAnimationFrame(updateTick);
          }
        };

        requestAnimationFrame(updateTick);
        counterIO.unobserve(el);
      });
    }, { threshold: 0.4 });

    counterElements.forEach(el => counterIO.observe(el));
  }

  // 5. 3D Card Tilt on pointer fine devices
  const canTilt = matchMedia('(pointer:fine)').matches && !matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (canTilt) {
    document.querySelectorAll('.tilt-card').forEach(card => {
      card.addEventListener('pointermove', e => {
        const rect = card.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;
        card.style.transform = `perspective(850px) rotateX(${-y * 6}deg) rotateY(${x * 8}deg) translateY(-4px)`;
      });

      card.addEventListener('pointerleave', () => {
        card.style.transform = '';
      });
    });
  }

  // 6. Tires Page Interactive Filtering & Sorting
  const filterBtns = document.querySelectorAll('[data-filter]');
  if (filterBtns.length > 0) {
    filterBtns.forEach(button => {
      button.addEventListener('click', () => {
        const group = button.closest('.filter-group');
        group?.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        button.classList.add('active');

        const activeCat = document.querySelector('.filter-group[data-kind="category"] .active')?.dataset.filter || 'all';
        const activeCond = document.querySelector('.filter-group[data-kind="condition"] .active')?.dataset.filter || 'all';

        let count = 0;
        document.querySelectorAll('.tire-card').forEach(card => {
          const matchCat = activeCat === 'all' || card.dataset.category === activeCat;
          const matchCond = activeCond === 'all' || card.dataset.condition === activeCond;
          const isVisible = matchCat && matchCond;

          card.hidden = !isVisible;
          if (isVisible) count++;
        });

        const countEl = document.querySelector('[data-results-count]');
        if (countEl) countEl.textContent = `Showing ${count} tires`;
      });
    });

    const sortSelect = document.querySelector('[data-sort]');
    sortSelect?.addEventListener('change', () => {
      const grid = document.querySelector('.tire-grid');
      if (!grid) return;
      const cards = [...grid.children];
      cards.sort((a, b) => {
        const priceA = parseFloat(a.dataset.price) || 0;
        const priceB = parseFloat(b.dataset.price) || 0;
        return sortSelect.value === 'high' ? priceB - priceA : priceA - priceB;
      });
      cards.forEach(card => grid.appendChild(card));
    });
  }
});
