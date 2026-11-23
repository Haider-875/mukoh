import * as THREE from 'three';

export class MukohTireViewer {
  constructor(canvasId, containerId) {
    this.canvas = document.getElementById(canvasId);
    this.container = document.getElementById(containerId) || document.body;
    if (!this.canvas) return;

    this.isMobile = window.matchMedia('(max-width: 768px)').matches;
    this.scrollProgress = 0;
    this.targetScroll = 0;
    this.smoothScroll = 0;
    this.mouseX = 0;
    this.mouseY = 0;
    this.targetMouseX = 0;
    this.targetMouseY = 0;
    this.isDragging = false;
    this.prevDragX = 0;
    this.prevDragY = 0;
    this.dragRotationX = 0;
    this.dragRotationY = 0;
    this.clock = new THREE.Clock();

    this.initScene();
    this.generateProceduralTextures();
    this.buildWheelModel();
    this.setupLighting();
    this.setupInteractions();
    this.onResize();
    this.animate();
  }

  initScene() {
    this.scene = new THREE.Scene();
    this.camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 0.1, 100);
    this.camera.position.set(0, 0, 5.2);

    const dpr = Math.min(window.devicePixelRatio || 1, this.isMobile ? 1.5 : 2.5);
    this.renderer = new THREE.WebGLRenderer({
      canvas: this.canvas,
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance',
      stencil: false,
      depth: true
    });
    this.renderer.setSize(window.innerWidth, window.innerHeight);
    this.renderer.setPixelRatio(dpr);
    this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
    this.renderer.toneMappingExposure = 1.15;
    this.renderer.outputColorSpace = THREE.SRGBColorSpace;

    this.tireGroup = new THREE.Group();
    this.scene.add(this.tireGroup);
  }

  generateProceduralTextures() {
    // 1. High-Res Tire Tread & Sidewall Bump/Normal Map (4096 x 1024)
    const tw = 4096;
    const th = 1024;
    const treadCanvas = document.createElement('canvas');
    treadCanvas.width = tw;
    treadCanvas.height = th;
    const ctx = treadCanvas.getContext('2d');

    // Neutral gray baseline
    ctx.fillStyle = '#808080';
    ctx.fillRect(0, 0, tw, th);

    // Tread area occupies middle 60% of Y
    const treadTop = th * 0.2;
    const treadBottom = th * 0.8;
    const treadHeight = treadBottom - treadTop;

    // 4 Longitudinal deep rain grooves
    const grooveYs = [
      treadTop + treadHeight * 0.18,
      treadTop + treadHeight * 0.38,
      treadTop + treadHeight * 0.62,
      treadTop + treadHeight * 0.82
    ];

    ctx.fillStyle = '#101010'; // Deep groove depression
    grooveYs.forEach(gy => {
      ctx.fillRect(0, gy - 12, tw, 24);
      // Groove bevels
      ctx.fillStyle = '#404040';
      ctx.fillRect(0, gy - 18, tw, 6);
      ctx.fillRect(0, gy + 12, tw, 6);
      ctx.fillStyle = '#101010';
    });

    // Angled Lateral Sipes across the circumference
    const sipeCount = 120;
    const sipeSpacing = tw / sipeCount;
    ctx.strokeStyle = '#202020';
    ctx.lineWidth = 4;
    ctx.lineCap = 'round';

    for (let i = 0; i < sipeCount; i++) {
      const x = i * sipeSpacing;
      // Outer tread sipes (top & bottom shoulder blocks)
      ctx.beginPath();
      ctx.moveTo(x, treadTop + 10);
      ctx.lineTo(x + 25, grooveYs[0] - 15);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(x + 10, grooveYs[1] + 15);
      ctx.lineTo(x + 35, grooveYs[2] - 15);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(x + 20, grooveYs[3] + 15);
      ctx.lineTo(x + 45, treadBottom - 10);
      ctx.stroke();

      // Inter-block micro-sipes
      ctx.lineWidth = 2;
      ctx.strokeStyle = '#353535';
      ctx.beginPath();
      ctx.moveTo(x + 12, treadTop + 25);
      ctx.lineTo(x + 28, grooveYs[0] - 25);
      ctx.stroke();
      ctx.lineWidth = 4;
      ctx.strokeStyle = '#202020';
    }

    // Sidewall Typography and concentric bead rings
    ctx.fillStyle = '#b0b0b0'; // Embossed lettering highlight
    ctx.font = 'bold 38px Inter, sans-serif';
    ctx.textAlign = 'center';
    ctx.letterSpacing = '12px';

    const brandRepeats = 4;
    const brandSpacing = tw / brandRepeats;
    for (let i = 0; i < brandRepeats; i++) {
      const bx = i * brandSpacing + brandSpacing * 0.5;
      // Top sidewall
      ctx.fillText('MUKOH  SPORT  ZR  •  ULTRA  HIGH  PERFORMANCE', bx, th * 0.11);
      // Bottom sidewall
      ctx.fillText('245 / 40  ZR18  97W  XL  •  RADIAL  TUBELESS', bx, th * 0.91);
    }

    // Sidewall safety ribs
    ctx.strokeStyle = '#484848';
    ctx.lineWidth = 3;
    for (let r = 0; r < 3; r++) {
      ctx.beginPath();
      ctx.moveTo(0, th * 0.04 + r * 14);
      ctx.lineTo(tw, th * 0.04 + r * 14);
      ctx.stroke();

      ctx.beginPath();
      ctx.moveTo(0, th * 0.94 + r * 14);
      ctx.lineTo(tw, th * 0.94 + r * 14);
      ctx.stroke();
    }

    this.treadBumpMap = new THREE.CanvasTexture(treadCanvas);
    this.treadBumpMap.wrapS = THREE.RepeatWrapping;
    this.treadBumpMap.wrapT = THREE.ClampToEdgeWrapping;
    this.treadBumpMap.repeat.set(1, 1);
    this.treadBumpMap.anisotropy = this.renderer.capabilities.getMaxAnisotropy();

    // 2. Wheel Center Cap Emblem ("M" logo on spun gunmetal aluminum)
    const capCanvas = document.createElement('canvas');
    capCanvas.width = 1024;
    capCanvas.height = 1024;
    const cctx = capCanvas.getContext('2d');

    // Radial brushed metal gradient
    const grad = cctx.createRadialGradient(512, 512, 10, 512, 512, 512);
    grad.addColorStop(0, '#2a2a2a');
    grad.addColorStop(0.7, '#141414');
    grad.addColorStop(1, '#080808');
    cctx.fillStyle = grad;
    cctx.fillRect(0, 0, 1024, 1024);

    // Chrome outer ring
    cctx.strokeStyle = '#cccccc';
    cctx.lineWidth = 28;
    cctx.beginPath();
    cctx.arc(512, 512, 480, 0, Math.PI * 2);
    cctx.stroke();

    // Red inner ring
    cctx.strokeStyle = '#ef3b2d';
    cctx.lineWidth = 14;
    cctx.beginPath();
    cctx.arc(512, 512, 440, 0, Math.PI * 2);
    cctx.stroke();

    // "M" Brand Logo
    cctx.fillStyle = '#ffffff';
    cctx.font = '900 480px Inter, sans-serif';
    cctx.textAlign = 'center';
    cctx.textBaseline = 'middle';
    cctx.fillText('M', 512, 500);

    // Red slash brand accent
    cctx.fillStyle = '#ef3b2d';
    cctx.beginPath();
    cctx.ellipse(650, 720, 90, 24, -Math.PI / 4, 0, Math.PI * 2);
    cctx.fill();

    this.capTexture = new THREE.CanvasTexture(capCanvas);
    this.capTexture.anisotropy = this.renderer.capabilities.getMaxAnisotropy();
  }

  buildWheelModel() {
    // Tire Geometry: Torus with realistic tire profile
    // Outer radius 1.8, tube radius 0.65
    const tireGeometry = new THREE.TorusGeometry(1.68, 0.62, 48, 128);

    const tireMaterial = new THREE.MeshStandardMaterial({
      color: 0x121212,
      roughness: 0.88,
      metalness: 0.08,
      bumpMap: this.treadBumpMap,
      bumpScale: 0.045
    });

    this.tireMesh = new THREE.Mesh(tireGeometry, tireMaterial);
    this.tireGroup.add(this.tireMesh);

    // Rim Outer Lip & Barrel
    const rimRadius = 1.28;
    const rimWidth = 0.88;
    const rimGeometry = new THREE.CylinderGeometry(rimRadius, rimRadius, rimWidth, 64, 1, true);
    const rimMaterial = new THREE.MeshStandardMaterial({
      color: 0xd8d8d8,
      roughness: 0.18,
      metalness: 0.92,
      side: THREE.DoubleSide
    });
    this.rimMesh = new THREE.Mesh(rimGeometry, rimMaterial);
    this.rimMesh.rotation.x = Math.PI / 2;
    this.tireGroup.add(this.rimMesh);

    // Machined Rim Face Outer Ring
    const rimRingGeo = new THREE.TorusGeometry(rimRadius, 0.06, 24, 64);
    const rimLipMaterial = new THREE.MeshStandardMaterial({
      color: 0xf5f5f5,
      roughness: 0.12,
      metalness: 0.95
    });
    const rimFrontLip = new THREE.Mesh(rimRingGeo, rimLipMaterial);
    rimFrontLip.position.z = rimWidth / 2;
    this.tireGroup.add(rimFrontLip);

    // 5-Split Twin-Spoke System
    const spokeCount = 5;
    const spokeGroup = new THREE.Group();
    spokeGroup.position.z = rimWidth / 2 - 0.04;

    const spokeMaterial = new THREE.MeshStandardMaterial({
      color: 0xb0b0b8,
      roughness: 0.22,
      metalness: 0.88
    });

    for (let i = 0; i < spokeCount; i++) {
      const angle = (i * Math.PI * 2) / spokeCount;
      const subSpokeAngles = [angle - 0.08, angle + 0.08];

      subSpokeAngles.forEach(sa => {
        const spokeGeo = new THREE.BoxGeometry(0.12, rimRadius * 0.96, 0.08);
        const spoke = new THREE.Mesh(spokeGeo, spokeMaterial);
        spoke.position.x = Math.sin(sa) * (rimRadius * 0.48);
        spoke.position.y = Math.cos(sa) * (rimRadius * 0.48);
        spoke.rotation.z = -sa;
        spokeGroup.add(spoke);
      });
    }
    this.tireGroup.add(spokeGroup);

    // Central Wheel Hub & Cap
    const hubGeometry = new THREE.CylinderGeometry(0.38, 0.42, 0.14, 32);
    const hubMaterial = new THREE.MeshStandardMaterial({
      color: 0x1a1a1a,
      roughness: 0.25,
      metalness: 0.85
    });
    const hubMesh = new THREE.Mesh(hubGeometry, hubMaterial);
    hubMesh.rotation.x = Math.PI / 2;
    hubMesh.position.z = rimWidth / 2;
    this.tireGroup.add(hubMesh);

    // Center Cap with Mukoh Logo
    const capGeo = new THREE.CircleGeometry(0.36, 32);
    const capMat = new THREE.MeshStandardMaterial({
      map: this.capTexture,
      roughness: 0.3,
      metalness: 0.6
    });
    const capMesh = new THREE.Mesh(capGeo, capMat);
    capMesh.position.z = rimWidth / 2 + 0.075;
    this.tireGroup.add(capMesh);

    // Lug Nuts (5 chrome hex studs around hub)
    const lugMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.1,
      metalness: 0.98
    });
    for (let i = 0; i < 5; i++) {
      const la = (i * Math.PI * 2) / 5 + 0.31;
      const lugGeo = new THREE.CylinderGeometry(0.045, 0.045, 0.08, 6);
      const lug = new THREE.Mesh(lugGeo, lugMaterial);
      lug.rotation.x = Math.PI / 2;
      lug.position.set(Math.sin(la) * 0.25, Math.cos(la) * 0.25, rimWidth / 2 + 0.06);
      this.tireGroup.add(lug);
    }

    // Ventilated Brake Rotor Disc behind spokes
    const rotorGeo = new THREE.RingGeometry(0.42, 1.15, 48);
    const rotorMat = new THREE.MeshStandardMaterial({
      color: 0x7c7c84,
      roughness: 0.35,
      metalness: 0.85,
      side: THREE.DoubleSide
    });
    const rotor = new THREE.Mesh(rotorGeo, rotorMat);
    rotor.position.z = 0.12;
    this.tireGroup.add(rotor);

    // High-Performance Red Brake Caliper
    const caliperGeo = new THREE.BoxGeometry(0.28, 0.68, 0.22);
    const caliperMat = new THREE.MeshStandardMaterial({
      color: 0xef3b2d, // signature Mukoh red
      roughness: 0.28,
      metalness: 0.4
    });
    const caliper = new THREE.Mesh(caliperGeo, caliperMat);
    caliper.position.set(0.88, 0.35, 0.22);
    caliper.rotation.z = -0.38;
    this.tireGroup.add(caliper);

    // Initial position & cinematic angle
    this.tireGroup.rotation.x = 0.25;
    this.tireGroup.rotation.y = -0.55;
    this.tireGroup.position.set(this.isMobile ? 0 : 0.8, -0.15, 0);
  }

  setupLighting() {
    // Key Light: Clean white studio key
    this.keyLight = new THREE.DirectionalLight(0xffffff, 2.6);
    this.keyLight.position.set(-3, 4, 5);
    this.scene.add(this.keyLight);

    // Fill Light: Soft cool ambient
    this.fillLight = new THREE.DirectionalLight(0xbad2e8, 1.2);
    this.fillLight.position.set(3, -2, 4);
    this.scene.add(this.fillLight);

    // Dramatic Rim / Backlight: Signature Mukoh Red Glow (#ef3b2d)
    this.rimLight = new THREE.DirectionalLight(0xef3b2d, 3.8);
    this.rimLight.position.set(4, 2, -3);
    this.scene.add(this.rimLight);

    // Underbody bounce light
    this.bounceLight = new THREE.PointLight(0xff4433, 1.8, 10);
    this.bounceLight.position.set(0, -3, 2);
    this.scene.add(this.bounceLight);

    // Ambient light
    const ambient = new THREE.AmbientLight(0x18181f, 1.4);
    this.scene.add(ambient);
  }

  setupInteractions() {
    // Window scroll tracking
    window.addEventListener('scroll', () => {
      const scrubEnd = document.querySelector('.capability-section') || document.body;
      const end = scrubEnd.offsetTop + scrubEnd.offsetHeight - window.innerHeight;
      this.targetScroll = Math.max(0, Math.min(1, window.scrollY / Math.max(1, end)));

      // Fade out when scrolling into Services
      const fadeStart = scrubEnd.offsetTop + scrubEnd.offsetHeight * 0.72;
      const fadeEnd = scrubEnd.offsetTop + scrubEnd.offsetHeight;
      const fade = Math.max(0, Math.min(1, (window.scrollY - fadeStart) / Math.max(1, fadeEnd - fadeStart)));
      if (this.canvas) {
        this.canvas.style.opacity = String(1 - fade);
      }
    }, { passive: true });

    // Interactive pointer drag / orbit
    const targetElement = document.querySelector('.hero-section') || window;

    targetElement.addEventListener('pointerdown', (e) => {
      this.isDragging = true;
      this.prevDragX = e.clientX;
      this.prevDragY = e.clientY;
    });

    window.addEventListener('pointermove', (e) => {
      if (this.isDragging) {
        const dx = e.clientX - this.prevDragX;
        const dy = e.clientY - this.prevDragY;
        this.dragRotationY += dx * 0.005;
        this.dragRotationX += dy * 0.005;
        this.prevDragX = e.clientX;
        this.prevDragY = e.clientY;
      }

      this.targetMouseX = (e.clientX / window.innerWidth - 0.5) * 0.5;
      this.targetMouseY = (e.clientY / window.innerHeight - 0.5) * 0.5;
    }, { passive: true });

    window.addEventListener('pointerup', () => {
      this.isDragging = false;
    });

    window.addEventListener('resize', () => this.onResize());
  }

  onResize() {
    this.isMobile = window.matchMedia('(max-width: 768px)').matches;
    const width = window.innerWidth;
    const height = window.innerHeight;

    this.camera.aspect = width / height;
    this.camera.updateProjectionMatrix();

    const dpr = Math.min(window.devicePixelRatio || 1, this.isMobile ? 1.5 : 2.5);
    this.renderer.setSize(width, height);
    this.renderer.setPixelRatio(dpr);

    if (this.isMobile) {
      this.tireGroup.position.set(0, 0.2, 0);
      this.tireGroup.scale.set(0.72, 0.72, 0.72);
    } else {
      this.tireGroup.position.set(0.95, -0.1, 0);
      this.tireGroup.scale.set(1.0, 1.0, 1.0);
    }
  }

  animate() {
    requestAnimationFrame(() => this.animate());

    const delta = this.clock.getDelta();
    const time = this.clock.getElapsedTime();

    // Smooth scroll interpolation
    this.smoothScroll += (this.targetScroll - this.smoothScroll) * 0.08;

    // Mouse tilt interpolation
    this.mouseX += (this.targetMouseX - this.mouseX) * 0.05;
    this.mouseY += (this.targetMouseY - this.mouseY) * 0.05;

    // Inertial drag decay
    if (!this.isDragging) {
      this.dragRotationX *= 0.95;
      this.dragRotationY *= 0.95;
    }

    if (this.tireGroup) {
      // Base rotation + scroll-driven rotation + subtle floating drift + user drag
      const scrollRotation = this.smoothScroll * Math.PI * 4;
      const floatingX = Math.sin(time * 1.2) * 0.04;
      const floatingY = Math.cos(time * 0.9) * 0.03;

      // Scroll changes angles: starts side profile in Hero, turns facing viewer in Capability section
      const targetBaseY = -0.55 + this.smoothScroll * 1.8;
      const targetBaseX = 0.25 - this.smoothScroll * 0.4;

      this.tireGroup.rotation.y = targetBaseY + scrollRotation * 0.4 + this.mouseX + this.dragRotationY + floatingY;
      this.tireGroup.rotation.x = targetBaseX + this.mouseY + this.dragRotationX + floatingX;
      this.tireGroup.rotation.z = -scrollRotation * 0.8;

      // Move tire horizontally on scroll to frame text perfectly
      if (!this.isMobile) {
        const targetPosX = 0.95 - this.smoothScroll * 0.55;
        this.tireGroup.position.x += (targetPosX - this.tireGroup.position.x) * 0.08;
      }
    }

    this.renderer.render(this.scene, this.camera);
  }
}

// Global auto-mount if frameCanvas is present
if (typeof window !== 'undefined') {
  window.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('frameCanvas');
    if (canvas) {
      window.mukohTireViewer = new MukohTireViewer('frameCanvas', 'frameStage');
    }
  });
}
