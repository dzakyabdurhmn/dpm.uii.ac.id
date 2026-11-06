import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
const mediaUploadUrl = document.body.dataset.mediaUploadUrl ?? '/admin/media';

async function uploadFile(file) {
    const data = new FormData();
    data.append('file', file);

    const response = await fetch(mediaUploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            Accept: 'application/json',
        },
        body: data,
    });

    if (!response.ok) {
        const payload = await response.json().catch(() => ({}));
        throw new Error(payload.message ?? 'Gagal mengunggah berkas.');
    }

    return response.json();
}

function filePicker({ accept, onPick }) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = accept;
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (file) {
            onPick(file);
        }
    });
    input.click();
}

/* ---------------------------------------------------------------- Editors */

const editorToolbar = [
    [{ header: [2, 3, false] }],
    ['bold', 'italic', 'underline'],
    [{ list: 'ordered' }, { list: 'bullet' }],
    ['blockquote', 'link', 'image'],
    ['clean'],
];

document.querySelectorAll('textarea[data-rich-editor]').forEach((textarea) => {
    const holder = document.createElement('div');
    holder.className = 'bg-white';
    textarea.insertAdjacentElement('afterend', holder);
    textarea.classList.add('hidden');

    const quill = new Quill(holder, {
        theme: 'snow',
        placeholder: textarea.getAttribute('placeholder') ?? '',
        modules: {
            toolbar: {
                container: editorToolbar,
                handlers: {
                    image() {
                        const range = quill.getSelection(true);
                        filePicker({
                            accept: 'image/*',
                            onPick: async (file) => {
                                try {
                                    const media = await uploadFile(file);
                                    quill.insertEmbed(range.index, 'image', media.url, 'user');
                                    quill.setSelection(range.index + 1);
                                } catch (error) {
                                    window.alert(error.message);
                                }
                            },
                        });
                    },
                },
            },
        },
    });

    if (textarea.value) {
        quill.clipboard.dangerouslyPasteHTML(textarea.value);
    }

    const sync = () => {
        const html = quill.root.innerHTML.trim();
        textarea.value = html === '<p><br></p>' ? '' : html;
    };

    quill.on('text-change', sync);
    textarea.form?.addEventListener('submit', sync);
});

/* ---------------------------------------------------------- Media picker */

document.querySelectorAll('[data-media-picker]').forEach((picker) => {
    const input = picker.querySelector('[data-media-input]');
    const preview = picker.querySelector('[data-media-preview]');
    const placeholder = picker.querySelector('[data-media-placeholder]');
    const clearButton = picker.querySelector('[data-media-clear]');
    const button = picker.querySelector('[data-media-button]');

    const render = (url) => {
        input.value = url ?? '';

        if (url) {
            preview.src = url;
            preview.classList.remove('hidden');
            placeholder?.classList.add('hidden');
            clearButton?.classList.remove('hidden');
        } else {
            preview.removeAttribute('src');
            preview.classList.add('hidden');
            placeholder?.classList.remove('hidden');
            clearButton?.classList.add('hidden');
        }
    };

    button?.addEventListener('click', () => {
        filePicker({
            accept: 'image/*',
            onPick: async (file) => {
                button.disabled = true;
                const label = button.textContent;
                button.textContent = 'Mengunggah…';

                try {
                    const media = await uploadFile(file);
                    render(media.url);
                } catch (error) {
                    window.alert(error.message);
                } finally {
                    button.disabled = false;
                    button.textContent = label;
                }
            },
        });
    });

    clearButton?.addEventListener('click', () => render(''));

    render(input.value);
});

/* ------------------------------------------------- Sosialisasi type toggle */

document.querySelectorAll('[data-socialization-type]').forEach((wrapper) => {
    const categorySelect = document.querySelector('[data-post-category-select]');
    const categoryId = wrapper.dataset.categoryId;

    if (!categorySelect || !categoryId) {
        return;
    }

    const sync = () => {
        wrapper.classList.toggle('hidden', categorySelect.value !== categoryId);
    };

    categorySelect.addEventListener('change', sync);
    sync();
});

/* --------------------------------------------------------- Misc helpers */

document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-copy]').forEach((button) => {
    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(button.dataset.copy);
            const label = button.textContent;
            button.textContent = 'Tersalin!';
            window.setTimeout(() => {
                button.textContent = label;
            }, 1500);
        } catch {
            window.prompt('Salin URL berikut:', button.dataset.copy);
        }
    });
});
