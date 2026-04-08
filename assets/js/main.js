/**
 * main.js — BarcelonaWineries.com
 *
 * Rules:
 *  - Deferred: loaded after HTML parse, never blocks rendering.
 *  - Progressive enhancement only: the site works without JS.
 *  - No frameworks, no build step.
 *  - Total budget: < 4KB minified.
 *
 * Contents:
 *  1. Region page filter bar
 *  2. Smooth scroll for anchor links
 *  3. Mobile nav toggle
 */

(function () {
    'use strict';

    // ── 1. Region Filter Bar ────────────────────────────────────────────────
    //
    // Each .grid-item has data-* attributes set in region.php:
    //   data-no-car="1|0"
    //   data-restaurant="1|0"
    //   data-organic="1|0"
    //   data-kids="1|0"
    //
    // Filtering is instant (no network request) — the full list is already
    // in the DOM. Matching items show; others get display:none via a class.

    const filterBar = document.querySelector('.filter-bar');
    const grid      = document.getElementById('winery-grid');

    if (filterBar && grid) {
        const items   = Array.from(grid.querySelectorAll('.grid-item'));
        const buttons = Array.from(filterBar.querySelectorAll('.filter-btn'));

        filterBar.addEventListener('click', (e) => {
            const btn = e.target.closest('.filter-btn');
            if (!btn) return;

            const filter = btn.dataset.filter;

            // Update active state
            buttons.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');

            // Show/hide items
            items.forEach(item => {
                const show = filter === 'all' || item.dataset[filter] === '1';
                item.hidden = !show;
            });

            // Announce result count to screen readers
            const visible = items.filter(i => !i.hidden).length;
            announceToSR(`${visible} wineries shown`);
        });
    }

    // ── 2. Smooth Scroll (respects prefers-reduced-motion) ─────────────────

    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Move focus to target for keyboard users
                    target.setAttribute('tabindex', '-1');
                    target.focus({ preventScroll: true });
                }
            });
        });
    }

    // ── 3. Mobile Nav Toggle ────────────────────────────────────────────────
    //
    // Only activates if a .nav-toggle button exists in the DOM.
    // Add <button class="nav-toggle" aria-controls="primary-nav" ...>
    // to header.php when you're ready for mobile nav.

    const navToggle = document.querySelector('.nav-toggle');
    const primaryNav = document.getElementById('primary-nav');

    if (navToggle && primaryNav) {
        navToggle.addEventListener('click', () => {
            const expanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', String(!expanded));
            primaryNav.hidden = expanded;
        });

        // Close nav on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !primaryNav.hidden) {
                primaryNav.hidden = true;
                navToggle.setAttribute('aria-expanded', 'false');
                navToggle.focus();
            }
        });
    }

    // ── Utility: Screen Reader Announcer ────────────────────────────────────

    let srAnnouncer = null;

    function announceToSR(message) {
        if (!srAnnouncer) {
            srAnnouncer = document.createElement('div');
            srAnnouncer.setAttribute('aria-live', 'polite');
            srAnnouncer.setAttribute('aria-atomic', 'true');
            srAnnouncer.className = 'sr-only';
            document.body.appendChild(srAnnouncer);
        }
        srAnnouncer.textContent = '';
        // Force DOM update then set text (ensures re-announcement)
        requestAnimationFrame(() => {
            srAnnouncer.textContent = message;
        });
    }

})();
