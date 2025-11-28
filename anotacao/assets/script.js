// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Color picker preview
    initializeColorPicker();
    
    // Auto-save functionality for forms
    initializeAutoSave();
    
    // Search enhancements
    initializeSearch();
}

function initializeColorPicker() {
    const colorInput = document.getElementById('color');
    const colorPreview = document.querySelector('.color-preview');
    
    if (colorInput && colorPreview) {
        colorPreview.style.backgroundColor = colorInput.value;
        
        colorInput.addEventListener('input', function() {
            colorPreview.style.backgroundColor = this.value;
        });
    }
}

function initializeAutoSave() {
    const noteForm = document.querySelector('.note-form');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    
    if (noteForm && titleInput && contentInput) {
        let autoSaveTimer;
        
        function autoSave() {
            const formData = {
                title: titleInput.value,
                content: contentInput.value,
                timestamp: new Date().getTime()
            };
            
            localStorage.setItem('autoSaveNote', JSON.stringify(formData));
            showAutoSaveIndicator();
        }
        
        [titleInput, contentInput].forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(autoSave, 1000);
            });
        });
        
        // Check for auto-saved content on page load
        checkAutoSavedContent();
    }
}

function showAutoSaveIndicator() {
    let indicator = document.getElementById('autoSaveIndicator');
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.id = 'autoSaveIndicator';
        indicator.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            z-index: 1000;
        `;
        document.body.appendChild(indicator);
    }
    
    indicator.textContent = 'Auto-saved';
    indicator.style.display = 'block';
    
    setTimeout(() => {
        indicator.style.display = 'none';
    }, 2000);
}

function checkAutoSavedContent() {
    const saved = localStorage.getItem('autoSaveNote');
    if (saved) {
        const formData = JSON.parse(saved);
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        
        if (titleInput && !titleInput.value) {
            titleInput.value = formData.title;
        }
        if (contentInput && !contentInput.value) {
            contentInput.value = formData.content;
        }
        
        // Clear auto-saved data when form is submitted
        const form = document.querySelector('.note-form');
        if (form) {
            form.addEventListener('submit', function() {
                localStorage.removeItem('autoSaveNote');
            });
        }
    }
}

function initializeSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimer;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }
}

// Utility function to format dates
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}