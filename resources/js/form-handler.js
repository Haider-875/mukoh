import confetti from 'canvas-confetti';
import { soundManager } from './sound-effects';

export function showCelebrationModal({
  title = 'SUBMITTED!',
  message = 'Your request has been successfully submitted. Our team will contact you shortly!',
  referenceNo = null
} = {}) {
  let modal = document.getElementById('celebrationModal');
  if (!modal) {
    modal = document.createElement('div');
    modal.id = 'celebrationModal';
    modal.className = 'celebration-modal-overlay';
    modal.innerHTML = `
      <div class="celebration-modal-card">
        <button class="celebration-close-btn" aria-label="Close modal">&times;</button>
        <div class="celebration-badge">REQUEST CONFIRMED</div>
        <div class="celebration-checkmark-wrap">
          <svg class="celebration-checkmark-svg" viewBox="0 0 52 52">
            <circle class="celebration-checkmark-circle" cx="26" cy="26" r="24" fill="none"/>
            <path class="celebration-checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
          </svg>
        </div>
        <h2 class="celebration-title">SUBMITTED!</h2>
        <p class="celebration-message">${message}</p>
        <div class="celebration-details" id="celebrationDetails"></div>
        <button class="btn btn-accent celebration-ok-btn">Done</button>
      </div>
    `;
    document.body.appendChild(modal);

    modal.querySelector('.celebration-close-btn').addEventListener('click', () => hideCelebrationModal());
    modal.querySelector('.celebration-ok-btn').addEventListener('click', () => hideCelebrationModal());
    modal.addEventListener('click', (e) => {
      if (e.target === modal) hideCelebrationModal();
    });
  }

  const msgEl = modal.querySelector('.celebration-message');
  if (msgEl) msgEl.textContent = message;

  const titleEl = modal.querySelector('.celebration-title');
  if (titleEl) titleEl.textContent = title;

  const detailsEl = modal.querySelector('#celebrationDetails');
  if (detailsEl) {
    if (referenceNo) {
      detailsEl.innerHTML = `<span class="ref-badge">Reference: #${referenceNo}</span>`;
      detailsEl.style.display = 'block';
    } else {
      detailsEl.style.display = 'none';
    }
  }

  // Play celebration sound
  soundManager.playCelebration();

  // Show modal
  modal.classList.add('active');

  // Trigger celebratory confetti burst
  triggerCelebratoryConfetti();
}

export function hideCelebrationModal() {
  const modal = document.getElementById('celebrationModal');
  if (modal) {
    modal.classList.remove('active');
  }
}

function triggerCelebratoryConfetti() {
  const count = 200;
  const defaults = {
    origin: { y: 0.65 },
    zIndex: 99999
  };

  function fire(particleRatio, opts) {
    confetti({
      ...defaults,
      ...opts,
      particleCount: Math.floor(count * particleRatio)
    });
  }

  fire(0.25, {
    spread: 30,
    startVelocity: 55,
    colors: ['#ef3b2d', '#ffffff', '#ff6b5e']
  });

  fire(0.2, {
    spread: 60,
    colors: ['#ffffff', '#ef3b2d', '#d92c1e']
  });

  fire(0.35, {
    spread: 100,
    decay: 0.91,
    scalar: 0.8,
    colors: ['#ef3b2d', '#ffffff', '#111111']
  });

  fire(0.1, {
    spread: 120,
    startVelocity: 25,
    decay: 0.92,
    scalar: 1.2,
    colors: ['#ef3b2d', '#ffffff']
  });

  fire(0.1, {
    spread: 120,
    startVelocity: 45,
    colors: ['#ef3b2d', '#ffffff', '#ffd700']
  });
}

/**
 * Universal AJAX Form Binder for all forms (Appointment, Contact, Quote, Tire Inquiries)
 */
export function initAjaxForms() {
  document.querySelectorAll('form[data-ajax-form]').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn ? submitBtn.innerHTML : 'Submit';

      // Clear existing alerts inside form
      const existingAlert = form.querySelector('.form-status-alert');
      if (existingAlert) existingAlert.remove();

      // Disable button & show spinner
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          SUBMITTING...
        `;
      }

      const formData = new FormData(form);
      const url = form.getAttribute('action') || window.location.href;
      const method = (form.getAttribute('method') || 'POST').toUpperCase();

      try {
        const response = await fetch(url, {
          method: method,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          },
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
          form.reset();
          showCelebrationModal({
            title: data.title || 'SUBMITTED!',
            message: data.message || 'Your request has been successfully submitted. Our team will contact you shortly!',
            referenceNo: data.reference_no || null
          });
        } else {
          // Validation error or failure
          const errors = data.errors ? Object.values(data.errors).flat().join('<br>') : (data.message || 'Submission failed. Please check the fields and try again.');
          const alertDiv = document.createElement('div');
          alertDiv.className = 'form-status-alert form-alert-error';
          alertDiv.innerHTML = `<strong>Error:</strong><br>${errors}`;
          form.prepend(alertDiv);
          alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      } catch (err) {
        console.error('Submission error:', err);
        const alertDiv = document.createElement('div');
        alertDiv.className = 'form-status-alert form-alert-error';
        alertDiv.innerHTML = '<strong>Network error:</strong> Unable to submit at this moment. Please call us at (240) 854-0273.';
        form.prepend(alertDiv);
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;
        }
      }
    });
  });
}

if (typeof window !== 'undefined') {
  window.showCelebrationModal = showCelebrationModal;
  window.hideCelebrationModal = hideCelebrationModal;
  document.addEventListener('DOMContentLoaded', initAjaxForms);
}
