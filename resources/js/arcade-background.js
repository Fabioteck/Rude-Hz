/**
 * RUDE-HZ - 80s Vector Arcade Space Background Animation Engine
 * Style: Asteroids / Tempest vector arcade (mature, dynamic, 60fps, thin wireframe lines)
 * Features:
 * - Pale Yellow Moon (#F4E99B) with subtle vector craters in top-right
 * - Mothership cruising upper band
 * - UFO squadrons with sine-wave motion, mouse/touch avoidance, and laser beams
 * - Defender ship at bottom tracking cursor, firing laser bolts & micro-sparks
 * - Starfield parallax / twinkle
 * - Mobile optimization (< 768px reduces entity counts)
 */

document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('network-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    let width, height;
    let stars = [];
    let invaders = [];
    let lasers = [];
    let sparks = [];
    
    let mothership = { x: -120, y: 50, speed: 0.4 };
    let defender = { x: window.innerWidth / 2, y: window.innerHeight - 50, targetX: window.innerWidth / 2 };
    
    let mouse = { x: null, y: null, radius: 160 };
    let lastLaserTime = 0;

    const fluoColors = ['#00FF66', '#FF007F', '#9D00FF', '#E6FF00', '#F4E99B'];

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        defender.y = height - 50;

        const isMobile = width < 768;
        
        // 1. Starfield
        stars = [];
        const starCount = isMobile ? 35 : 85;
        for (let i = 0; i < starCount; i++) {
            stars.push({
                x: Math.random() * width,
                y: Math.random() * height,
                size: Math.random() * 1.5 + 0.5,
                color: fluoColors[Math.floor(Math.random() * (fluoColors.length - 1))],
                alpha: Math.random() * 0.7 + 0.3,
                pulse: Math.random() * 0.015 + 0.003
            });
        }

        // 2. UFO / Invader Squadrons
        invaders = [];
        const rows = isMobile ? 1 : 2;
        const cols = isMobile ? 3 : 6;
        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                invaders.push({
                    baseX: c * 70 + 80,
                    baseY: r * 50 + 130,
                    offsetX: 0,
                    offsetY: 0,
                    color: fluoColors[(r + c) % (fluoColors.length - 1)],
                    type: (r + c) % 2 === 0 ? 'ufo' : 'fighter'
                });
            }
        }
    }

    window.addEventListener('resize', resize);
    resize();

    window.addEventListener('mousemove', (e) => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
        defender.targetX = e.clientX;
    });

    window.addEventListener('touchmove', (e) => {
        if (e.touches.length > 0) {
            mouse.x = e.touches[0].clientX;
            mouse.y = e.touches[0].clientY;
            defender.targetX = e.touches[0].clientX;
        }
    }, { passive: true });

    window.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    function animate(timestamp) {
        ctx.clearRect(0, 0, width, height);

        // Smooth defender movement
        defender.x += (defender.targetX - defender.x) * 0.1;
        if (isNaN(defender.x)) defender.x = width / 2;

        // 1. Starfield & Mouse Interaction
        stars.forEach(star => {
            star.alpha += star.pulse;
            if (star.alpha > 0.9 || star.alpha < 0.2) star.pulse *= -1;

            if (mouse.x !== null) {
                let dx = mouse.x - star.x;
                let dy = mouse.y - star.y;
                let dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < mouse.radius) {
                    star.x -= (dx / dist) * 0.3;
                    star.y -= (dy / dist) * 0.3;
                }
            }

            ctx.beginPath();
            ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
            ctx.fillStyle = star.color;
            ctx.globalAlpha = star.alpha * 0.8;
            ctx.shadowColor = star.color;
            ctx.shadowBlur = 4;
            ctx.fill();
        });
        ctx.globalAlpha = 1.0;
        ctx.shadowBlur = 0;

        // 2. Realistic Pale Yellow Moon (#F4E99B) in top-right corner with thin vector craters
        ctx.save();
        let moonX = width - 110, moonY = 110, moonR = 42;
        let moonGrad = ctx.createRadialGradient(moonX - 12, moonY - 12, 6, moonX, moonY, moonR);
        moonGrad.addColorStop(0, '#FFFDD0');
        moonGrad.addColorStop(0.6, '#F4E99B');
        moonGrad.addColorStop(1, '#C2B475');
        ctx.fillStyle = moonGrad;
        ctx.shadowColor = '#F4E99B';
        ctx.shadowBlur = 12;
        ctx.beginPath();
        ctx.arc(moonX, moonY, moonR, 0, Math.PI * 2);
        ctx.fill();

        // Thin vector craters on Moon
        ctx.strokeStyle = 'rgba(80, 75, 45, 0.4)';
        ctx.lineWidth = 1;
        ctx.shadowBlur = 0;
        
        ctx.beginPath();
        ctx.arc(moonX - 12, moonY - 10, 8, 0, Math.PI * 2);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(moonX + 10, moonY + 12, 6, 0, Math.PI * 2);
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(moonX + 14, moonY - 14, 5, 0, Math.PI * 2);
        ctx.stroke();
        ctx.restore();

        // 3. Mothership cruising upper band
        mothership.x += mothership.speed;
        if (mothership.x > width + 150) mothership.x = -150;
        ctx.save();
        ctx.translate(mothership.x, mothership.y + Math.sin(timestamp * 0.002) * 4);
        ctx.strokeStyle = '#00FF66';
        ctx.lineWidth = 1.2;
        ctx.shadowColor = '#00FF66';
        ctx.shadowBlur = 8;
        ctx.beginPath();
        ctx.moveTo(-60, 0);
        ctx.lineTo(-30, -12);
        ctx.lineTo(30, -12);
        ctx.lineTo(60, 0);
        ctx.lineTo(30, 8);
        ctx.lineTo(-30, 8);
        ctx.closePath();
        ctx.stroke();
        ctx.fillStyle = 'rgba(0, 255, 102, 0.15)';
        ctx.fill();
        ctx.beginPath();
        ctx.arc(0, -6, 8, Math.PI, 0, false);
        ctx.stroke();
        ctx.fill();
        ctx.fillStyle = Math.floor(timestamp * 0.01) % 2 === 0 ? '#FF007F' : '#E6FF00';
        ctx.fillRect(-20, 8, 4, 3);
        ctx.fillRect(16, 8, 4, 3);
        ctx.restore();

        // 4. UFO & Invader Squadrons
        let time = timestamp * 0.0015;
        invaders.forEach((inv, i) => {
            let waveX = Math.sin(time + i * 0.5) * 35;
            let waveY = Math.cos(time * 0.8 + i) * 12;

            let targetX = inv.baseX + waveX;
            let targetY = inv.baseY + waveY;

            if (mouse.x !== null) {
                let dx = mouse.x - targetX;
                let dy = mouse.y - targetY;
                let dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    inv.offsetX -= (dx / dist) * 1.5;
                    inv.offsetY -= (dy / dist) * 1.5;
                }
            }
            inv.offsetX *= 0.95;
            inv.offsetY *= 0.95;

            let currentX = targetX + inv.offsetX;
            let currentY = targetY + inv.offsetY;

            ctx.save();
            ctx.strokeStyle = inv.color;
            ctx.fillStyle = inv.color;
            ctx.lineWidth = 1;
            ctx.shadowColor = inv.color;
            ctx.shadowBlur = 6;

            if (inv.type === 'ufo') {
                ctx.beginPath();
                ctx.ellipse(currentX, currentY, 18, 6, 0, 0, Math.PI * 2);
                ctx.stroke();
                ctx.beginPath();
                ctx.arc(currentX, currentY - 4, 7, Math.PI, 0, false);
                ctx.stroke();
            } else {
                ctx.beginPath();
                ctx.moveTo(currentX, currentY - 10);
                ctx.lineTo(currentX - 12, currentY + 8);
                ctx.lineTo(currentX, currentY + 4);
                ctx.lineTo(currentX + 12, currentY + 8);
                ctx.closePath();
                ctx.stroke();
            }
            ctx.restore();

            if (Math.random() < 0.0012 && lasers.length < 15) {
                lasers.push({
                    x: currentX,
                    y: currentY + 10,
                    vx: 0,
                    vy: 3.5,
                    color: '#FF007F',
                    isEnemy: true
                });
            }
        });

        // 5. Defender Ship & Player Lasers
        ctx.save();
        ctx.translate(defender.x, defender.y);
        ctx.strokeStyle = '#00FF66';
        ctx.fillStyle = 'rgba(0, 255, 102, 0.2)';
        ctx.lineWidth = 1.2;
        ctx.shadowColor = '#00FF66';
        ctx.shadowBlur = 8;
        ctx.beginPath();
        ctx.moveTo(0, -16);
        ctx.lineTo(-14, 10);
        ctx.lineTo(-6, 6);
        ctx.lineTo(0, 12);
        ctx.lineTo(6, 6);
        ctx.lineTo(14, 10);
        ctx.closePath();
        ctx.stroke();
        ctx.fill();
        ctx.restore();

        if (timestamp - lastLaserTime > 800 && lasers.length < 15) {
            lasers.push({
                x: defender.x,
                y: defender.y - 18,
                vx: 0,
                vy: -6,
                color: '#00FF66',
                isEnemy: false
            });
            lastLaserTime = timestamp;

            for (let s = 0; s < 3; s++) {
                sparks.push({
                    x: defender.x + (Math.random() * 10 - 5),
                    y: defender.y - 18,
                    vx: Math.random() * 2 - 1,
                    vy: Math.random() * -2 - 1,
                    life: 20,
                    color: '#E6FF00'
                });
            }
        }

        // 6. Update & Render Lasers
        for (let i = lasers.length - 1; i >= 0; i--) {
            let l = lasers[i];
            l.x += l.vx;
            l.y += l.vy;

            ctx.save();
            ctx.strokeStyle = l.color;
            ctx.lineWidth = 1.5;
            ctx.shadowColor = l.color;
            ctx.shadowBlur = 6;
            ctx.beginPath();
            ctx.moveTo(l.x, l.y);
            ctx.lineTo(l.x, l.y + (l.isEnemy ? 12 : -12));
            ctx.stroke();
            ctx.restore();

            if (l.y < 0 || l.y > height) {
                lasers.splice(i, 1);
            }
        }

        // 7. Update & Render Sparks
        for (let i = sparks.length - 1; i >= 0; i--) {
            let sp = sparks[i];
            sp.x += sp.vx;
            sp.y += sp.vy;
            sp.life--;

            ctx.save();
            ctx.fillStyle = sp.color;
            ctx.globalAlpha = sp.life / 20;
            ctx.shadowColor = sp.color;
            ctx.shadowBlur = 4;
            ctx.fillRect(sp.x, sp.y, 2, 2);
            ctx.restore();

            if (sp.life <= 0) {
                sparks.splice(i, 1);
            }
        }

        requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);
});
