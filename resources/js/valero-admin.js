import tinymceConfig from './tinymce-config';

// Make calendarData function globally available for Alpine.js
window.calendarData = function() {
    return {
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        calendarDays: [],
        scheduledArticles: [], // This will be populated from the blade component
        isLoading: false,
        goToPreviousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
            this.fetchCalendarData();
        },
        goToNextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
            this.fetchCalendarData();
        },
        goToToday() {
            const today = new Date();
            this.currentMonth = today.getMonth();
            this.currentYear = today.getFullYear();
            this.fetchCalendarData();
        },
        fetchCalendarData() {
            this.isLoading = true;
            
            // In a real implementation, you would fetch data from the server
            // For now, we'll simulate the fetch with a timeout
            setTimeout(() => {
                this.generateCalendarDays();
                this.isLoading = false;
            }, 300);
        },
        generateCalendarDays() {
            const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1);
            const lastDayOfMonth = new Date(this.currentYear, this.currentMonth + 1, 0);
            
            // Get the day of the week for the first day (0 = Sunday, 6 = Saturday)
            const firstDayIndex = firstDayOfMonth.getDay();
            
            // Calculate days from previous month to show
            const daysFromPrevMonth = firstDayIndex;
            
            // Calculate total days to show (previous month days + current month days + next month days)
            const totalDays = 42; // 6 rows of 7 days
            
            // Create array to hold all calendar days
            this.calendarDays = [];
            
            // Add days from previous month
            const prevMonth = new Date(this.currentYear, this.currentMonth, 0);
            const prevMonthDays = prevMonth.getDate();
            
            for (let i = daysFromPrevMonth - 1; i >= 0; i--) {
                const day = prevMonthDays - i;
                const date = new Date(this.currentYear, this.currentMonth - 1, day);
                const dateString = this.formatDateString(date);
                
                this.calendarDays.push({
                    day: day,
                    date: date,
                    dateString: dateString,
                    isCurrentMonth: false,
                    isToday: this.isToday(date),
                    scheduledArticles: this.getScheduledArticlesForDate(dateString)
                });
            }
            
            // Add days from current month
            for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
                const date = new Date(this.currentYear, this.currentMonth, day);
                const dateString = this.formatDateString(date);
                
                this.calendarDays.push({
                    day: day,
                    date: date,
                    dateString: dateString,
                    isCurrentMonth: true,
                    isToday: this.isToday(date),
                    scheduledArticles: this.getScheduledArticlesForDate(dateString)
                });
            }
            
            // Add days from next month
            const remainingDays = totalDays - this.calendarDays.length;
            for (let day = 1; day <= remainingDays; day++) {
                const date = new Date(this.currentYear, this.currentMonth + 1, day);
                const dateString = this.formatDateString(date);
                
                this.calendarDays.push({
                    day: day,
                    date: date,
                    dateString: dateString,
                    isCurrentMonth: false,
                    isToday: this.isToday(date),
                    scheduledArticles: this.getScheduledArticlesForDate(dateString)
                });
            }
        },
        formatDateString(date) {
            return date.getFullYear() + '-' + 
                   String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                   String(date.getDate()).padStart(2, '0');
        },
        isToday(date) {
            const today = new Date();
            return date.getDate() === today.getDate() && 
                   date.getMonth() === today.getMonth() && 
                   date.getFullYear() === today.getFullYear();
        },
        getScheduledArticlesForDate(dateString) {
            return this.scheduledArticles.filter(article => {
                const articleDate = new Date(article.scheduled_at);
                return this.formatDateString(articleDate) === dateString;
            });
        },
        init() {
            this.generateCalendarDays();
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {
  const themeToggleBtn = document.getElementById('theme-toggle-admin');
  const darkIcon = document.getElementById('theme-toggle-dark-icon-admin');
  const lightIcon = document.getElementById('theme-toggle-light-icon-admin');

  if (themeToggleBtn && darkIcon && lightIcon) {
    function applyTheme() {
      if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
        '(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
      } else {
        document.documentElement.classList.remove('dark');
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
      }
    }

    applyTheme();

    themeToggleBtn.addEventListener('click', function () {
      darkIcon.classList.toggle('hidden');
      lightIcon.classList.toggle('hidden');

      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
      }
    });
  }

  if (document.querySelector('#content')) {
    tinymce.init(tinymceConfig);
  }

  ['title', 'excerpt'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', () => updateCharCount(id, id === 'title' ? 60 : 160));
      updateCharCount(id, id === 'title' ? 60 : 160);
    }
  });

  ['tags'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
        element.addEventListener('input', () => updateTagCount(id, 10, 100));
        updateTagCount(id, 10, 100);
    }
});

  const settingsForm = document.getElementById('settings-form');
  if (settingsForm) {
    settingsForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(settingsForm);

      fetch(settingsForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.refresh) {
            window.location.reload(true);
          }
        });
    });
  }
});

function updateCharCount(elementId, limit = null) {
  let content;
  if (elementId === 'content' && typeof tinymce !== 'undefined') {
    content = tinymce.get('content').getContent({
      format: 'text'
    });
  } else {
    const element = document.getElementById(elementId);
    if (!element) return;
    content = element.value;
  }
  const charCount = document.getElementById(elementId + '-char-count');
  if (!charCount) return;

  charCount.textContent = content.length;

  if (limit && content.length > limit) {
    charCount.classList.add('text-red-500');
  } else {
    charCount.classList.remove('text-red-500');
  }
}

function updateTagCount(id, maxTags, maxChars) {
    const element = document.getElementById(id);
    const counter = document.getElementById(`${id}-counter`);
    
    if (element && counter) {
        const value = element.value;
        const totalChars = value.length;
        const tags = value
            .split(',')
            .map(tag => tag.trim())
            .filter(tag => tag.length > 0);
            
        const count = tags.length;
        
        // Update counter text with both limits
        counter.textContent = `${count}/${maxTags} tags (${totalChars}/${maxChars} chars)`;
        
        // Visual feedback for exceeding either limit
        if (count > maxTags || totalChars > maxChars) {
            counter.classList.add('text-red-500');
            counter.classList.remove('text-gray-500');
        } else {
            counter.classList.remove('text-red-500');
            counter.classList.add('text-gray-500');
        }
        
        // Optional: Truncate if exceeding character limit
        if (totalChars > maxChars) {
            element.value = value.substring(0, maxChars);
        }
    }
}
