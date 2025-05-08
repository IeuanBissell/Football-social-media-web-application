// dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    // Time-based greeting
    const welcomeHeading = document.querySelector('.welcome-section h1');
    if (welcomeHeading) {
        const currentHour = new Date().getHours();
        let greeting;

        if (currentHour < 12) {
            greeting = 'Good Morning';
        } else if (currentHour < 18) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }

        // Get the username from the content (format is "Welcome Back, Username!")
        const username = welcomeHeading.textContent.split(',')[1]?.trim().replace('!', '') || '';
        welcomeHeading.textContent = `${greeting}, ${username}!`;
    }

    // Card animations
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        // Add a slight delay to each card for a cascade effect
        setTimeout(() => {
            card.classList.add('card-animated');
        }, 100 * index);

        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.classList.add('card-hover');
        });

        card.addEventListener('mouseleave', function() {
            this.classList.remove('card-hover');
        });
    });

    // Live clock and date
    const welcomeSection = document.querySelector('.welcome-section');
    if (welcomeSection) {
        const clockDiv = document.createElement('div');
        clockDiv.className = 'dashboard-clock mt-2';

        function updateClock() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            clockDiv.textContent = now.toLocaleDateString('en-US', options);
        }

        updateClock();
        setInterval(updateClock, 1000);
        welcomeSection.appendChild(clockDiv);
    }
});
