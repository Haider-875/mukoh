/**
 * Mukoh Tires Web Audio Synthesizer & Sound Effects Manager
 * Pure Web Audio API: 0ms latency, zero external sound files required,
 * high-fidelity tactile automotive sound design.
 */
export class SoundManager {
  constructor() {
    this.audioCtx = null;
    this.enabled = localStorage.getItem('mukoh_sound') !== 'disabled';
    this.masterGain = null;
    this.lastSoundTime = 0;
    this.initContextOnGesture();
    this.updateToggleUI();
  }

  initContextOnGesture() {
    const unlock = () => {
      if (!this.audioCtx) {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (AudioContext) {
          this.audioCtx = new AudioContext();
          this.masterGain = this.audioCtx.createGain();
          this.masterGain.gain.setValueAtTime(0.4, this.audioCtx.currentTime);
          this.masterGain.connect(this.audioCtx.destination);
        }
      } else if (this.audioCtx.state === 'suspended') {
        this.audioCtx.resume();
      }
      window.removeEventListener('pointerdown', unlock);
      window.removeEventListener('keydown', unlock);
    };

    window.addEventListener('pointerdown', unlock, { once: true, passive: true });
    window.addEventListener('keydown', unlock, { once: true, passive: true });
  }

  toggle() {
    this.enabled = !this.enabled;
    localStorage.setItem('mukoh_sound', this.enabled ? 'enabled' : 'disabled');
    this.updateToggleUI();
    if (this.enabled) {
      this.playClick();
    }
    return this.enabled;
  }

  updateToggleUI() {
    document.querySelectorAll('.sound-toggle-btn').forEach(btn => {
      btn.classList.toggle('sound-muted', !this.enabled);
      btn.setAttribute('aria-label', this.enabled ? 'Mute website sound' : 'Unmute website sound');
      const label = btn.querySelector('.sound-label');
      if (label) label.textContent = this.enabled ? 'SOUND ON' : 'SOUND OFF';
    });
  }

  // 1. Subtle tactile button click sound (15ms damped pop)
  playClick() {
    if (!this.enabled || !this.audioCtx) return;
    const now = performance.now();
    if (now - this.lastSoundTime < 40) return; // prevent overlap
    this.lastSoundTime = now;

    try {
      const t = this.audioCtx.currentTime;
      const osc = this.audioCtx.createOscillator();
      const gain = this.audioCtx.createGain();

      osc.type = 'sine';
      osc.frequency.setValueAtTime(800, t);
      osc.frequency.exponentialRampToValueAtTime(140, t + 0.025);

      gain.gain.setValueAtTime(0.2, t);
      gain.gain.exponentialRampToValueAtTime(0.001, t + 0.025);

      osc.connect(gain);
      gain.connect(this.masterGain);

      osc.start(t);
      osc.stop(t + 0.025);
    } catch (e) {}
  }

  // 2. Navigation click sound (crisp mechanical tick)
  playNav() {
    if (!this.enabled || !this.audioCtx) return;
    const now = performance.now();
    if (now - this.lastSoundTime < 40) return;
    this.lastSoundTime = now;

    try {
      const t = this.audioCtx.currentTime;
      const osc = this.audioCtx.createOscillator();
      const gain = this.audioCtx.createGain();

      osc.type = 'triangle';
      osc.frequency.setValueAtTime(1200, t);
      osc.frequency.exponentialRampToValueAtTime(300, t + 0.03);

      gain.gain.setValueAtTime(0.25, t);
      gain.gain.exponentialRampToValueAtTime(0.001, t + 0.03);

      osc.connect(gain);
      gain.connect(this.masterGain);

      osc.start(t);
      osc.stop(t + 0.03);
    } catch (e) {}
  }

  // 3. Card interaction / filter click sound
  playCard() {
    if (!this.enabled || !this.audioCtx) return;
    const now = performance.now();
    if (now - this.lastSoundTime < 60) return;
    this.lastSoundTime = now;

    try {
      const t = this.audioCtx.currentTime;
      const osc = this.audioCtx.createOscillator();
      const gain = this.audioCtx.createGain();

      osc.type = 'sine';
      osc.frequency.setValueAtTime(450, t);
      osc.frequency.exponentialRampToValueAtTime(220, t + 0.04);

      gain.gain.setValueAtTime(0.15, t);
      gain.gain.exponentialRampToValueAtTime(0.001, t + 0.04);

      osc.connect(gain);
      gain.connect(this.masterGain);

      osc.start(t);
      osc.stop(t + 0.04);
    } catch (e) {}
  }

  // 4. Form submission celebratory success chime (C5 -> E5 -> G5 -> C6 ascending chord with decay)
  playCelebration() {
    if (!this.enabled || !this.audioCtx) return;
    try {
      const t = this.audioCtx.currentTime;
      const chord = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6

      chord.forEach((freq, index) => {
        const noteStart = t + index * 0.08;
        const osc = this.audioCtx.createOscillator();
        const gain = this.audioCtx.createGain();

        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, noteStart);

        gain.gain.setValueAtTime(0, noteStart);
        gain.gain.linearRampToValueAtTime(0.22, noteStart + 0.02);
        gain.gain.exponentialRampToValueAtTime(0.0001, noteStart + 0.6);

        osc.connect(gain);
        gain.connect(this.masterGain);

        osc.start(noteStart);
        osc.stop(noteStart + 0.6);
      });
    } catch (e) {}
  }
}

export const soundManager = new SoundManager();

// Global listener binding
if (typeof window !== 'undefined') {
  window.soundManager = soundManager;

  document.addEventListener('DOMContentLoaded', () => {
    // Sound toggle buttons
    document.querySelectorAll('.sound-toggle-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        soundManager.toggle();
      });
    });

    // Button clicks
    document.querySelectorAll('button:not(.sound-toggle-btn), .btn, .quote-button, .dark-btn').forEach(el => {
      el.addEventListener('click', () => soundManager.playClick(), { passive: true });
    });

    // Nav links
    document.querySelectorAll('.nav-link, .mobile-link').forEach(el => {
      el.addEventListener('click', () => soundManager.playNav(), { passive: true });
    });

    // Filter buttons and sort
    document.querySelectorAll('.filter-btn, .sort-select').forEach(el => {
      el.addEventListener('click', () => soundManager.playCard(), { passive: true });
    });
  });
}
