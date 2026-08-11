# Animated brand assets

Professional CSS-animated SVGs for ReportKit / Kit-Larva. Source of truth: this folder.

| File | Use |
|------|-----|
| `kit-larva-idle.svg` | Docs hero, README, idle mascot |
| `kit-larva-prepare.svg` | Prepare overlay, async loader |
| `lldp-flow.svg` | LLDP phase diagram (P → S → C → D) |
| `reportkit-loader.svg` | Compact 128×128 spinner |

## Playback

- **Inline** in HTML or **`<object type="image/svg+xml" data="…">`** — animations run in modern browsers.
- **`<img src="…svg">`** may not animate in all browsers; prefer object/embed for motion.
- **`prefers-reduced-motion: reduce`** — animations disable automatically.

## GIF fallbacks

`kit-larva-idle.gif` and `kit-larva-prepare.gif` ship for email, Packagist, and contexts that cannot play SVG motion.

Regenerate rollout copies:

```bash
./scripts/sync-brand-assets.sh
```
