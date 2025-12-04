<form action="{{ route('checkout.address.store') }}" method="POST" class="premium-form">
    @csrf

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Address Type*</label>
            <select name="type" required class="form-select">
                <option value="home">Home</option>
                <option value="work">Work</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Phone*</label>
            <input name="phone" required class="form-control">
        </div>

        <div class="col-12">
            <label class="form-label">Address Line*</label>
            <input name="address_line" required class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">City*</label>
            <input name="city" required class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">State*</label>
            <input name="state" required class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Zip*</label>
            <input name="zip_code" required class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Country*</label>
            <input name="country" required class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Label (optional)</label>
            <input name="label" class="form-control">
        </div>
    </div>

    <button class="premium-btn-primary mt-3 w-100">Save Address</button>
</form>
