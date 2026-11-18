// NoteKeeper - Frontend helpers

document.addEventListener('DOMContentLoaded', function () {

    // Live search: filter note cards by title or content
    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var query = this.value.toLowerCase().trim();
            document.querySelectorAll('.note-item').forEach(function (card) {
                var text = card.textContent.toLowerCase();
                card.style.display = text.indexOf(query) !== -1 ? '' : 'none';
            });
            updateEmptyState();
        });
    }

    // Category filter buttons
    document.querySelectorAll('[data-filter]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var category = this.getAttribute('data-filter');
            document.querySelectorAll('[data-filter]').forEach(function (b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            document.querySelectorAll('.note-item').forEach(function (card) {
                var cardCategory = card.getAttribute('data-category');
                card.style.display = (category === 'All' || cardCategory === category) ? '' : 'none';
            });
            updateEmptyState();
        });
    });

    // Show or hide the empty state message
    function updateEmptyState() {
        var visible = document.querySelectorAll('.note-item:not([style*="none"])').length;
        var emptyState = document.getElementById('emptyState');
        if (emptyState) {
            emptyState.style.display = visible === 0 ? 'block' : 'none';
        }
    }

    // Color picker on the add and edit forms
    var colorInputs = document.querySelectorAll('.color-option');
    colorInputs.forEach(function (option) {
        option.addEventListener('click', function () {
            colorInputs.forEach(function (o) { o.classList.remove('selected'); });
            this.classList.add('selected');
            var colorField = document.getElementById('color');
            if (colorField) {
                colorField.value = this.getAttribute('data-color');
            }
        });
    });

    // Word counter on the content field
    var contentField = document.getElementById('content');
    var wordCount = document.getElementById('wordCount');
    if (contentField && wordCount) {
        var updateCount = function () {
            var words = contentField.value.trim().split(/\s+/).filter(Boolean).length;
            wordCount.textContent = words + ' words';
        };
        contentField.addEventListener('input', updateCount);
        updateCount();
    }

    // Confirm before deleting a note
    document.querySelectorAll('.delete-note').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Delete this note? This cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
});
