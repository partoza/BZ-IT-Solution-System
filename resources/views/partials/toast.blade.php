<!-- Reusable toast container. We render modern DOM toasts here (SVG icons, close control, progress bar).
	Note: legacy Toastr (if used) will create its own container; our DOM toasts ignore toastr by default
	unless callers pass { useToastr: true } when calling showToast. -->
<div id="toast-container" class="fixed top-5 right-8 z-50 space-y-3 max-w-sm" aria-live="polite" aria-atomic="true"></div>
