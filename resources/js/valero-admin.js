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

// Global toast notification function with different types
window.showToast = function(message, type = 'error') {
    // Define toast styles based on type
    const styles = {
        success: {
            bg: 'bg-green-50 dark:bg-green-900/50',
            border: 'border-green-400/50 dark:border-green-500/50',
            textTitle: 'text-green-800 dark:text-green-200',
            textBody: 'text-green-700 dark:text-green-300',
            iconColor: 'text-green-400 dark:text-green-300',
            progress: 'bg-green-100 dark:bg-green-800',
            icon: `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                   </svg>`,
            title: 'Success'
        },
        error: {
            bg: 'bg-red-50 dark:bg-red-900/50',
            border: 'border-red-400/50 dark:border-red-500/50',
            textTitle: 'text-red-800 dark:text-red-200',
            textBody: 'text-red-700 dark:text-red-300',
            iconColor: 'text-red-400 dark:text-red-300',
            progress: 'bg-red-100 dark:bg-red-800',
            icon: `<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                   </svg>`,
            title: 'Error'
        },
        warning: {
            bg: 'bg-yellow-50 dark:bg-yellow-900/50',
            border: 'border-yellow-400/50 dark:border-yellow-500/50',
            textTitle: 'text-yellow-800 dark:text-yellow-200',
            textBody: 'text-yellow-700 dark:text-yellow-300',
            iconColor: 'text-yellow-400 dark:text-yellow-300',
            progress: 'bg-yellow-100 dark:bg-yellow-800',
            icon: `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                   </svg>`,
            title: 'Warning'
        },
        info: {
            bg: 'bg-blue-50 dark:bg-blue-900/50',
            border: 'border-blue-400/50 dark:border-blue-500/50',
            textTitle: 'text-blue-800 dark:text-blue-200',
            textBody: 'text-blue-700 dark:text-blue-300',
            iconColor: 'text-blue-400 dark:text-blue-300',
            progress: 'bg-blue-100 dark:bg-blue-800',
            icon: `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                   </svg>`,
            title: 'Info'
        }
    };

    const style = styles[type] || styles.error;
    
    // Remove any existing toast
    const existingToast = document.getElementById('global-toast');
    if (existingToast) {
        existingToast.remove();
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.id = 'global-toast';
    toast.className = 'fixed bottom-24 right-5 w-full max-w-sm z-50';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';
    
    toast.innerHTML = `<div class="relative overflow-hidden rounded-lg border ${style.border} ${style.bg} shadow-lg">
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <div class="${style.iconColor}">
                ${style.icon}
              </div>
            </div>
            <div class="ml-3 flex-1">
              <p class="text-sm font-medium ${style.textTitle}">${style.title}</p>
              <p class="mt-1 text-sm ${style.textBody}">${message}</p>
            </div>
            <div class="ml-4 flex-shrink-0">
              <button type="button" onclick="document.getElementById('global-toast').remove()" class="inline-flex rounded-md p-1.5 ${style.textBody.replace('text-', 'hover:bg-').replace('-700', '-100').replace('-300', '-900')}">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="absolute bottom-0 left-0 h-1 ${style.progress}" style="width: 100%; animation: toastProgress 5000ms linear forwards;"></div>
      </div>`;
    
    // Add animation
    const styleEl = document.createElement('style');
    styleEl.textContent = '@keyframes toastProgress { from { width: 100%; } to { width: 0%; } }';
    if (!document.getElementById('toast-animation-style')) {
        styleEl.id = 'toast-animation-style';
        document.head.appendChild(styleEl);
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

// Global validation toast function (backward compatibility)
window.showValidationToast = function(message) {
    showToast(message, 'error');
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

// Gallery Create Component
window.galleryCreate = function(maxFiles, maxFileSizeMB) {
    return {
        files: [],
        maxFiles: maxFiles,
        handleFiles(event) {
            const selectedFiles = Array.from(event.target.files);
            if (selectedFiles.length > this.maxFiles) {
                alert(`You can only upload up to ${this.maxFiles} images at once.`);
                event.target.value = '';
                return;
            }

            // Check file sizes and dimensions - allow up to 5120 in either dimension
            const maxFileSize = maxFileSizeMB * 1024 * 1024;
            const maxWidth = 5120;
            const maxHeight = 5120;
            
            for (const file of selectedFiles) {
                if (file.size > maxFileSize) {
                    alert(`File "${file.name}" is too large. Maximum file size is ${maxFileSizeMB}MB.`);
                    event.target.value = '';
                    return;
                }

                // Create a promise to check image dimensions
                const checkDimensions = new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => {
                        if (img.width > maxWidth || img.height > maxHeight) {
                            reject(`File "${file.name}" dimensions (${img.width}x${img.height}) exceed the maximum allowed size of ${maxWidth}x${maxHeight} pixels (max 5120 in either dimension).`);
                        } else {
                            resolve();
                        }
                    };
                    img.onerror = () => reject(`Failed to load image "${file.name}" for dimension check.`);
                    img.src = URL.createObjectURL(file);
                });

                // Wait for dimension check
                checkDimensions.catch(error => {
                    alert(error);
                    event.target.value = '';
                    return;
                });
            }
            
            this.files = selectedFiles.map(file => {
                const fileObj = {
                    file: file, // Store the actual File object
                    name: file.name,
                    size: file.size,
                    sizeMB: (file.size / (1024 * 1024)).toFixed(2),
                    sizeFormatted: '',
                    dimensionsText: 'Loading dimensions...',
                    width: null,
                    height: null,
                    previewUrl: URL.createObjectURL(file)
                };
                
                // Format file size
                if (fileObj.sizeMB < 1) {
                    fileObj.sizeFormatted = (file.size / 1024).toFixed(1) + ' KB';
                } else {
                    fileObj.sizeFormatted = fileObj.sizeMB + ' MB';
                }
                
                // Load dimensions asynchronously with proper Alpine reactivity
                const img = new Image();
                img.onload = () => {
                    // Use Alpine's reactivity to update the UI
                    const fileIndex = this.files.findIndex(f => f.name === file.name);
                    if (fileIndex !== -1) {
                        this.files[fileIndex].dimensionsText = `${img.width}x${img.height} pixels`;
                        this.files[fileIndex].width = img.width;
                        this.files[fileIndex].height = img.height;
                    }
                };
                img.onerror = () => {
                    const fileIndex = this.files.findIndex(f => f.name === file.name);
                    if (fileIndex !== -1) {
                        this.files[fileIndex].dimensionsText = 'Unable to load dimensions';
                    }
                };
                img.src = fileObj.previewUrl;
                
                return fileObj;
            });
        },
        removeFile(index) {
            // Revoke the object URL to free memory
            if (this.files[index]?.previewUrl) {
                URL.revokeObjectURL(this.files[index].previewUrl);
            }
            
            // Remove from array
            this.files.splice(index, 1);
            
            // Update the file input to match
            if (this.files.length === 0) {
                this.$refs.fileInput.value = '';
            }
        },
        
        clearAllFiles() {
            // Revoke all object URLs to free memory
            this.files.forEach(fileObj => {
                if (fileObj.previewUrl) {
                    URL.revokeObjectURL(fileObj.previewUrl);
                }
            });
            
            // Clear the array and file input
            this.files = [];
            this.$refs.fileInput.value = '';
        },
        
        // Cleanup on component destroy
        destroy() {
            this.files.forEach(file => {
                if (file.previewUrl) {
                    URL.revokeObjectURL(file.previewUrl);
                }
            });
        },
        
        // Initialize event listener for media library selection
        init() {
            window.addEventListener('media-selected-from-library', (event) => {
                const selectedMedia = event.detail.media;
                
                // Convert library media to file-like objects for display
                selectedMedia.forEach(media => {
                    this.files.push({
                        file: null, // No actual file object for library media
                        name: media.filename,
                        size: 0, // Size is not needed for display
                        sizeMB: media.size || 'N/A',
                        sizeFormatted: media.size || 'N/A',
                        dimensionsText: media.dimensions ? `${media.dimensions.width}x${media.dimensions.height} pixels` : 'Unknown',
                        width: media.dimensions?.width || null,
                        height: media.dimensions?.height || null,
                        previewUrl: media.url, // Use the library image URL
                        isFromLibrary: true, // Flag to identify library images
                        libraryMediaId: media.id // Store the media ID for backend
                    });
                });
                
                // Create hidden inputs for library media IDs
                const container = this.$refs.fileInput.parentElement;
                selectedMedia.forEach(media => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'library_media_ids[]';
                    input.value = media.id;
                    input.className = 'library-media-input';
                    container.appendChild(input);
                });
            });
        }
    };
};

// Gallery Edit Component
window.galleryEdit = function(maxFiles, maxFileSizeMB, articleMediaCount, articleTitle) {
    return {
        uploading: false,
        files: [],
        maxFiles: maxFiles - articleMediaCount,
        article_title: articleTitle,
        showDeleteModal: false,
        deleteTarget: null,

        getRoutes() {
            const form = document.querySelector('form[data-set-cover-route]');
            return {
                setCoverRoute: form.dataset.setCoverRoute,
                deleteRoute: form.dataset.deleteRoute
            };
        },

        handleFiles(event) {
            const selectedFiles = Array.from(event.target.files);
            const remainingSlots = this.maxFiles;
            
            if (selectedFiles.length > remainingSlots) {
                alert(`You can only upload ${remainingSlots} more images. (Maximum total: ${maxFiles})`);
                event.target.value = '';
                return;
            }

            // Check file sizes and dimensions - allow up to 5120 in either dimension
            const maxFileSize = maxFileSizeMB * 1024 * 1024;
            const maxWidth = 5120;
            const maxHeight = 5120;
            
            for (const file of selectedFiles) {
                if (file.size > maxFileSize) {
                    alert(`File "${file.name}" is too large. Maximum file size is ${maxFileSizeMB}MB.`);
                    event.target.value = '';
                    return;
                }

                // Create a promise to check image dimensions
                const checkDimensions = new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => {
                        if (img.width > maxWidth || img.height > maxHeight) {
                            reject(`File "${file.name}" dimensions (${img.width}x${img.height}) exceed the maximum allowed size of ${maxWidth}x${maxHeight} pixels (max 5120 in either dimension).`);
                        } else {
                            resolve();
                        }
                    };
                    img.onerror = () => reject(`Failed to load image "${file.name}" for dimension check.`);
                    img.src = URL.createObjectURL(file);
                });

                // Wait for dimension check
                checkDimensions.catch(error => {
                    alert(error);
                    event.target.value = '';
                    return;
                });
            }
            
            this.files = selectedFiles.map(file => {
                const fileObj = {
                    file: file, // Store the actual File object
                    name: file.name,
                    size: file.size,
                    sizeMB: (file.size / (1024 * 1024)).toFixed(2),
                    sizeFormatted: '',
                    dimensionsText: 'Loading dimensions...',
                    width: null,
                    height: null,
                    previewUrl: URL.createObjectURL(file)
                };
                
                // Format file size
                if (fileObj.sizeMB < 1) {
                    fileObj.sizeFormatted = (file.size / 1024).toFixed(1) + ' KB';
                } else {
                    fileObj.sizeFormatted = fileObj.sizeMB + ' MB';
                }
                
                // Load dimensions asynchronously with proper Alpine reactivity
                const img = new Image();
                img.onload = () => {
                    // Use Alpine's reactivity to update the UI
                    const fileIndex = this.files.findIndex(f => f.name === file.name);
                    if (fileIndex !== -1) {
                        this.files[fileIndex].dimensionsText = `${img.width}x${img.height} pixels`;
                        this.files[fileIndex].width = img.width;
                        this.files[fileIndex].height = img.height;
                    }
                };
                img.onerror = () => {
                    const fileIndex = this.files.findIndex(f => f.name === file.name);
                    if (fileIndex !== -1) {
                        this.files[fileIndex].dimensionsText = 'Unable to load dimensions';
                    }
                };
                img.src = fileObj.previewUrl;
                
                return fileObj;
            });
        },

        removeFile(index) {
            // Revoke the object URL to free memory
            if (this.files[index]?.previewUrl) {
                URL.revokeObjectURL(this.files[index].previewUrl);
            }
            
            // Remove from array
            this.files.splice(index, 1);
            
            // Update the file input to match
            if (this.files.length === 0) {
                this.$refs.fileInput.value = '';
            }
        },
        
        clearAllFiles() {
            // Revoke all object URLs to free memory
            this.files.forEach(fileObj => {
                if (fileObj.previewUrl) {
                    URL.revokeObjectURL(fileObj.previewUrl);
                }
            });
            
            // Clear the array and file input
            this.files = [];
            this.$refs.fileInput.value = '';
        },
        
        // Cleanup on component destroy
        destroy() {
            this.files.forEach(file => {
                if (file.previewUrl) {
                    URL.revokeObjectURL(file.previewUrl);
                }
            });
        },

        uploadImages(event) {
            if (this.files.length === 0) return;
            
            this.uploading = true;
            
            // Build FormData manually from only the files that remain in this.files array
            const formData = new FormData();
            
            // Add CSRF token from the form
            const csrfToken = event.target.querySelector('input[name="_token"]').value;
            formData.append('_token', csrfToken);
            
            // Add only the files that are still in the this.files array
            this.files.forEach(fileObj => {
                formData.append('gallery_images[]', fileObj.file);
            });
            
            const routes = this.getRoutes();
            
            fetch(event.target.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success toast
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Images uploaded successfully', 'success');
                    }

                    // Reload the page to show new images
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                if (typeof showToast === 'function') {
                    showToast(error.message || 'An unexpected error occurred', 'error');
                }
            })
            .finally(() => {
                this.uploading = false;
            });
        },

        deleteImage(event) {
            // Store the delete target and show modal
            this.deleteTarget = {
                form: event.target,
                token: event.target.querySelector('input[name="_token"]').value,
                imageContainer: event.target.closest('.relative.group')
            };
            this.showDeleteModal = true;
        },

        confirmDelete() {
            // Close modal
            this.showDeleteModal = false;
            
            if (!this.deleteTarget) return;

            const { form, token, imageContainer } = this.deleteTarget;

            fetch(form.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to delete image');
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    // Remove the image container from DOM with animation
                    imageContainer.style.transition = 'all 0.3s ease-out';
                    imageContainer.style.transform = 'scale(0.8)';
                    imageContainer.style.opacity = '0';
                    
                    setTimeout(() => imageContainer.remove(), 300);
                    
                    // Update the image count text using the ID
                    const countElement = document.getElementById('gallery-count');
                    if (countElement) {
                        countElement.textContent = `${data.remainingImages} of ${maxFiles} images used`;
                    }
                    
                    // Show success toast
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Image deleted successfully', 'success');
                    }
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                if (typeof showToast === 'function') {
                    showToast(error.message || 'An error occurred while deleting the image', 'error');
                }
            });
        }
    };
};

// Media Library Modal Component
window.mediaLibrary = function(articleId) {
    return {
        open: false,
        loading: false,
        attaching: false,
        searchQuery: '',
        mediaItems: [],
        selectedMedia: [],
        currentPage: 1,
        lastPage: 1,
        articleId: articleId,

        get hasMorePages() {
            return this.currentPage < this.lastPage;
        },

        openLibrary() {
            this.open = true;
            this.fetchMedia();
            document.body.style.overflow = 'hidden';
        },

        closeLibrary() {
            this.open = false;
            this.selectedMedia = [];
            this.searchQuery = '';
            this.currentPage = 1;
            document.body.style.overflow = '';
        },

        async fetchMedia(page = 1) {
            this.loading = true;
            this.currentPage = page;

            try {
                const params = new URLSearchParams({
                    page: page,
                    search: this.searchQuery
                });
                
                if (this.articleId) {
                    params.append('exclude_article_id', this.articleId);
                }

                const response = await fetch(`/admin/media/library?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to fetch media');

                const data = await response.json();
                
                if (page === 1) {
                    this.mediaItems = data.data;
                } else {
                    this.mediaItems = [...this.mediaItems, ...data.data];
                }
                
                this.lastPage = data.last_page;
                
            } catch (error) {
                console.error('Error fetching media:', error);
                showToast('Failed to load media library', 'error');
            } finally {
                this.loading = false;
            }
        },

        loadMore() {
            if (this.hasMorePages && !this.loading) {
                this.fetchMedia(this.currentPage + 1);
            }
        },

        toggleSelection(media) {
            const index = this.selectedMedia.findIndex(m => m.id === media.id);
            if (index > -1) {
                this.selectedMedia.splice(index, 1);
            } else {
                this.selectedMedia.push(media);
            }
        },

        isSelected(mediaId) {
            return this.selectedMedia.some(m => m.id === mediaId);
        },

        clearSelection() {
            this.selectedMedia = [];
        },

        async attachSelectedMedia() {
            if (this.selectedMedia.length === 0 || this.attaching) return;

            this.attaching = true;

            try {
                const mediaIds = this.selectedMedia.map(m => m.id);
                const url = this.articleId 
                    ? `/admin/articles/${this.articleId}/images/attach-from-library`
                    : null;

                if (!url) {
                    // For create form, emit event with selected media
                    window.dispatchEvent(new CustomEvent('media-selected-from-library', {
                        detail: { media: this.selectedMedia }
                    }));
                    showToast(`${this.selectedMedia.length} images selected`, 'success');
                    this.closeLibrary();
                    return;
                }

                // For edit form, attach via AJAX
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ media_ids: mediaIds })
                });

                const data = await response.json();

                if (data.success) {
                    showToast(data.message, 'success');
                    this.closeLibrary();
                    
                    // Reload the page to show the newly attached images
                    window.location.reload();
                } else {
                    showToast(data.message || 'Failed to attach images', 'error');
                }

            } catch (error) {
                console.error('Error attaching media:', error);
                showToast('Failed to attach images', 'error');
            } finally {
                this.attaching = false;
            }
        }
    };
};

// Auth Form Component (for password visibility toggles)
window.authForm = function() {
    return {
        showPassword: false,
        showPasswordConfirmation: false
    };
};

// Auth Form Component (for password visibility toggles)
window.authForm = function() {
    return {
        showPassword: false,
        showPasswordConfirmation: false
    };
};
