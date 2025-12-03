@extends('templates.app')

@push('style')
<style>
    .quiz-question-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 80px 0 40px;
    }

    .question-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(46, 125, 50, 0.1);
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }

    .question-header {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quiz-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .question-progress {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .question-body {
        padding: 2rem;
    }

    /* Question Styling */
    .question-number {
        color: #2E7D32;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .question-text {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2c3e50;
        line-height: 1.6;
        margin-bottom: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #2E7D32;
    }

    /* Options Styling */
    .options-container {
        margin-bottom: 2rem;
    }

    .option-item {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .option-item:hover {
        border-color: #2E7D32;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(46, 125, 50, 0.1);
    }

    .option-item.selected {
        border-color: #2E7D32;
        background: rgba(46, 125, 50, 0.05);
    }

    .option-radio {
        display: none;
    }

    .option-label {
        display: flex;
        align-items: center;
        padding: 1.25rem 1.5rem;
        margin: 0;
        cursor: pointer;
        width: 100%;
    }

    .option-letter {
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        color: #495057;
        margin-right: 1.25rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .option-radio:checked + .option-label .option-letter {
        background: #2E7D32;
        border-color: #2E7D32;
        color: white;
    }

    .option-item:hover .option-letter {
        border-color: #2E7D32;
        color: #2E7D32;
    }

    .option-text {
        font-size: 1.05rem;
        color: #495057;
        line-height: 1.5;
        flex: 1;
    }

    /* Submit Button */
    .submit-container {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f0f0f0;
    }

    .btn-submit {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Progress Bar */
    .progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: #e9ecef;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #4CAF50, #2E7D32);
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .quiz-question-container {
            padding: 60px 0 30px;
        }

        .question-header {
            padding: 1.25rem;
        }

        .question-body {
            padding: 1.5rem;
        }

        .question-text {
            font-size: 1.1rem;
            padding: 0.875rem;
        }

        .option-label {
            padding: 1rem 1.25rem;
        }

        .option-letter {
            width: 36px;
            height: 36px;
            margin-right: 1rem;
        }

        .option-text {
            font-size: 1rem;
        }

        .btn-submit {
            padding: 0.875rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .question-header {
            padding: 1rem;
        }

        .question-body {
            padding: 1.25rem;
        }

        .question-text {
            font-size: 1rem;
            padding: 0.75rem;
        }

        .option-label {
            padding: 0.875rem 1rem;
        }

        .option-letter {
            width: 32px;
            height: 32px;
            margin-right: 0.875rem;
            font-size: 0.9rem;
        }

        .option-text {
            font-size: 0.95rem;
        }
    }
</style>
@endpush

@section('content')
<div class="quiz-question-container">
    <div class="question-card">
        <!-- Header -->
        <div class="question-header">
            <h1 class="quiz-title">{{ $quiz->title }}</h1>
            <div class="question-progress">
                <i class="fas fa-question-circle"></i>
                Soal {{ count($progress->answers ?? []) + 1 }} dari {{ $progress->total_questions }}
            </div>
        </div>

        <!-- Body -->
        <div class="question-body">
            <!-- Progress Bar -->
            <div class="progress-section">
                <div class="progress-label">
                    <span>Progress Quiz</span>
                    <span>{{ count($progress->answers ?? []) + 1 }}/{{ $progress->total_questions }}</span>
                </div>
                <div class="progress">
                    <div class="progress-bar"
                         style="width: {{ ((count($progress->answers ?? []) + 1) / $progress->total_questions) * 100 }}%">
                    </div>
                </div>
            </div>

            <!-- Question -->
            <div class="question-number">
                <i class="fas fa-question"></i>
                Pertanyaan {{ count($progress->answers ?? []) + 1 }}
            </div>
            <div class="question-text">{{ $currentQuestion->question }}</div>

            <!-- Form -->
            <form action="{{ route('user.quizzes.submit', $quiz->id) }}" method="POST" id="quizForm">
                @csrf
                <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}">

                <!-- Options -->
                <div class="options-container">
                    @foreach(['a','b','c','d'] as $option)
                    <div class="option-item">
                        <input class="option-radio" type="radio"
                               name="answer" value="{{ $option }}"
                               id="opt{{ $option }}" required>
                        <label class="option-label" for="opt{{ $option }}">
                            <div class="option-letter">{{ strtoupper($option) }}</div>
                            <div class="option-text">{{ $currentQuestion->{"option_$option"} }}</div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="submit-container">
                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        <i class="fas fa-paper-plane"></i>
                        Submit Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Style radio options on click
        const optionItems = document.querySelectorAll('.option-item');
        const optionRadios = document.querySelectorAll('.option-radio');

        optionItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove selected class from all options
                optionItems.forEach(opt => {
                    opt.classList.remove('selected');
                });

                // Add selected class to clicked option
                this.classList.add('selected');

                // Check the radio button
                const radio = this.querySelector('.option-radio');
                if (radio) {
                    radio.checked = true;
                }

                // Enable submit button
                document.getElementById('submitBtn').disabled = false;
            });
        });

        // Initialize submit button as disabled
        document.getElementById('submitBtn').disabled = true;

        // Enable button when an option is selected
        optionRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('submitBtn').disabled = false;
                }
            });
        });

        // Prevent double submission
        const form = document.getElementById('quizForm');
        let isSubmitting = false;

        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            isSubmitting = true;
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        });
    });
</script>
@endpush
