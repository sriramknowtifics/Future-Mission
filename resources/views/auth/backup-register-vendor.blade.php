@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/blankLayout')

@section('title', 'Vendor Registration - Multi Step')

@section('page-style')
  {{-- keep your theme styles --}}
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
  <div class="authentication-wrapper authentication-cover">
    <a href="{{ url('/') }}" class="app-brand auth-cover-brand mb-4">
      <span class="app-brand-logo demo">@include('_partials.macros')</span>
      <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
    </a>

    <div class="authentication-inner row m-0">
      {{-- left illustration (keeps original) --}}
      <div class="d-none d-xl-flex col-xl-8 p-0">
        <div class="auth-cover-bg d-flex justify-content-center align-items-center">
          <img src="{{ asset('assets/img/illustrations/auth-register-illustration-' . $configData['theme'] . '.png') }}"
            alt="illustration" class="auth-illustration" />
        </div>
      </div>

      {{-- Registration panel --}}
      <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
        <div class="w-px-400 mx-auto mt-6">

          <h4 class="mb-1">Register as Vendor</h4>
          <p class="mb-4">Three quick steps to set up your seller account and shop.</p>

          {{-- progress --}}
          <div id="reg-progress" class="mb-3">
            <div class="progress" style="height:8px;">
              <div id="progress-bar" class="progress-bar bg-primary" role="progressbar" style="width:33%"></div>
            </div>
            <div class="d-flex justify-content-between small mt-2">
              <div><strong>Account</strong></div>
              <div><strong>Shop</strong></div>
              <div><strong>Review</strong></div>
            </div>
          </div>

          {{-- Form (single form, posted on final submit) --}}
          <form id="vendor-multi-form" action="{{ route('register.vendor.post') }}" method="POST"
            enctype="multipart/form-data" novalidate>
            @csrf

            {{-- STEP 1: Account --}}
            <div class="reg-step" data-step="1">
              <div class="mb-3">
                <label class="form-label">Full name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                  required>
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                  required>
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                  required>
                <div class="invalid-feedback"></div>
              </div>

              <div class="d-flex justify-content-between">
                <div></div>
                <button type="button" class="btn btn-primary" id="next-to-shop">Next</button>
              </div>
            </div>

            {{-- STEP 2: Shop details --}}
            <div class="reg-step d-none" data-step="2">
              <div class="mb-3">
                <label class="form-label">Shop / Business Name</label>
                <input type="text" name="shop_name" id="shop_name" class="form-control" value="{{ old('shop_name') }}"
                  required>
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Short description</label>
                <textarea name="shop_description" id="shop_description" class="form-control" rows="3">{{ old('shop_description') }}</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Category (optional)</label>
                <select name="shop_category" id="shop_category" class="form-control">
                  <option value="">Select category</option>
                  @foreach (\App\Models\Category::whereNull('parent_id')->orderBy('name')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Shop logo (optional)</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                <div class="mt-2" id="logo-preview-container" style="display:none">
                  <img id="logo-preview" src="#" alt="logo preview"
                    style="max-width:140px;max-height:80px;object-fit:cover;border:1px solid #eee;padding:4px;">
                </div>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" id="back-to-account">Back</button>
                <button type="button" class="btn btn-primary" id="next-to-review">Next</button>
              </div>
            </div>

            {{-- STEP 3: Review & Terms --}}
            <div class="reg-step d-none" data-step="3">
              <h6>Review your details</h6>
              <div class="mb-3">
                <strong>Name:</strong>
                <div id="rev-name" class="text-muted"></div>
              </div>
              <div class="mb-3">
                <strong>Email:</strong>
                <div id="rev-email" class="text-muted"></div>
              </div>
              <div class="mb-3">
                <strong>Phone:</strong>
                <div id="rev-phone" class="text-muted"></div>
              </div>
              <div class="mb-3">
                <strong>Shop name:</strong>
                <div id="rev-shop-name" class="text-muted"></div>
              </div>
              <div class="mb-3">
                <strong>Shop description:</strong>
                <div id="rev-shop-desc" class="text-muted"></div>
              </div>
              <div class="mb-3" id="rev-logo-wrap" style="display:none;">
                <strong>Logo:</strong>
                <div class="mt-2"><img id="rev-logo" src="#"
                    style="max-width:160px;max-height:100px;object-fit:cover;border:1px solid #eee;padding:4px"></div>
              </div>

              <div class="form-check mt-3 mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="terms" name="terms"
                  required>
                <label class="form-check-label" for="terms">I agree to the <a href="#" target="_blank">Terms
                    & Conditions</a>.</label>
                <div class="invalid-feedback">You must accept terms to continue.</div>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" id="back-to-shop">Back</button>
                <button type="submit" class="btn btn-success" id="final-submit">Create Vendor Account</button>
              </div>
            </div>

          </form>

          <p class="text-center mt-3 small">
            Already registered? <a href="{{ route('login') }}">Sign in</a>
          </p>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const steps = Array.from(document.querySelectorAll('.reg-step'));
      let current = 0;
      const progressBar = document.getElementById('progress-bar');

      function showStep(index) {
        steps.forEach((el, i) => {
          el.classList.toggle('d-none', i !== index);
        });
        current = index;
        progressBar.style.width = `${(index+1)/steps.length*100}%`;
      }

      // Step nav buttons
      document.getElementById('next-to-shop').addEventListener('click', () => {
        if (validateStep(0)) showStep(1);
      });
      document.getElementById('back-to-account').addEventListener('click', () => showStep(0));
      document.getElementById('next-to-review').addEventListener('click', () => {
        if (validateStep(1)) {
          fillReview();
          showStep(2);
        }
      });
      document.getElementById('back-to-shop').addEventListener('click', () => showStep(1));

      // file preview for logo
      const logoInput = document.getElementById('logo');
      const logoPreview = document.getElementById('logo-preview');
      const logoPreviewContainer = document.getElementById('logo-preview-container');
      const revLogoWrap = document.getElementById('rev-logo-wrap');
      const revLogo = document.getElementById('rev-logo');

      logoInput.addEventListener('change', function() {
        const file = this.files && this.files[0];
        if (!file) {
          logoPreviewContainer.style.display = 'none';
          revLogoWrap.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = e => {
          logoPreview.src = e.target.result;
          revLogo.src = e.target.result;
          logoPreviewContainer.style.display = 'block';
          revLogoWrap.style.display = 'block';
        };
        reader.readAsDataURL(file);
      });

      // validation helper for a step (index)
      function validateStep(index) {
        const step = steps[index];
        const requiredInputs = step.querySelectorAll('[required]');
        let ok = true;
        requiredInputs.forEach(inp => {
          inp.classList.remove('is-invalid');
          const feedback = inp.parentElement.querySelector('.invalid-feedback');
          if (inp.type === 'checkbox') {
            if (!inp.checked) {
              ok = false;
              inp.classList.add('is-invalid');
              if (feedback) feedback.textContent = 'This field is required.';
            }
          } else if (!inp.value || inp.value.trim() === '') {
            ok = false;
            inp.classList.add('is-invalid');
            if (feedback) feedback.textContent = 'This field is required.';
          } else {
            // additional password match check on step 0
            if (inp.id === 'password') {
              const pass = document.getElementById('password').value;
              const pass2 = document.getElementById('password_confirmation').value;
              if (pass.length < 6) {
                ok = false;
                inp.classList.add('is-invalid');
                if (feedback) feedback.textContent = 'Password must be at least 6 characters.';
              } else if (pass !== pass2) {
                ok = false;
                document.getElementById('password_confirmation').classList.add('is-invalid');
                if (feedback) feedback.textContent = 'Passwords do not match.';
              }
            }
          }
        });

        // highlight first invalid input
        if (!ok) {
          const first = step.querySelector('.is-invalid');
          if (first) first.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
        }
        return ok;
      }

      // fill review area
      function fillReview() {
        document.getElementById('rev-name').innerText = document.getElementById('name').value || '-';
        document.getElementById('rev-email').innerText = document.getElementById('email').value || '-';
        document.getElementById('rev-phone').innerText = document.getElementById('phone').value || '-';
        document.getElementById('rev-shop-name').innerText = document.getElementById('shop_name').value || '-';
        document.getElementById('rev-shop-desc').innerText = document.getElementById('shop_description').value || '-';
        // logo image handled by file reader above
      }

      // Final client-side submit guard
      const form = document.getElementById('vendor-multi-form');
      form.addEventListener('submit', function(e) {
        // Ensure final terms checkbox is checked
        const terms = document.getElementById('terms');
        if (!terms.checked) {
          e.preventDefault();
          terms.classList.add('is-invalid');
          terms.parentElement.querySelector('.invalid-feedback').textContent =
            'You must accept terms to continue.';
          showStep(2);
          return false;
        }
        // optional: disable submit button to prevent double-submits
        document.getElementById('final-submit').disabled = true;
        return true;
      });

      // show initial step
      showStep(0);
    });
  </script>
@endsection
