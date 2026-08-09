<style>
/* Skills Container */
.language-div-outer .skills-container {
    padding: 20px;
}


/* Pill Styles */
.language-div-outer .skill-pill-wrapper {
    display: inline-block;
    margin: 5px;
    animation: fadeIn 0.3s ease;
}


@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}


.language-div-outer .skill-pill {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 16px !important;
    border-radius: 20px !important;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    gap: 0px;
    cursor: pointer;
    position: relative;
}


.language-div-outer .skill-pill:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}


.language-div-outer .skill-pill .pill-text {
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}


.language-div-outer .skill-pill .delete-cross {
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 300;
    opacity: 0.6;
    transition: all 0.3s ease;
    line-height: 1;
    margin-left: 4px;
    color: white;
}


.language-div-outer .skill-pill .delete-cross:hover {
    opacity: 1;
    transform: scale(1.3) rotate(90deg);
    color: #ff4757;
}


/* Edit Mode - Inline */
.language-div-outer .skill-edit-form {
    display: none;
    align-items: center;
    background: white;
    border-radius: 50px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    padding: 2px;
}


.language-div-outer .skill-edit-form.active {
    display: inline-flex;
    animation: fadeIn 0.2s ease;
}


.language-div-outer .skill-edit-form input {
    border: none;
    padding: 8px 16px;
    outline: none;
    width: 150px;
    font-size: 0.95rem;
    background: transparent;
}


.language-div-outer .skill-edit-form input:focus {
    outline: none;
}


.language-div-outer .skill-edit-form .btn-edit-save {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}


.language-div-outer .skill-edit-form .btn-edit-save:hover {
    background: #218838;
}


.language-div-outer .skill-edit-form .btn-edit-cancel {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}


.language-div-outer .skill-edit-form .btn-edit-cancel:hover {
    background: #c82333;
}


/* Add Skill Form */
.language-div-outer .add-skill-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    max-width: 500px;
}


.language-div-outer .add-skill-form .input-group-custom {
    display: flex;
    flex: 1;
    background: white;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 2px solid transparent;
    transition: all 0.3s ease;
}


.language-div-outer .add-skill-form .input-group-custom:focus-within {
    border-color: #667eea;
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.3);
}


.language-div-outer .add-skill-form input {
    flex: 1;
    border: none;
    padding: 10px 20px;
    outline: none;
    font-size: 0.95rem;
}


.language-div-outer .add-skill-form input:focus {
    outline: none;
}


.language-div-outer .add-skill-form .btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 0 50px 50px 0;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    white-space: nowrap;
}


.language-div-outer .add-skill-form .btn-add:hover {
    opacity: 0.9;
    transform: scale(1.02);
}


.language-div-outer .add-skill-form .btn-add:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}


/* Empty State */
.language-div-outer .empty-skills {
    text-align: center;
    padding: 40px;
    color: #999;
}


.language-div-outer .empty-skills i {
    font-size: 3rem;
    margin-bottom: 10px;
    opacity: 0.3;
}


.language-div-outer .empty-skills p {
    margin: 0;
}
</style>
<div class="language-div-outer">
<div class="skills-container">
    <!-- Add Skill Form -->
    <form class="add-skill-form" onsubmit="addSkill(event, this)">
        @csrf

        <div class="input-group-custom">
            <input type="text" 
                   name="skill" 
                   placeholder="Add a new language..." 
                   required
                   autocomplete="off">
            <button type="submit" class="btn-add">
                <i class="fas fa-plus"></i> Add Skill
            </button>
        </div>
    </form>

    <!-- Skills Display -->
    <div class="skills-list" id="skillsList">
        <div class="d-flex flex-wrap" style="gap: 0px;">
            @forelse ($list as $index => $item)
                @php
                    $colorClass = 'color-' . (($index % 6) + 1);
                @endphp
                <div class="skill-pill-wrapper" id="skill-{{ $item->id }}">
                    <!-- View Mode - Click to Edit -->
                    <span class="skill-pill {{ $colorClass }} view-mode" 
                          id="view-{{ $item->id }}"
                          onclick="editSkill('{{ $item->id }}')">
                        <span class="pill-text">{{ $item->skill }}</span>
                        <span class="delete-cross" 
                              onclick="event.stopPropagation(); deleteSkill('{{ route('resume.language.delete', $item->id) }}', '{{ $item->id }}')">
                            ×
                        </span>
                    </span>

                    <!-- Edit Mode -->
                    <form class="skill-edit-form" id="edit-{{ $item->id }}" onsubmit="updateSkill(event, this, '{{ $item->id }}')">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="text" 
                               name="skill" 
                               value="{{ $item->skill }}" 
                               required
                               autofocus>
                        <button type="submit" class="btn-edit-save">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn-edit-cancel" onclick="cancelEdit('{{ $item->id }}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="empty-skills">
                    <i class="fas fa-tags"></i>
                    <p>No skills added yet. Add your first skill above!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
</div>
<script>
// Add Skill
function addSkill(event, form) {
    event.preventDefault();
    const formData = new FormData(form);
    const submitBtn = $(form).find('.btn-add');
    
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding...');
    
    $.ajax({
        url: "{{ route('resume.language.save') }}?resume_id={{ $resume_id }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            loadSkills()
        },
        error: function(xhr) {
        }
    });
}





// Cancel Edit

// Delete Skill
function deleteSkill(url, id) {
    event.stopPropagation();

    
    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $(`#skill-${id}`).fadeOut(300);
        },
        success: function(response) {
           loadSkills()
        },
        error: function(xhr) {
            $(`#skill-${id}`).fadeIn(300);
            alert('Error deleting skill');
        }
    });
}

// Toast Notification (Optional)
function showToast(type, message) {
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        alert(message);
    }
}

// Handle Enter and Escape keys in edit mode
$(document).on('keydown', '.skill-edit-form input', function(e) {
    if (e.key === 'Escape') {
        const id = $(this).closest('.skill-edit-form').attr('id').replace('edit-', '');
        cancelEdit(id);
    }
});


</script>