@extends('layouts.admin')

@section('title', 'Create New Category')

@section('content')
    <style>
        .form-input:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2) !important;
        }

        .btn-cancel:hover {
            background-color: var(--bg-primary) !important;
            opacity: 0.8;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        /* Mobile responsive styling for create category */
        @media (max-width: 768px) {
            .max-w-4xl {
                padding: 0 1rem;
            }

            .rounded-lg {
                margin: 0 -1rem;
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            h1 {
                font-size: 1.5rem;
            }

            input {
                font-size: 1rem;
                padding: 0.75rem !important;
            }

            .flex.items-center.justify-end {
                flex-direction: column;
                gap: 0.5rem;
            }

            .flex.items-center.justify-end a,
            .flex.items-center.justify-end button {
                width: 100%;
                text-align: center;
                margin: 0;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.25rem;
            }

            input {
                font-size: 0.875rem;
                padding: 0.625rem !important;
            }

            label {
                font-size: 0.875rem;
            }
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <div class="rounded-lg p-4 sm:p-6"
            style="background-color: var(--bg-secondary); border: 1px solid var(--border-color);">
            <h1 class="text-xl sm:text-2xl font-bold mb-6" style="color: var(--text-primary);">Create New Category</h1>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block mb-2" style="color: var(--text-primary);">Category Name</label>
                    <input type="text" name="name" id="name"
                        class="form-input w-full rounded-lg px-4 py-2 transition-colors focus:outline-none"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary);"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-sm mt-1" style="color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end mt-6 gap-2 sm:gap-0">
                    <a href="{{ route('admin.categories.index') }}"
                        class="btn-cancel font-bold py-2 px-4 rounded-xl sm:mr-2 transition-colors w-full sm:w-auto text-center order-2 sm:order-1"
                        style="background-color: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-secondary); text-decoration: none;">
                        Cancel
                    </a>
                    <button type="submit"
                        class="btn-primary font-bold py-2 px-4 rounded-xl transition-colors w-full sm:w-auto order-1 sm:order-2"
                        style="background-color: var(--accent-color); color: white; border: none; cursor: pointer;">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection