// Global toast utility wrapper
// Uses toastr if available (loaded via CDN in layout). Falls back to a minimal DOM toast if not.
const defaultOptions = {
  closeButton: true,
  progressBar: true,
  positionClass: 'toast-top-right',
  timeOut: 4000,
};

export function showToast(message, type = 'info', options = {}) {
  // Use our modern DOM toast UI by default. If callers specifically want the
  // legacy toastr build they can pass { useToastr: true } in options.
  const useToastr = options && options.useToastr;
  const t = (type === 'error') ? 'error' : (type === 'warn' || type === 'warning') ? 'warning' : (type === 'success') ? 'success' : 'info';

  if (useToastr && typeof toastr !== 'undefined' && typeof toastr[t] === 'function') {
    try {
      toastr.options = Object.assign({}, defaultOptions, options || {});
      toastr[t](message);
      return;
    } catch (err) {
      // eslint-disable-next-line no-console
      console.warn('toastr invocation failed, falling back to DOM toast', err);
    }
  }

  // Modern DOM toast implementation: SVG icons, subtle card, rounded close, and progress bar
  const containerId = 'toast-container';
  let container = document.getElementById(containerId);
  if (!container) {
    container = document.createElement('div');
    container.id = containerId;
    // flush the container to the right edge (no extra margin). keep a small
    // inner padding so toasts don't sit exactly at the browser edge.
    container.className = 'fixed top-4 right-0 z-50 space-y-3 max-w-sm pr-4';
    container.setAttribute('aria-live', 'polite');
    container.setAttribute('aria-atomic', 'true');
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  // make toast relative so we can absolutely position the close button at
  // the top-right corner; use flex-col for two-row layout.
  toast.className = 'relative bg-white border border-gray-100 shadow-sm rounded-lg pl-0 pr-2 py-2 flex flex-col transform transition-all duration-300 ease-out';
  toast.setAttribute('role', 'status');
  toast.setAttribute('tabindex', '0');

  // Colors per type
  const colorMap = {
    success: { bg: 'bg-green-100', icon: 'text-green-600', bar: 'bg-green-500' },
    error: { bg: 'bg-red-100', icon: 'text-red-600', bar: 'bg-red-500' },
    warning: { bg: 'bg-yellow-100', icon: 'text-yellow-600', bar: 'bg-yellow-500' },
    info: { bg: 'bg-blue-100', icon: 'text-blue-600', bar: 'bg-blue-500' },
  };
  const meta = colorMap[t] || colorMap.info;

  // Top row: icon, message, close button
  const topRow = document.createElement('div');
  // remove left padding on the row and allow the icon to sit flush
  topRow.className = 'flex items-start gap-3 pl-0';

  const iconWrap = document.createElement('div');
  // pull the icon slightly left so it touches the card edge (use -mlF-2 or change as needed)
  iconWrap.className = `flex-shrink-0 h-8 w-8 -ml-2 rounded-full flex items-center justify-center ${meta.bg}`;
  iconWrap.innerHTML = getIconSvg(t, meta.icon);

  // Message container
  const body = document.createElement('div');
  // add right padding so message text won't flow under the absolutely
  // positioned close button
  body.className = 'flex-1 min-w-0 pr-8';
  const msg = document.createElement('div');
  msg.className = 'text-sm text-gray-800';
  msg.textContent = message;
  body.appendChild(msg);

  // Close button (modern SVG) - absolutely positioned at top-right of toast
  const closeBtn = document.createElement('button');
  closeBtn.type = 'button';
  closeBtn.className = 'absolute top-2 right-2 inline-flex items-center justify-center h-6 w-6 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none';
  closeBtn.setAttribute('aria-label', 'Dismiss notification');
  // make the icon slightly smaller so the button is less visually dominant
  closeBtn.innerHTML = closeSvg();

  topRow.appendChild(iconWrap);
  topRow.appendChild(body);
  // append close button to toast (absolute), not inside the flow row
  toast.appendChild(closeBtn);

  // Bottom row: progress bar spanning full width
  const progressWrap = document.createElement('div');
  progressWrap.className = 'w-full mt-3';
  const progress = document.createElement('div');
  progress.className = 'h-1 w-full rounded-b-md overflow-hidden bg-gray-100';
  const progressInner = document.createElement('div');
  progressInner.className = `${meta.bar} h-1 w-full transition-all ease-linear`;
  progress.appendChild(progressInner);
  progressWrap.appendChild(progress);

  // Compose: top row then progress row
  toast.appendChild(topRow);
  toast.appendChild(progressWrap);

  // Insert
  container.appendChild(toast);

  // Force enter animation
  requestAnimationFrame(() => {
    toast.classList.remove('opacity-0', 'translate-y-2');
  });

  // Auto-dismiss timer with progress animation
  const timeout = (options && options.timeOut) || defaultOptions.timeOut;
  // allow slightly longer transition to make progress smooth
  progressInner.style.transitionDuration = `${Math.max(300, timeout)}ms`;
  // trigger shrink after a tick
  setTimeout(() => { progressInner.style.width = '0%'; }, 50);

  const timer = setTimeout(() => {
    removeToast(toast);
  }, timeout);

  // Close handler
  closeBtn.addEventListener('click', () => {
    clearTimeout(timer);
    removeToast(toast);
  });
}

function removeToast(el) {
  if (!el) return;
  el.classList.add('opacity-0', 'translate-y-2');
  // allow animation to finish
  setTimeout(() => el.remove(), 300);
}

function getIconSvg(type, colorClass) {
  // returns SVG markup string for the given type
  switch (type) {
    case 'success':
      return `<svg class="h-10 w-10 ${colorClass}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>`;
    case 'error':
      return `<svg class="h-5 w-5 ${colorClass}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`;
    case 'warning':
      return `<svg class="h-5 w-5 ${colorClass}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`;
    default:
      return `<svg class="h-5 w-5 ${colorClass}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20.5c4.142 0 7.5-3.358 7.5-7.5S16.142 5.5 12 5.5 4.5 8.858 4.5 13 7.858 20.5 12 20.5z"/></svg>`;
  }
}

function closeSvg() {
  return `<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>`;
}

// Attach to window for legacy inline scripts expecting showToast
if (typeof window !== 'undefined') {
  // Drain any queued toast calls made before the bundle loaded
  const existing = window.__toastQueue || [];
  window.showToast = showToast;
  if (Array.isArray(existing) && existing.length) {
    existing.forEach(q => {
      try { showToast(q.message, q.type, q.options); } catch (e) { /* ignore */ }
    });
    window.__toastQueue = [];
  }
}

export default showToast;
