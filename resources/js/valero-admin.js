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

// Global validation toast function
window.showValidationToast = function(message) {
    // Remove any existing notification component toasts to avoid duplicates
    const existingNotifications = document.querySelectorAll('.fixed.bottom-5.right-5');
    existingNotifications.forEach(notif => {
        if (!notif.id || notif.id !== 'validation-toast') {
            notif.style.opacity = '0';
            setTimeout(() => notif.remove(), 300);
        }
    });

    // Remove existing validation toast if any
    const existingToast = document.getElementById('validation-toast');
    if (existingToast) {
        existingToast.remove();
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.id = 'validation-toast';
    // Position higher than notification component to stack vertically
    toast.className = 'fixed bottom-24 right-5 w-full max-w-sm z-50';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';
    
    toast.innerHTML = '<div class="relative overflow-hidden rounded-lg border border-red-400/50 dark:border-red-500/50 bg-red-50 dark:bg-red-900/50 shadow-lg">' +
        '<div class="p-4">' +
          '<div class="flex items-start">' +
            '<div class="flex-shrink-0">' +
              '<div class="text-red-400 dark:text-red-300">' +
                '<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                  '<circle cx="12" cy="12" r="10"/>' +
                  '<line x1="15" y1="9" x2="9" y2="15"/>' +
                  '<line x1="9" y1="9" x2="15" y2="15"/>' +
                '</svg>' +
              '</div>' +
            '</div>' +
            '<div class="ml-3 flex-1">' +
              '<p class="text-sm font-medium text-red-800 dark:text-red-200">Error</p>' +
              '<p class="mt-1 text-sm text-red-700 dark:text-red-300">' + message + '</p>' +
            '</div>' +
            '<div class="ml-4 flex-shrink-0">' +
              '<button type="button" onclick="document.getElementById(\'validation-toast\').remove()" class="inline-flex rounded-md p-1.5 text-red-500 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900">' +
                '<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">' +
                  '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />' +
                '</svg>' +
              '</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="absolute bottom-0 left-0 h-1 bg-red-100 dark:bg-red-800" style="width: 100%; animation: toastProgress 5000ms linear forwards;"></div>' +
      '</div>';
    
    // Add animation
    const style = document.createElement('style');
    style.textContent = '@keyframes toastProgress { from { width: 100%; } to { width: 0%; } }';
    if (!document.getElementById('toast-animation-style')) {
        style.id = 'toast-animation-style';
        document.head.appendChild(style);
    }
    
    document.body.appendChild(toast);
    
    // Animate in
    requestAnimationFrame(() => {
        toast.style.transition = 'all 0.3s ease-in-out';
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
};

// Alpine.js data function for article form validation (create)
window.articleFormCreate = function() {
    return {
        submitting: false,
        activeTab: 'content',
        submitForm(e) {
            e.preventDefault();
            if (this.submitting) return;
            
            // Validate required fields
            const errors = [];
            const title = document.getElementById('title')?.value?.trim();
            let content = '';
            
            // Get content from TinyMCE if available
            if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                content = tinymce.get('content').getContent({ format: 'text' })?.trim() || '';
            } else {
                content = document.getElementById('content')?.value?.trim() || '';
            }
            
            const category = document.getElementById('category_id')?.value;
            
            if (!title) errors.push('Title');
            if (!content) errors.push('Content');
            if (!category) errors.push('Category');
            
            if (errors.length > 0) {
                if (typeof showValidationToast === 'function') {
                    showValidationToast('Please fill in the following required fields: ' + errors.join(', '));
                }
                
                // Focus first missing field
                if (!title) {
                    document.getElementById('title')?.focus();
                    document.getElementById('title')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else if (!content) {
                    this.activeTab = 'content';
                    setTimeout(() => {
                        if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                            tinymce.get('content').focus();
                        } else {
                            document.getElementById('content')?.focus();
                        }
                    }, 300);
                } else if (!category) {
                    this.activeTab = 'publish';
                    setTimeout(() => {
                        document.getElementById('category_id')?.focus();
                        document.getElementById('category_id')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                }
                return false;
            }
            
            this.submitting = true;
            e.target.submit();
        }
    };
};

// Alpine.js data function for article form validation (edit)
window.articleFormEdit = function() {
    return {
        submitting: false,
        validateAndSubmit(e) {
            if (this.submitting) return;
            
            const errors = [];
            const titleEl = document.getElementById('title');
            const title = titleEl ? titleEl.value.trim() : '';
            
            let content = '';
            if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                content = tinymce.get('content').getContent({ format: 'text' }).trim() || '';
            } else {
                const contentEl = document.getElementById('content');
                content = contentEl ? contentEl.value.trim() : '';
            }
            
            const categoryEl = document.getElementById('category_id');
            const category = categoryEl ? categoryEl.value : '';
            
            if (!title) errors.push('Title');
            if (!content) errors.push('Content');
            if (!category) errors.push('Category');
            
            if (errors.length > 0) {
                if (typeof showValidationToast === 'function') {
                    showValidationToast('Please fill in the following required fields: ' + errors.join(', '));
                }
                
                if (!title) {
                    const nav = document.querySelector('nav');
                    if (nav) {
                        const tabs = nav.querySelectorAll('button');
                        if (tabs[0]) tabs[0].click();
                    }
                    setTimeout(() => {
                        if (titleEl) {
                            titleEl.focus();
                            titleEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 100);
                } else if (!content) {
                    const nav = document.querySelector('nav');
                    if (nav) {
                        const tabs = nav.querySelectorAll('button');
                        if (tabs[0]) tabs[0].click();
                    }
                    setTimeout(() => {
                        if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                            tinymce.get('content').focus();
                        } else if (document.getElementById('content')) {
                            document.getElementById('content').focus();
                        }
                    }, 300);
                } else if (!category) {
                    const nav = document.querySelector('nav');
                    if (nav) {
                        const tabs = nav.querySelectorAll('button');
                        if (tabs[3]) tabs[3].click();
                    }
                    setTimeout(() => {
                        if (categoryEl) {
                            categoryEl.focus();
                            categoryEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 300);
                }
                return false;
            }
            
            this.submitting = true;
            e.target.submit();
        }
    };
};
