/**
 * MUKOH TIRES — Ultra-Smooth 3D Frame-by-Frame Scroll & Inertia Engine
 * Features:
 * - Sub-frame dual-frame alpha blending (continuous 120fps motion interpolation)
 * - Delta-time independent exponential damping for buttery smooth inertia
 * - Background GPU image decoding (img.decode) preventing main-thread draw lag
 * - Predictive velocity-based lookahead queueing
 * - Subtle mouse tilt parallax in 3D perspective
 */

export function initFrameAnimator() {
  const canvas = document.getElementById('frameCanvas');
  const stage = document.getElementById('frameStage');
  if (!canvas || !stage) return;

  const ctx = canvas.getContext('2d', { alpha: false, desynchronized: true });
  if (!ctx) return;

  const FRAME_COUNT = 240;
  const FRAME_PATH = i => `/assets/Frame/${String(i + 1).padStart(5, '0')}.png`;

  const loader = document.getElementById('loader');
  const loaderBar = document.getElementById('loaderBar');
  const loadPercent = document.getElementById('loadPercent');
  const progressBar = document.getElementById('scrollProgress');
  const header = document.querySelector('.site-header');
  const scrubEnd = document.querySelector('.capability-section') || document.querySelector('.hero-section');

  const frames = new Array(FRAME_COUNT);
  const frameState = new Uint8Array(FRAME_COUNT); // 0 idle, 1 queued, 2 ready/decoded, 3 failed
  const loadQueue = [];
  const queued = new Set();
  const IS_MOBILE = matchMedia('(max-width: 767.98px)').matches;
  const MAX_CONCURRENT = IS_MOBILE ? 6 : 12;
  const READY_THRESHOLD = 24;

  let activeLoads = 0;
  let settled = 0;
  let readyFrames = 0;
  let target = 0;
  let smooth = 0;
  let lastTime = performance.now();
  let dpr = Math.min(window.devicePixelRatio || 1, IS_MOBILE ? 1.5 : 2.0);
  let pageReady = false;

  // Parallax subtle tilt
  let mouseX = 0;
  let mouseY = 0;
  let smoothMouseX = 0;
  let smoothMouseY = 0;

  function resizeCanvas() {
    dpr = Math.min(window.devicePixelRatio || 1, IS_MOBILE ? 1.5 : 2.0);
    const w = window.innerWidth;
    const h = window.innerHeight;
    canvas.width = Math.max(1, Math.floor(w * dpr));
    canvas.height = Math.max(1, Math.floor(h * dpr));
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
  }

  function drawFrame(img, alpha = 1.0, offsetX = 0, offsetY = 0) {
    if (!img || !img.naturalWidth) return;
    const cw = canvas.width;
    const ch = canvas.height;
    const iw = img.naturalWidth;
    const ih = img.naturalHeight;
    const scale = Math.max(cw / iw, ch / ih);
    const w = iw * scale;
    const h = ih * scale;
    const x = (cw - w) / 2 + offsetX;
    const y = (ch - h) / 2 + offsetY;

    ctx.globalAlpha = alpha;
    ctx.drawImage(img, x, y, w, h);
  }

  function markReady() {
    if (pageReady) return;
    pageReady = true;
    if (loaderBar) loaderBar.style.width = '100%';
    if (loadPercent) loadPercent.textContent = '100%';
    if (loader) loader.classList.add('done');
    document.body.classList.add('ready');
  }

  function updateLoader() {
    if (!loaderBar || !loadPercent) return;
    const startupPct = Math.min(100, Math.round((readyFrames / READY_THRESHOLD) * 100));
    loaderBar.style.width = startupPct + '%';
    loadPercent.textContent = startupPct + '%';

    if (readyFrames >= READY_THRESHOLD) {
      markReady();
    }
  }

  function pumpQueue() {
    while (activeLoads < MAX_CONCURRENT && loadQueue.length > 0) {
      const i = loadQueue.shift();
      if (frameState[i] !== 1) continue;
      beginFrameLoad(i);
    }
  }

  function finishFrame(i, ok) {
    activeLoads = Math.max(0, activeLoads - 1);
    settled++;
    queued.delete(i);
    frameState[i] = ok ? 2 : 3;
    if (ok) readyFrames++;
    updateLoader();
    pumpQueue();
  }

  function beginFrameLoad(i) {
    if (i < 0 || i >= FRAME_COUNT || frameState[i] !== 1) return;
    activeLoads++;

    const img = new Image();
    frames[i] = img;

    const onImageLoaded = () => {
      // Decode image off the main thread before drawing
      if ('decode' in img) {
        img.decode().then(() => {
          finishFrame(i, true);
        }).catch(() => {
          finishFrame(i, true);
        });
      } else {
        finishFrame(i, true);
      }
    };

    img.onload = onImageLoaded;
    img.onerror = () => finishFrame(i, false);
    img.src = FRAME_PATH(i);
  }

  function queueFrame(i, priority = false) {
    if (i < 0 || i >= FRAME_COUNT) return;
    if (frameState[i] === 1 && priority && !frames[i]) {
      const pos = loadQueue.indexOf(i);
      if (pos > -1) loadQueue.splice(pos, 1);
      loadQueue.unshift(i);
      return;
    }
    if (frameState[i] !== 0 || queued.has(i)) return;
    frameState[i] = 1;
    queued.add(i);
    if (priority) loadQueue.unshift(i);
    else loadQueue.push(i);
    pumpQueue();
  }

  function primeFrames() {
    // Initial batch for instantaneous startup
    const initialBatch = IS_MOBILE ? 32 : 54;
    for (let i = 0; i < initialBatch; i++) queueFrame(i, false);

    // Full preload pass
    for (let i = initialBatch; i < FRAME_COUNT; i++) {
      queueFrame(i, false);
    }
  }

  setTimeout(() => {
    if (!pageReady) markReady();
  }, 3500);

  primeFrames();

  function getScrubProgress() {
    if (!scrubEnd) return 0;
    const start = 0;
    const end = scrubEnd.offsetTop + scrubEnd.offsetHeight - window.innerHeight;
    return Math.max(0, Math.min(1, (window.scrollY - start) / Math.max(1, end - start)));
  }

  function onScroll() {
    target = getScrubProgress();
    const doc = document.documentElement;
    const pageP = window.scrollY / Math.max(1, doc.scrollHeight - window.innerHeight);

    if (progressBar) {
      progressBar.style.width = (Math.max(0, Math.min(1, pageP)) * 100) + '%';
    }
    if (header) {
      header.classList.toggle('scrolled', window.scrollY > 24);
    }

    if (scrubEnd) {
      const fadeStart = scrubEnd.offsetTop + scrubEnd.offsetHeight * 0.74;
      const fadeEnd = scrubEnd.offsetTop + scrubEnd.offsetHeight;
      const fade = Math.max(0, Math.min(1, (window.scrollY - fadeStart) / Math.max(1, fadeEnd - fadeStart)));
      stage.style.opacity = String(1 - fade);
    }
  }

  if (!IS_MOBILE) {
    window.addEventListener('pointermove', e => {
      mouseX = (e.clientX / window.innerWidth - 0.5) * 16;
      mouseY = (e.clientY / window.innerHeight - 0.5) * 12;
    }, { passive: true });
  }

  function findNearestFrame(targetIdx) {
    if (frames[targetIdx]?.complete && frames[targetIdx]?.naturalWidth) {
      return targetIdx;
    }
    for (let offset = 1; offset < FRAME_COUNT; offset++) {
      const before = targetIdx - offset;
      const after = targetIdx + offset;
      if (before >= 0 && frames[before]?.complete && frames[before]?.naturalWidth) {
        return before;
      }
      if (after < FRAME_COUNT && frames[after]?.complete && frames[after]?.naturalWidth) {
        return after;
      }
    }
    return -1;
  }

  function animate(now) {
    const dt = Math.min(0.08, (now - lastTime) / 1000);
    lastTime = now;

    // Delta-time independent exponential smoothing for buttery response
    const dampingLambda = IS_MOBILE ? 12 : 9.5;
    const factor = 1 - Math.exp(-dampingLambda * dt);
    smooth += (target - smooth) * factor;

    // Smooth subtle mouse parallax
    smoothMouseX += (mouseX - smoothMouseX) * factor;
    smoothMouseY += (mouseY - smoothMouseY) * factor;

    const rawPos = Math.max(0, Math.min(FRAME_COUNT - 1, smooth * (FRAME_COUNT - 1)));
    const frameA = Math.floor(rawPos);
    const frameB = Math.min(FRAME_COUNT - 1, frameA + 1);
    const blendFrac = rawPos - frameA;

    // Directional predictive queuing (anticipates scroll direction)
    const velocity = target - smooth;
    const lookahead = velocity >= 0 ? 8 : -8;
    const center = Math.round(rawPos);
    for (let d = -3; d <= 3; d++) {
      const n = center + d;
      if (n >= 0 && n < FRAME_COUNT) queueFrame(n, true);
    }
    for (let d = 1; d <= 6; d++) {
      const n = center + (velocity >= 0 ? d : -d);
      if (n >= 0 && n < FRAME_COUNT) queueFrame(n, true);
    }

    // High quality canvas background fill
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.fillStyle = '#cc3224';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    const readyA = frames[frameA]?.complete && frames[frameA]?.naturalWidth;
    const readyB = frames[frameB]?.complete && frames[frameB]?.naturalWidth;

    const offX = smoothMouseX * dpr;
    const offY = smoothMouseY * dpr;

    if (readyA && readyB && blendFrac > 0.001) {
      // Sub-frame cross-fade interpolation (buttery 120fps motion)
      drawFrame(frames[frameA], 1.0, offX, offY);
      drawFrame(frames[frameB], blendFrac, offX, offY);
    } else if (readyA) {
      drawFrame(frames[frameA], 1.0, offX, offY);
    } else {
      const nearest = findNearestFrame(frameA);
      if (nearest !== -1) {
        drawFrame(frames[nearest], 1.0, offX, offY);
      }
    }

    ctx.globalAlpha = 1.0;
    requestAnimationFrame(animate);
  }

  resizeCanvas();
  onScroll();
  requestAnimationFrame(animate);

  window.addEventListener('resize', () => {
    resizeCanvas();
    onScroll();
  }, { passive: true });

  window.addEventListener('scroll', onScroll, { passive: true });
}

// Automatically initialize when DOM is loaded
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initFrameAnimator);
} else {
  initFrameAnimator();
}
