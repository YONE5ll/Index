// Import Alpine.js
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import './bootstrap';

// Register Alpine plugins
Alpine.plugin(persist);

// Make Alpine available globally
window.Alpine = Alpine;

// Initialize Alpine stores
document.addEventListener('alpine:init', () => {
    // Dark mode store
    Alpine.store('darkMode', {
        on: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.on = !this.on;
            localStorage.setItem('darkMode', this.on);
            document.documentElement.classList.toggle('dark', this.on);
        },
        init() {
            if (this.on) {
                document.documentElement.classList.add('dark');
            }
        }
    });
    
    // Notifications store
    Alpine.store('notifications', {
        count: 3,
        items: [
            { id: 1, title: 'Workout Complete!', message: 'You finished your HIIT session', time: '5 min ago', read: false },
            { id: 2, title: 'New Achievement', message: 'You earned "Early Bird" badge', time: '1 hour ago', read: false },
            { id: 3, title: 'Reminder', message: 'Don\'t forget to log your meals', time: '3 hours ago', read: false }
        ],
        markAsRead(id) {
            const item = this.items.find(i => i.id === id);
            if (item) item.read = true;
            this.count = this.items.filter(i => !i.read).length;
        },
        markAllRead() {
            this.items.forEach(i => i.read = true);
            this.count = 0;
        }
    });
});

// Start Alpine
Alpine.start();

// Smooth page transitions
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('fade-in');
});