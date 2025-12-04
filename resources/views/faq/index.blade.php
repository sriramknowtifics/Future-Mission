@extends('layouts.theme')
@section('title', 'FAQ')

@section('content')

@php
    // Temporary placeholder FAQ data until DB/model is created.
    // In future: controller will pass `$faqs` from DB.
    $faqs = $faqs ?? [
        [
            'question' => 'What is your cancellation policy?',
            'answer' => 'Orders can be cancelled within 24 hours of placement if they have not been processed or shipped. To request a cancellation, contact customer support with your order number.'
        ],
        [
            'question' => 'What is your refund policy?',
            'answer' => 'Refunds are issued for damaged, defective, or incorrect items within 7 days of delivery. Products must be unused and returned in original packaging. Refunds will be processed within 5–7 business days after inspection.'
        ],
        [
            'question' => 'How long does delivery take?',
            'answer' => 'Standard delivery usually takes 2–5 business days. Express shipping options may be available depending on your location.'
        ],
        [
            'question' => 'How can I track my order?',
            'answer' => 'Once your order is shipped, a tracking link will be sent to your email and will also be visible in your account dashboard.'
        ],
        [
            'question' => 'What payment methods do you accept?',
            'answer' => 'We accept Debit/Credit Cards, PayPal, Cash on Delivery (COD), and selected digital wallets.'
        ],
    ];
@endphp

<div class="container py-5 faq-page">
    <h2 class="faq-title mb-4">Frequently Asked Questions</h2>

    <div class="faq-wrapper">

        @foreach ($faqs as $faq)
            <div class="faq-item">
                <button class="faq-question">
                    {{ $faq['question'] }}
                    <span class="toggle-icon">+</span>
                </button>
                <div class="faq-answer">
                    <p>{{ $faq['answer'] }}</p>
                </div>
            </div>
        @endforeach

    </div>
</div>

@endsection

@push('styles')
<style>
    .faq-page {
        max-width: 900px;
    }

    .faq-title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
    }

    .faq-wrapper {
        margin-top: 20px;
    }

    .faq-item {
        background: #fff;
        border-radius: 14px;
        margin-bottom: 14px;
        border: 1px solid #ececec;
        overflow: hidden;
    }

    .faq-question {
        width: 100%;
        background: none;
        border: none;
        padding: 18px;
        font-size: 17px;
        font-weight: 700;
        text-align: left;
        cursor: pointer;
        position: relative;
    }

    .faq-question .toggle-icon {
        position: absolute;
        right: 20px;
        top: 18px;
        font-size: 20px;
        font-weight: bold;
        transition: transform .2s;
    }

    .faq-item.active .faq-question .toggle-icon {
        transform: rotate(45deg);
    }

    .faq-answer {
        display: none;
        padding: 0 18px 18px;
        color: #475569;
        font-size: 15px;
        line-height: 1.6;
    }

    .faq-item.active .faq-answer {
        display: block;
    }
</style>
@endpush


@push('scripts')
<script>
document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const parent = btn.closest('.faq-item');
        parent.classList.toggle('active');
    });
});
</script>
@endpush
