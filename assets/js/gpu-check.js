/**
 * GPU Performance Check - Embeddable Widget
 * Detects integrated GPU usage and shows a dismissable warning
 * Copyright 2025 manthrax
 * Licensed under MIT License
 * 
 * Usage: <script src="https://manthrax.github.io/gpuinfo/gpu-check.js" async></script>
 * 
 * Optional config via data attributes:
 * data-info-url: Custom URL to your GPU info page (default: auto-detect from script src)
 * data-check-delay: Delay before checking in ms (default: 1000)
 * 
 * Example with custom URL:
 * <script src="gpu-check.js" data-info-url="https://example.com/gpu-help" async></script>
 */

(function() {
  'use strict';
  
  // Check if already ran or user dismissed
  // if (window.__gpuCheckRan || localStorage.getItem('gpu-check-dismissed')) {
  if (window.__gpuCheckRan) {
    return;
  }
  window.__gpuCheckRan = true;

  // Get config from script tag
  const scriptTag = document.currentScript || document.querySelector('script[src*="gpu-check"]');
  const config = {
    infoUrl: scriptTag?.dataset.infoUrl || scriptTag?.src.replace(/gpu-check\.js.*$/, ''),
    delay: parseInt(scriptTag?.dataset.checkDelay || '1000', 10)
  };

  // Wait for DOM and WebGL context to be ready
  setTimeout(function() {
    try {
      // Create temporary canvas for GPU detection
      const canvas = document.createElement('canvas');
      let gl = canvas.getContext('webgl2');
      const isWebGL2 = !!gl;
      if (!gl) {
        gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
      }

      // If no WebGL support, don't show anything (bigger problem than iGPU)
      if (!gl) return;

      // Get GPU info
      const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
      if (!debugInfo) return;

      const renderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
      
      // Check if integrated GPU
      if (!isIntegratedGPU(renderer)) return;

      // Show warning overlay
      showWarning(renderer);

    } catch (err) {
      // Silently fail - don't disrupt the app
      console.debug('[GPU Check] Error:', err);
    }
  }, config.delay);

  function isIntegratedGPU(renderer) {
    if (!renderer || renderer === 'Unknown') return false;
    const r = renderer.toLowerCase();
    
    // Intel integrated GPUs
    if (r.includes('intel') && (
      r.includes('hd graphics') || 
      r.includes('uhd graphics') || 
      r.includes('iris')
    )) return true;
    
    // AMD APU integrated graphics
    if (r.includes('amd') && r.includes('radeon') && 
        (r.includes('vega') || r.includes('graphics')) &&
        !r.includes(' rx ') && !r.includes(' pro ')) {
      return true;
    }
    
    // Software renderers
    if (r.includes('microsoft basic render') || 
        r.includes('swiftshader') || 
        r.includes('llvmpipe')) {
      return true;
    }
    
    return false;
  }

  function showWarning(gpuName) {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.innerHTML = `
      <style>
        .gpu-check-overlay {
          position: fixed;
          bottom: 20px;
          right: 20px;
          max-width: 400px;
          background: linear-gradient(135deg, #1a1f35 0%, #0d1420 100%);
          border: 2px solid #f59e0b;
          border-radius: 12px;
          padding: 20px;
          box-shadow: 0 10px 40px rgba(0,0,0,0.5);
          font-family: system-ui, -apple-system, sans-serif;
          color: #e7eaf3;
          z-index: 999999;
          animation: gpu-check-slide-in 0.4s ease-out;
        }
        @keyframes gpu-check-slide-in {
          from { transform: translateX(450px); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
        .gpu-check-header {
          display: flex;
          justify-content: space-between;
          align-items: start;
          margin-bottom: 12px;
        }
        .gpu-check-title {
          font-size: 16px;
          font-weight: 700;
          color: #f59e0b;
          display: flex;
          align-items: center;
          gap: 8px;
        }
        .gpu-check-close {
          background: none;
          border: none;
          color: #9aa3b2;
          font-size: 24px;
          cursor: pointer;
          padding: 0;
          line-height: 1;
          width: 24px;
          height: 24px;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 4px;
        }
        .gpu-check-close:hover {
          background: rgba(255,255,255,0.1);
          color: #e7eaf3;
        }
        .gpu-check-body {
          font-size: 14px;
          line-height: 1.5;
          color: #9aa3b2;
          margin-bottom: 16px;
        }
        .gpu-check-gpu {
          background: rgba(245, 158, 11, 0.1);
          padding: 8px 12px;
          border-radius: 6px;
          font-size: 13px;
          margin: 10px 0;
          border-left: 3px solid #f59e0b;
        }
        .gpu-check-actions {
          display: flex;
          gap: 10px;
        }
        .gpu-check-btn {
          flex: 1;
          padding: 10px 16px;
          border: none;
          border-radius: 8px;
          font-weight: 600;
          cursor: pointer;
          font-size: 14px;
          transition: all 0.2s;
        }
        .gpu-check-btn-primary {
          background: #6366f1;
          color: white;
        }
        .gpu-check-btn-primary:hover {
          background: #4f46e5;
        }
        .gpu-check-btn-secondary {
          background: rgba(255,255,255,0.1);
          color: #e7eaf3;
        }
        .gpu-check-btn-secondary:hover {
          background: rgba(255,255,255,0.15);
        }
        @media (max-width: 480px) {
          .gpu-check-overlay {
            bottom: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
          }
        }
      </style>
      <div class="gpu-check-overlay">
        <div class="gpu-check-header">
          <div class="gpu-check-title">
            <span>⚠️</span>
            Hardware Acceleration Not Detected
          </div>
          <button class="gpu-check-close" onclick="this.closest('.gpu-check-overlay').remove(); localStorage.setItem('gpu-check-dismissed', Date.now());">×</button>
        </div>
        <div class="gpu-check-body">
          Hardware acceleration is not detected in your browser. This app may lag, leading to an unoptimal experience.
          <div class="gpu-check-gpu">🎮 Detected: ${escapeHtml(gpuName)}</div>
          Enable hardware acceleration for better performance.
        </div>
        <div class="gpu-check-actions">
          <button class="gpu-check-btn gpu-check-btn-secondary" onclick="this.closest('.gpu-check-overlay').remove(); localStorage.setItem('gpu-check-dismissed', Date.now());">
            Dismiss
          </button>
          <button class="gpu-check-btn gpu-check-btn-primary" onclick="window.open('${config.infoUrl}', '_blank')">
            Show Me How
          </button>
        </div>
      </div>
    `;
    
    document.body.appendChild(overlay);
  }

  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }
})();
